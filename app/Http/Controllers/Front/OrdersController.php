<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Services\OrderService;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use App\Http\Services\PriceService;
use App\Http\Traits\CartTrait;
use App\Mail\OrderCreatedToBuyer;
use App\Mail\OrderCreatedToSeller;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;


class OrdersController extends Controller
{
    use CartTrait;

    private string $accessToken;
    private PaymentGatewayInterface $gateway;

    public function __construct(
        private readonly PriceService $priceService
    ) {}

    public function createOrder(OrderRequest $request)//: JsonResponse
    {
        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->route('front.index');
        }

        $data = $request->validated();

        $data['status'] = 'Pending';

        $data['order_id'] = $this->generateOrderNumber();
        $data['order_num'] = $this->getLastOrderNum();

        $data['amount'] = 0;

        foreach($cart as $item) {
            $data['amount'] += $item['real_price'];
        }

        $data['currency'] = config('currencies')[App::getLocale()];

        $order = Orders::create($data);

        $totalPrice = 0;
        foreach($cart as $item) {
            $product = Product::find($item['product_id']);
            $totalPrice += $item['quantity'] * $product->price;

            if(!$product->has_qty) {
                $product->update(['sold' => true]);
            }

            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['real_price'],
                'currency' => $order->currency,
            ]);
        }

        //$order->load(['items', 'items.product', 'items.product.category']);

        //$orderService = new OrderService();
        //$invoice = $orderService->makeInvoice($order);

//        Mail::to($data['payer_email'])->send(new OrderCreatedToBuyer($order,(string) $totalPrice, $invoice));
//        Mail::to(config('mail.to_admin_email'))->send(new OrderCreatedToSeller($order));

        session()->forget('cart');

        session()->put('myOrder', $order->id);

        return redirect()->route('front.payment_and_delivery');
    }

    public function completed()
    {
        return view('front.orders.complete');
    }

    public function updateOrder(Request $request)
    {
        $status = 417;

        if ($this->sessionStorageService->check('current_payment_order_id')) {
            $currentOrder = $this->orderService->findOrderByIdAndPaymentId(
                $this->sessionStorageService->get('current_payment_order_id'),
                $request->orderId
            );

            $this->gateway = $this->orderService->getPaymentGateway($request->paymentMethod);
            $this->accessToken = $this->gateway->getAuthToken();

            try {
                $payResult = $this->gateway->captureAndPay(['orderId' => $request->orderId], $this->accessToken);

                if(isset($payResult['status']) && $payResult['status'] === 'COMPLETED') {
                    $order = $this->orderService->updateOrderPaymentSuccess($currentOrder, $payResult['id']);
                    $this->sessionStorageService->store('payment_id', $payResult['id']);

                    $status = 200;
                    Mail::to(config('mail.to_admin_email'))->send(new OrderCreatedToSeller($order));
                }

                $this->cartService->cleanupForSession();
                $this->orderService->cleanupForSession();

                return response()->json($payResult, $status);
            } catch(\RuntimeException $e) {
                throw $e;
            }
        }
    }
}
