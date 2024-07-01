@extends('layouts.admin')

@section('content')
<div class="col-lg-12">
    <div class="card-header">
        <h3>Product Details</h3>
        <a href="{{ route('product.list') }}" class="btn btn-primary"><i class="fa fa-list"></i>product list</a>
    </div>
    <div class="card-body">
       <table class="table table-bordered">
        <tr>
            <td>Product Name</td>
            <td>{{ $product->product_name }}</td>
        </tr>
        <tr>
            <td>Price</td>
            <td>{{ $product->price }}</td>
        </tr>
        <tr>
            <td>Short Desp</td>
            <td>{{ $product->short_desp }}</td>
        </tr>
        <tr>
            <td>Long Desp</td>
            <td>{!! $product->long_desp !!}</td>
        </tr>
        <tr>
            <td>Previwe</td>
            <td><img width="150" src="{{ asset('uploads/products/preview') }}/{{ $product->preview }}" alt=""></td>
        </tr>
        <tr>
            <td>Gallery</td>
            <td>
                @foreach ($galleries as $gallery)
                    <img width="200" src="{{ asset('uploads/products/gallery') }}/{{ $gallery->gallery }}" alt="">
                @endforeach
            </td>
        </tr>
       </table>
    </div>
</div>
@endsection
