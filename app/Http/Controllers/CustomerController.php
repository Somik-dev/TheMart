<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use PDF;

class CustomerController extends Controller
{
    function customer_profile(){
        return view('frontend.customer.profile');
    }
    function customer_logout(){
       Auth::guard('customer')->logout();
       return redirect('/');
    }

    function customer_profile_update(Request $request){
     if($request->password == ''){
        if($request->photo == ''){
           Customer::find(Auth::guard('customer')->id())->update([
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'country'=>$request->country,
            'zip'=>$request->zip,
            'address'=>$request->address,
           ]);
           return back()->with('success', 'Profile Updated');
        }
        else{

            if(Auth::guard('customer')->user()->photo != null ){
                $delete_from = public_path('uploads/customer/' . Auth::guard('customer')->user()->photo);
                unlink($delete_from);
            }


            $image = $request->photo;
            $extension = $image->extension();
            $file_name = Auth::guard('customer')->id().'.'.$extension;
            Image::make($image)->save(public_path('uploads/customer/'.$file_name));
            Customer::find(Auth::guard('customer')->id())->update([
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'country'=>$request->country,
                'zip'=>$request->zip,
                'photo'=> $file_name,
                'updated'=> Carbon::now(),
               ]);
               return back()->with('success', 'Profile Updated');
        }
     }
     else{
        if($request->photo == ''){
            Customer::find(Auth::guard('customer')->id())->update([
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'phone'=>$request->phone,
                'country'=>$request->country,
                'zip'=>$request->zip,
                'address'=>$request->address,
               ]);
               return back()->with('success', 'Profile Updated');
        }
        else{

            if(Auth::guard('customer')->user()->photo != null ){
                $delete_from = public_path('uploads/customer/' . Auth::guard('customer')->user()->photo);;
                unlink($delete_from);
            }

            $image = $request->photo;
            $extension = $image->extension();
            $file_name = Auth::guard('customer')->id().'.'.$extension;
            Image::make($image)->save(public_path('uploads/customer/'.$file_name));
            Customer::find(Auth::guard('customer')->id())->update([
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'phone'=>$request->phone,
                'country'=>$request->country,
                'zip'=>$request->zip,
                'photo'=> $file_name,
                'updated'=> Carbon::now(),
               ]);
               return back()->with('success', 'Profile Updated');
        }
     }
    }
    function customer_order(){
        $myorders = Order::where('customer_id', Auth::guard('customer')->id())->latest()->paginate(5);
        return view('frontend.customer.order',[
            'myorders'=>$myorders,
        ]);
    }
    function order_invoice_download($id){
        $order_info = Order::find($id);
        $pdf = PDF::loadView('frontend.invoice.invoice',[
            'order_id'=>$order_info->order_id,
        ]);

        return $pdf->download('itsolutionstuff.pdf');
    }
   function cancel_myorder($id){
    Order::find($id)->update([
       'order_cancel'=>1,
    ]);
    return back();
   }
}
