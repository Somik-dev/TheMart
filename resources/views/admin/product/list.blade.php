@extends('layouts.admin')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
                <a href="{{ route('product') }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add product</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        {{-- <th>Category</th>
                        <th>Subcategory</th> --}}
                        <th>Status</th>
                        <th>Brand</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>After Discount</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($products as $sl=>$product)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        {{-- <td>{{ $product->rel_to_category->category_name }}</td>
                        <td>{{ $product->rel_to_subcategory->category_name }}</td> --}}
                        <td><input data-id="{{ $product->id }}" {{ $product->status == 1?'checked':'' }} class="check" type="checkbox" data-toggle="toggle" value="{{ $product->status }}" data-size="sm"></td>
                        <td>{{ $product->rel_to_brand->brand_name }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount }}</td>
                        <td>{{ $product->after_discount }}</td>
                        <td>
                            <img width="100" src="{{ asset('uploads/products/preview') }}/{{ $product->preview }}" alt="">
                        </td>
                        <td>
                            <div class="d-flex">
                                <a title="Inventory" href="{{ route('inventory',$product->id) }}" class="btn btn-success shadow btn-xs sharp del_btn"><i class="fa fa-archive"></i></a>
                                &nbsp;
                                <a title="viwe" href="{{ route('product.show',$product->id) }}" class="btn btn-info shadow btn-xs sharp del_btn"><i class="fa fa-eye"></i></a>
                                &nbsp;
                                <a title="Delete" href="{{ route('product.delete',$product->id) }}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
<script>
    $('.check').change(function(){
      if($(this).val() == 1){
         $(this).attr('value', 0);
      }
      else{
        $(this).attr('value', 1);
      }

      var status = $(this).val();
      var product_id = $(this).attr('data-id');

      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
         });

         $.ajax({
          type:'POST',
          url:'/changeStatus',
          data:{'product_id': product_id, 'status':status},
          success:function(data){

          }
         });
    });
</script>
@endsection
