@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="product.html">Product</a></li>
                        <li>Customer profile</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->
 <!-- product-single-section  start-->
 <div class="container">
    <div class="row my-5">
        <div class="col-lg-3">
            <div class="card text-center py-3">
                @if (Auth::guard('customer')->user()->photo == null)
                <img style="width:60px; height:60px; border-radius:50%;" class="m-auto" src="{{ Avatar::create(Auth::guard('customer')->user()->fname)->toBase64() }}" />
                @else
                <img style="width:60px; height:60px; border-radius:50%;" class="m-auto" src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}" alt=""></td>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ Auth::guard('customer')->user()->fname.' ' .Auth::guard('customer')->user()->lname}}</h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item bg-light py-3">Update Profile</li>
                  <li class="list-group-item bg-light py-3"><a href="{{ route('customer.order') }}">My Order</a></li>
                  <li class="list-group-item bg-light py-3">whishlist</li>
                  <li class="list-group-item bg-light py-3"><a href="{{ route('customer.logout') }}">logout</a></li>
                </ul>
              </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>Update Profile Information</h3>
                </div>
                @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
                <div class="card-body">
                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="fname" value="{{ Auth::guard('customer')->user()->fname }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lname" value="{{ Auth::guard('customer')->user()->lname }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ Auth::guard('customer')->user()->email }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Phone</label>
                                    <input type="number" class="form-control" name="phone"
                                    value="{{ Auth::guard('customer')->user()->phone }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Country</label>
                                    <input type="text" class="form-control" name="country" value="{{ Auth::guard('customer')->user()->country }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Zip</label>
                                    <input type="text" class="form-control" name="zip"  value="{{ Auth::guard('customer')->user()->zip }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Photo</label>
                                    <input type="file" class="form-control" name="photo">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address"  value="{{ Auth::guard('customer')->user()->address }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3 text-center my-3">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection
