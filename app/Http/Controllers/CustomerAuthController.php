<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\EmailVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomerEmailVerifyNotification;

class CustomerAuthController extends Controller
{
    function customer_login(){
        return view('frontend.customer.login');
    }
    function customer_register(){
        return view('frontend.customer.register');
    }
    function customer_store(Request $request){
     $request->validate([
        'fname'=>'required',
        'email'=>'required',
        'password'=>'required|confirmed',
        'password'=>Password::min(8)
        ->letters()
        ->mixedCase()
        ->numbers()
        ->symbols(),
        'password_confirmation'=>'required',
     ]);

      $customer_id = Customer::insertGetId([
         'fname'=>$request->fname,
         'lname'=>$request->lname,
         'email'=>$request->email,
         'password'=>bcrypt($request->password),
         'created_at'=>Carbon::now(),
       ]);


       EmailVerify::where('customer_id',$customer_id)->delete();

       $emailverify_info =  EmailVerify::create([
        'customer_id'=> $customer_id,
        'token'=>uniqid(),
        'created_at'=>Carbon::now(),
        ]);

            $customer =Customer::find($customer_id);


       Notification::send($customer, new CustomerEmailVerifyNotification($emailverify_info));
       return back()->with('success',"Registered Successfull! A Varification link sent to $request->email please varify to log in");

        //  if(Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])){
        //   return redirect()->route('index');
        //   }

    }



    function customer_login_confirm(Request $request){
          $request->validate([
            'email'=>'required',
            'password'=>'required',
          ]);
          if(Customer::where('email', $request->email)->exists()){

          if(Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])){

                if(Auth::guard('customer')->user()->email_verified_at == null){

                Auth::guard('customer')->logout();
                return back()->with('notvarified', 'please varify your email');

                }else{
                    return redirect()->route('index');
                }

          }
          else{
            return back()->with('exist', 'Wrong Password');
          }
          }
          else{
            return back()->with('exist', 'Email does not exist');
          }
    }


function customer_email_verify($token){

$customer_id = EmailVerify::where('token',$token)->first()->customer_id;

    Customer::find($customer_id)->update([
    'email_verified_at'=>Carbon::now(),
    ]);
    EmailVerify::where('token',$token)->delete();
return redirect()->route('customer.register')->with('success', 'Congratulation Your has been Varified!');

}


}
