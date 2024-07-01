<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Billing;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    function checkout(){
        $countries = Country::all();
        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.customer.checkout',[
            'carts'=>$carts,
            'countries'=>$countries,
        ]);
    }
    function getCity(Request $request){
        $str = '<option  value=""> select city</option>';
         $cities = City::where('country_id', $request->country_id)->get();
         foreach($cities as $city){
           $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
         }
         echo $str;
    }
    function getCity2(Request $request){
        $str = '<option  value=""> select city</option>';
         $cities = City::where('country_id', $request->country_id)->get();
         foreach($cities as $city){
           $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
         }
         echo $str;
    }

    function order_store(Request $request){
      if($request->payment_method == 1){
        $order_id = '#'.uniqid().random_int(100000,999999);
        Order::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customer')->id(),
            'discount'=>$request->discount,
            'charge'=>$request->charge,
            'payment_method'=>$request->payment_method,
            'sub_total'=>$request->sub_total,
            'total'=>$request->sub_total + $request->charge - ($request->discount),
            'created_at' => Carbon::now(),
        ]);
        billing::insert([
          'order_id'=>$order_id,
          'customer_id'=>Auth::guard('customer')->id(),
          'fname'=>$request->fname,
          'lname'=>$request->lname,
          'country_id'=>$request->country,
          'city_id'=>$request->city,
          'zip'=>$request->Zip,
          'company'=>$request->company,
          'email'=>$request->email,
          'phone'=>$request->phone,
          'address'=>$request->address,
          'massage'=>$request->massage,
          'created_at' => Carbon::now(),
        ]);

            if($request->ship_check == 1){
                Shipping::insert([
                    'order_id'=>$order_id,
                    'ship_fname'=>$request->ship_fname,
                    'ship_lname'=>$request->ship_lname,
                    'ship_country_id'=>$request->ship_country,
                    'ship_city_id'=>$request->ship_city,
                    'ship_zip'=>$request->ship_zip,
                    'ship_company'=>$request->ship_company,
                    'ship_email'=>$request->ship_email,
                    'ship_phone'=>$request->ship_phone,
                    'ship_adress'=>$request->ship_adress,
                    'created_at' => Carbon::now(),
                  ]);
            }else{
                Shipping::insert([
                    'order_id'=>$order_id,
                    'ship_fname'=>$request->fname,
                    'ship_lname'=>$request->lname,
                    'ship_country_id'=>$request->country,
                    'ship_city_id'=>$request->city,
                    'ship_zip'=>$request->zip,
                    'ship_company'=>$request->company,
                    'ship_email'=>$request->email,
                    'ship_phone'=>$request->phone,
                    'ship_adress'=>$request->address,
                    'created_at' => Carbon::now(),
                  ]);

            }


             $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
             foreach($carts as $cart){
              OrderProduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customer')->id(),
                'product_id' => $cart->product_id,
                'price' => $cart->rel_to_product->after_discount,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
                'quantity' => $cart->quantity,
                'created_at' => Carbon::now(),
              ]);

              Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);

            //   Cart::find($cart->id)->delete();

             }

        Mail::to($request->email)->send(new InvoiceMail($order_id));
        return redirect()->route('order.success');
      }
      elseif($request->payment_method == 2){
        $data = $request->all();
        return redirect()->route('pay')->with('data', $data);
      }
      elseif($request->payment_method == 3){
        $data = $request->all();
        return redirect()->route('stripe')->with('data', $data);
      }
    }
    function order_success(){
        return view('frontend.customer.order_success');
    }
}
