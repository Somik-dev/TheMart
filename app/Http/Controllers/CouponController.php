<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',[
            'coupons'=>$coupons,
        ]);
    }
    function coupon_store(Request $request){
        Coupon::insert([
         'coupon'=>$request->coupon,
         'type'=>$request->type,
         'amount'=>$request->amount,
         'limit'=>$request->limit,
         'validity'=>$request->validity,
         'created_at'=>Carbon::now(),
        ]);
        return back();
    }
    function CouponchangeStatus(Request $request){
        Coupon::find($request->coupon_id)->update([
           'status'=>$request->status,
        ]);
    }
    function coupon_delete($id){
      Coupon::find($id)->delete();
      return back();
    }
}
