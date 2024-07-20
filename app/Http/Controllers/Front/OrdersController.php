<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Helpers\CountriesHelper;
use App\Http\Controllers\Controller;
use App\Http\Enums\OrderEnum;
use App\Http\Services\OrderService;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use App\Mail\OrderCancelled;
use App\Mail\OrderCompletedToBuyer;
use App\Mail\OrderCreatedToBuyer;
use App\Mail\OrderCreatedToSeller;
use App\Models\Orders;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class OrdersController extends Controller
{
    use CartTrait;

    private string $accessToken;
    private PaymentGatewayInterface $gateway;

    public function __construct(
        protected OrderService $orderService,
        private readonly SessionStorageService $sessionStorageService
    )
    {}

    public function captureAndComplete(): View|RedirectResponse
    {
        if(!$this->sessionStorageService->check('current_payment_order_id') || !$this->sessionStorageService->check('payment_id')) {
            return redirect(route('front.index'));
        }

        $order = Orders::where('id', $this->sessionStorageService->get('current_payment_order_id'))
            ->where('order_id', $this->sessionStorageService->get('payment_id'))
            ->first();

        $invoice = $this->orderService->makeInvoice($order);

        Mail::to($order->payer_email)->queue(new OrderCompletedToBuyer($order, $invoice));

        $this->orderService->clearOrderSession('current_payment_order_id');
        $this->orderService->clearOrderSession('current_order_id');

        return view('front.orders.complete', compact('order'));
    }

    public function captureAndCancel(Request $request)
    {
        if($request->has('orderID') && $this->sessionStorageService->check('current_payment_order_id')) {
            $this->orderService->cancelOrder($this->sessionStorageService->get('current_payment_order_id'), $request->orderID);
        }
        return view('front.orders.cancel');
    }

    public function cancelOrder(Request $request): JsonResponse
    {
        if ($request->has('orderID') && $this->sessionStorageService->check('current_payment_order_id')) {
            $this->orderService->cancelOrder($this->sessionStorageService->get('current_payment_order_id'), $request->orderID);
        }

        $this->clearCartSession();

        return response()->json([]);
    }

    public function createOrder(Request $request): JsonResponse
    {
        $status = true;
        $data = [];

        if ($this->sessionStorageService->check('current_payment_order_id')) {
            $order = Orders::find($this->sessionStorageService->get('current_payment_order_id'));
            $data['id'] = $order->order_id;
            return response()->json(compact('status', 'data'));
        }

        try {
            $productsIds = [];
            $prices = collect();

            $requestOrder = $request['order'];

            foreach ($requestOrder['purchase_units'] as $unit) {
                $productsIds[] = $unit['reference_id'];
                $prices->push($unit['amount']['value']);
            }

            $orderData = [
                'order_id' => '',
                'status' => OrderEnum::PENDING->value,
                'amount' => $this->calculateCartAmount($prices),
                'currency' => config('paypal.currency'),
                'payer_name' => $requestOrder['shipping']['name']['full_name'],
                'payer_email' => $requestOrder['payer']['email_address'],
                'payer_phone' => $requestOrder['payer']['phone']['phone_number']['national_number'],
                'payer_country' => CountriesHelper::getCountryNameByCode($requestOrder['shipping']['address']['country_code']),
                'payer_country_code' => $requestOrder['shipping']['address']['country_code'],
                'payer_state' => $requestOrder['shipping']['address']['admin_area_1'],
                'payer_city' => $requestOrder['shipping']['address']['admin_area_2'],
                'payer_zip' => $requestOrder['shipping']['address']['postal_code'],
                'payer_address' => $requestOrder['shipping']['address']['address_line_1'],
                'additional_information' => $requestOrder['merchant_preferences']['note_to_merchant']
            ];

            $this->gateway = $this->orderService->getPaymentGateway($request->paymentMethod);
            $this->accessToken = $this->gateway->getAuthToken();
            $capture = $this->gateway->createOrder(['products' => $productsIds, 'order' => $orderData], $this->accessToken);

            if($capture['status'] !== 'CREATED' || empty($capture['id'])) {
                throw new \RuntimeException('Failed to create Order via Payment Gateway.');
            }

            $data['id'] = $capture['id'];
            $orderData['order_id'] = $capture['id'];

            $order = $this->orderService->createOrderWithItems($orderData, $productsIds);

            $this->sessionStorageService->store('current_payment_order_id', $order->id);

            Mail::to($orderData['payer_email'])->queue(new OrderCreatedToBuyer());
            Mail::to($requestOrder['payer']['email_address'])->queue(new OrderCreatedToBuyer());
        } catch (\Exception $e) {
            $message = sprintf(
                'An error occurred while trying to create user order and send email: %s',
                $e->getMessage()
            );

            Log::emergency($message);

            $status = false;
        }

        return response()->json(compact('status', 'data'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
                    Mail::to(config('mail.to_admin_email'))->queue(new OrderCreatedToSeller($order));
                }
                $this->clearCartSession();
                return response()->json($payResult, $status);
            } catch(\RuntimeException $e) {
                throw $e;
            }
        }
    }
}
