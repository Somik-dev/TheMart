<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    function orders(){
        $orders = Order::latest()->get();
        return view('admin.orders.orders',[
            'orders'=>$orders,
        ]);
    }
    function order_status_update(Request $request){
        Order::where('order_id', $request->order_id )->update([
            'Status'=>$request->Status,
         ]);

         if(Order::where('order_id', $request->order_id )->where('order_cancel',1)){

            Order::where('order_id', $request->order_id )->where('order_cancel',1)->update([
                'order_cancel'=>2,
            ]);

            $products = OrderProduct::where('order_id',$request->order_id)->get();
            foreach( $products as $product){
                Inventory::where('product_id', $product->product_id)->where('color_id', $product->color_id)->where('size_id', $product->size_id)->increment('quantity', $product->quantity);
            }

         }
         return back();
    }
    function order_cancel_req(){
        $order_cancel= Order::where('order_cancel', 1)->get();
        return view('admin.orders.order_cancel', [
         'order_cancel'=> $order_cancel,
        ]);
    }
}
