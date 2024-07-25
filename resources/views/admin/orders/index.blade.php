@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-12 text-gray-800">List Products</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of all products</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="d-sm-block d-md-block d-lg-none dl-xl-none">
                                    @forelse($orders as $order)
                                    <div class="card ">
                                        <div class="card-body fs-1">
                                                <div class="row">
                                                   <div class="col"><h5>Order #</h5></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">{{ $order->order_id }}</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col"><h5>Amount</h5></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">{{ $order->amount }} {{ $order->currency }}</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col"><h5>Customer</h5></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">{{ $order->payer_name }}</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col"><h5>E-Mail</h5></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">{{ $order->payer_email }}</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col"><h5>Status</h5></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">{{ $order->status }}</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col"><h5>Country</h5></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">{{ $order->payer_country }}</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col"><h5>Updated</h5></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">{{ $order->updated_at->format('d/m/Y H:s') }}</div>
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
                                                <td><a href="">{{ $order->order_id }}</a></td>
                                                <th>{{ $order->amount }} {{ $order->currency }}</th>
                                                <td>{{ $order->payer_name }}</td>
                                                <td>{{ $order->payer_email }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>{{ $order->payer_country }}</td>
                                                <td>{{ $order->updated_at->format('d/m/Y H:s') }}</td>
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
    @include('admin/partials/product_modals')
@endsection
