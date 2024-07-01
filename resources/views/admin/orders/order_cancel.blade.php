@extends('layouts.admin')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justity-content-between">
            <h3>Order Cancel Request</h3>
            <a href="{{ route('orders') }}" class="btn btn-primary">Order list</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Order Id</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ( $order_cancel as $order)
                 <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->rel_to_customer->fname.' '.$order->rel_to_customer->lname }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->discount }}</td>
                    <td>{{ $order->charge }}</td>
                    <td>
                        @if ($order->Status == 0)
                            <span class="badge badge-light">placed</span>
                            @elseif ($order->Status == 1)
                            <span class="badge badge-secondary">processing</span>
                            @elseif ($order->Status == 2)
                            <span class="badge badge-primary">shipped</span>
                            @elseif ($order->Status == 3)
                            <span class="badge badge-success">Out for Delivery</span>
                            @elseif ($order->Status == 4)
                            <span class="badge badge-info">Delivered</span>
                            @elseif ($order->Status == 5)
                            <span class="badge badge-danger">Cancel</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('order.status.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                          <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Change status
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button name="Status" class="dropdown-item" style="color:{{ $order->Status==5?'blue':' ' }}"value="5">Cancel</button>
                          </div>
                          </div>
                        </form>
                    </td>
                 </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
