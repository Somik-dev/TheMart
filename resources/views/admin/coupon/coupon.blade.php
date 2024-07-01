@extends('layouts.admin')
@section('content')
 <div class="col-lg-9">
    <div class="card">
        <div class="card-header">
            <h3>Coupon List</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>SL</th>
                    <th>Coupon</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Validity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
               @foreach ($coupons as $sl=>$coupon)
                   <tr>
                    <td>{{ $sl+1 }}</td>
                    <td>{{ $coupon->coupon }}</td>
                    <td>{{ $coupon->type==1?'Persentage':'Solid' }}</td>
                    <td>{{ $coupon->amount }} {{ $coupon->type==1?'%':'Taka' }}</td>
                    <td>
                      @if (Carbon\Carbon::now() > $coupon->validity)
                           <span class="badge badge-warning">Expired</span>
                      @else

                      <span class="badge badge-success">{{ Carbon\Carbon::now()->diffInDays($coupon->validity, false) }} Days Left</span>

                      @endif
                    </td>
                        <td><input data-id="{{ $coupon->id }}" {{ $coupon->status == 1?'checked':'' }} class="check" type="checkbox" data-toggle="toggle" value="{{ $coupon->status }}" data-size="sm"></td>
                        <td>
                            <a title="Delete" href="{{ route('coupon.delete',$coupon->id) }}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                        </td>
                   </tr>
               @endforeach
            </table>
        </div>
    </div>
 </div>
 <div class="col-lg-3">
    <div class="card">
        <div class="card-header">
            <head>Add New Coupon</head>
        </div>
        <div class="card-body">
            <form action="{{ route('coupon.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Coupon Name</label>
                    <input type="text" name="coupon" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Coupn Type</label>
                    <select name="type" class="form-control">
                        <option value="0">Select Coupon</option>
                        <option value="1">Persentage</option>
                        <option value="32">Solid</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Coupon Amount</label>
                    <input type="number" name="amount" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Coupon Limit</label>
                    <input type="number" name="limit" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Coupon Validity</label>
                    <input type="date" name="validity" class="form-control">
                </div>
                <div class="mb-3">
                   <button type="submit" class="btn btn-primary">Add Coupon</button>
                </div>
            </form>
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
      var coupon_id = $(this).attr('data-id');

      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
         });

         $.ajax({
          type:'POST',
          url:'/CouponchangeStatus',
          data:{'coupon_id': coupon_id, 'status':status},
          success:function(data){
          }
         });
    });
</script>
@endsection
