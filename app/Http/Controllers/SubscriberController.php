<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\Newslater;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{

function subscriber_store(Request $request){

        Subscriber::insert([
        'email'=>$request->email,
        'created_at'=>Carbon::now(),
        ]);
        return redirect()->route('index','#sub')->with('Subs','Subscribe Successful');
}

function subscriber(){

        $subscribers = Subscriber::all();
        return view('admin.Subscriber.subs_list',[
        'subscribers'=>$subscribers,
        ]);

}

function send_newslater($id){

$sub = Subscriber::find($id);
Mail::to($sub->email)->send(new Newslater($sub));
return back()->with('success',"Newslater Sent Successfully to $sub->email");

}

}
