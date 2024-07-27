@extends('layouts.admin')

@section('head_content')
    <style>
        .order-content {
            max-width: 95% !important;
        }
    </style>
@endsection

@section('content')
    <h1 class="h3 mb-12 text-gray-800">List Products</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <b class="m-0 font-weight-bold text-primary">List of all products</b>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="d-sm-block d-md-block d-lg-none dl-xl-none">
                                    @forelse($orders as $order)
                                        <div class="card ">
                                            <div class="card-body small bg-gray-200">
                                                <div class="row">
                                                   <div class="col"><b>Order #</b></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">{{ $order->order_id }}</div>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col"><b>Amount</b></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">{{ $order->amount }} {{ $order->currency }}</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col"><b>Customer</b></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">{{ $order->payer_name }}</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col"><b>E-Mail</b></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">{{ $order->payer_email }}</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col"><b>Status</b></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">{{ $order->status }}</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col"><b>Country</b></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">{{ $order->payer_country }}</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col"><b>Updated</b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        No orders available
                                    @endforelse
                                </div>
                                <div class="d-none d-lg-block">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Country</th>
                                            <th scope="col">Updated</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($orders as $order)
                                            <tr>
                                                <td><a href="javascript:viewOrder({{ $order->id }}, '{{ $order->order_id }}', '{{ route("admin.view_order") }}');">{{ $order->order_id }}</a></td>
                                                <th>{{ $order->amount }} {{ $order->currency }}</th>
                                                <td>{{ $order->payer_name }}</td>
                                                <td>{{ $order->payer_email }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>{{ $order->payer_country }}</td>
                                                <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">There are no orders yet</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin/partials/order_modal')
@endsection
