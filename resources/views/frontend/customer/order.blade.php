@extends('frontend.master')
@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-lg-3">
            <div class="card text-center py-3">
                @if (Auth::guard('customer')->user()->photo == null)
                <img width="70" class="m-auto" src="{{ Avatar::create(Auth::guard('customer')->user()->fname)->toBase64() }}" />
                @else
                <img width="70" class="m-auto" src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}" alt=""></td>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ Auth::guard('customer')->user()->fname.' ' .Auth::guard('customer')->user()->lname}}</h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item bg-light py-3">Update Profile</li>
                  <li class="list-group-item bg-light py-3">My Order</li>
                  <li class="list-group-item bg-light py-3">whishlist</li>
                  <li class="list-group-item bg-light py-3"><a href="{{ route('customer.logout') }}">logout</a></li>
                </ul>
              </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>My Order</h3>
                </div>
                <div class="card-body">
                   <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ( $myorders as  $sl=>$myorder)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $myorder->order_id }}</td>
                        <td>{{ $myorder->total }}</td>
                        <td>
                         @if ($myorder->Status == 0)
                            <span class="badge bg-secondary">Placed</span>
                        @elseif ($myorder->Status == 1)
                        <span class="badge bg-info">Processing</span>
                        @elseif ($myorder->Status == 2)
                        <span class="badge bg-primary">Shiped</span>
                        @elseif ($myorder->Status == 3)
                        <span class="badge bg-success">Ready to Deliver</span>
                        @elseif ($myorder->Status == 4)
                        <span class="badge bg-danger">Received</span>
                        @elseif ($myorder->Status == 5)
                        <span class="badge bg-warning">Cancel</span>
                         @endif
                        </td>
                        <td>
                           @if ($myorder->Status != 5)
                           <a href="{{ route('cancel.myorder', $myorder->id) }}" class="btn btn-danger">Cancel Order</a>
                           <a href="{{ route('order.invoice.download', $myorder->id) }}" class="btn btn-success">Download Invoice</a>
                           @endif

                        </td>
                    </tr>
                    @endforeach
                   </table>
                   {{ $myorders->links() }}
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection
