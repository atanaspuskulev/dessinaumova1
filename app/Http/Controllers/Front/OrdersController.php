<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function captureAndComplete(Request $request)
    {
        return view('front.orders.complete');
    }

    public function captureAndCancel(Request $request)
    {
        return view('front.orders.cancel');
    }

    public function createOrder(Request $request)
    {
        print_r($request->all());exit;
    }
}
