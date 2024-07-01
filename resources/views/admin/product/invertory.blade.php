@extends('layouts.admin')
@section('content')
 <div class="col-lg-8">
    <div class="card">
        <div class="card-header"> <h3>Inventory of,</h3> <strong>{{ $product->product_name }}</strong></div>
        <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th>Color</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Action</th>
              </tr>
              @foreach ($inventory as $inventory)
                  <tr>
                    <td>{{ $inventory->rel_to_color->color_name }}</td>
                    <td>{{ $inventory->rel_to_size->size_name }}</td>
                    <td>{{ $inventory->quantity }}</td>
                    <td>
                        <a href="" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
              @endforeach
            </table>
        </div>
    </div>
 </div>
 <div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Add Inventory</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
            <form action="{{ route('inventory.store', $product->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Product</label>
                    <input type="text" disabled value="{{ $product->product_name }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Color</label>
                    <select class="form-control" name="color_id" id="">
                        <option value="">Select Color</option>
                        @foreach ($colors as $color)
                           <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Size</label>
                    <select class="form-control" name="size_id" id="">
                        <option value="">Select Size</option>
                        @foreach (App\Models\size::where('category_id', $product->category_id)->get() as $size)
                           <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Quantity</label>
                    <input type="text" name="quantity" class="form-control">
                </div>
                <div class="mb-3">
                   <button type="submit" class="btn btn-primary">Add Inventory</button>
                </div>
            </form>
        </div>
    </div>
 </div>
@endsection
