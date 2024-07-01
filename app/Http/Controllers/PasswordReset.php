<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PasswordResset;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PasswordRessetNotificaton;

class PasswordReset extends Controller
{

function password_reset(){

return view('frontend.customer.password_reset');

}


function password_sent(Request $request){

        if(Customer::where('email',$request->email)->exists()){

        $customer = Customer::where('email',$request->email)->first();
        PasswordResset::where('customer_id',$customer->id)->delete();

              $reset_info =  PasswordResset::create([
                'customer_id'=>$customer->id,
                'token'=>uniqid(),
                'created_at'=>Carbon::now(),
                ]);

                Notification::send($customer, new PasswordRessetNotificaton($reset_info));
                return back()->with('success',"Password Reset Request sent to $request->email");



        }else{

        return back()->with('dontexists','Email doesnot exists');

        }
}

    function password_form($token){

    return  view('frontend.customer.password_form',[
        'token'=>$token,
    ]);
    }

    function password_reset_confirm(Request $request,$token){

    $request->validate([
    'password'=>'required|confirmed',
    'password_confirmation'=>'required',
    ]);

 $customer = PasswordResset::where('token',$token)->first();

 if($customer != ''){
    Customer::find($customer->customer_id)->update([
        'password'=>bcrypt($request->password),
        'updated_at'=>Carbon::now(),
        ]);

 }else{
    return back()->with('resset',"Password Reset Already");
 }

    PasswordResset::where('token',$token)->delete();
    return back()->with('success',"Password Reset Successful");

    }


}
