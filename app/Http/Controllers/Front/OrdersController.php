<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CountriesHelper;
use App\Http\Controllers\Controller;
use App\Http\Enums\OrderEnum;
use App\Http\Traits\CartTrait;
use App\Mail\OrderCreatedToBuyer;
use App\Models\Orders;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class OrdersController extends Controller
{
    use CartTrait;

    public function captureAndComplete(): View
    {
        return view('front.orders.complete');
    }

    public function captureAndCancel(): View
    {
        return view('front.orders.cancel');
    }

    public function cancelOrder(Request $request): JsonResponse
    {
        if ($request->has('orderID') && session()->has('current_payment_order_id')) {
            $order = Orders::find(session()->get('current_payment_order_id'));
            $order->order_id = $request->orderID;
            $order->status = OrderEnum::CANCELED->value;
            $order->cancelled_at = now()->toDateString();
            $order->save();
        }

        $this->clearCartSession();

        return response()->json([]);
    }

    public function createOrder(Request $request): JsonResponse
    {
        $status = true;

        if (session()->has('current_payment_order_id')) {
            return response()->json(compact('status'));
        }

        try {
            $productsIds = [];

            foreach ($request['purchase_units'] as $unit) {
                $productsIds[] = $unit['reference_id'];
            }

            $orderData = [
                'order_id' => '',
                'status' => OrderEnum::PENDING->value,
                'amount' => $this->calculateCartAmount($productsIds),
                'currency' => config('paypal.currency'),
                'payer_name' => $request['shipping']['name']['full_name'],
                'payer_email' => $request['payer']['email_address'],
                'payer_phone' => $request['payer']['phone']['phone_number']['national_number'],
                'payer_country' => CountriesHelper::getCountryNameByCode($request['shipping']['address']['country_code']),
                'payer_country_code' => $request['shipping']['address']['country_code'],
                'payer_state' => $request['shipping']['address']['admin_area_1'],
                'payer_city' => $request['shipping']['address']['admin_area_2'],
                'payer_address' => $request['shipping']['address']['address_line_1'],
                'additional_information' => $request['merchant_preferences']['note_to_merchant']
            ];

            $order = Orders::create($orderData);

            foreach ($productsIds as $productId) {
                $order->items()->create(['product_id' => $productId]);
            }

            Mail::to($request['payer']['email_address'])->queue(new OrderCreatedToBuyer());

            session()->put('current_payment_order_id', $order->id);
        } catch (\Exception) {
            $status = false;
        }

        return response()->json(compact('status'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $status = 417;

        if (session()->has('current_payment_order_id')) {
            $currentOrder = Orders::find(session()->get('current_payment_order_id'));
            $currentOrder->status = OrderEnum::COMPLETED->value;
            $currentOrder->order_id = $request['id'];
            $currentOrder->confirmed_at = now()->toDateString();
            $currentOrder->save();
            $status = 200;
        }

        $this->clearCartSession();

        return response()->json([], $status);
    }
}
