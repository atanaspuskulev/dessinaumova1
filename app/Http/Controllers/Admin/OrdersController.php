<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Orders::orderBy('updated_at', 'desc')->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }
}
