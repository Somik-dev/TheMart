<?php

namespace App\Http\Controllers;

use Stripe;
use Session;
use App\Models\stripeOders;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
$data = (session('data'));
$stripe_id = stripeOders::insertGetId([
    'fname' => $data['fname'],
    'email' => $data['email'],
    'phone' => $data['phone'],
    'total' => $data['total'] + $data['charge'],
    'address' => $data['address'],
    'lname' => $data['lname'],
    'customer_id' => $data['customer_id'],
    'country' => $data['country'],
    'city' => $data['city'],
    'zip' => $data['Zip'],
    'company' => $data['company'],
    'massage' => $data['massage'],
    'ship_fname' => $data['ship_fname'],
    'ship_country' => $data['ship_country'],
    'ship_city' => $data['ship_city'],
    'ship_zip' => $data['ship_zip'],
    'ship_company' => $data['ship_company'],
    'ship_email' => $data['ship_email'],
    'ship_phone' => $data['ship_phone'],
    'ship_adress' => $data['ship_adress'],
    'charge' => $data['charge'],
    'discount' => $data['discount'],
    'sub_total' => $data['sub_total'],
    'ship_check' => $data['ship_check'],
]);




        return view('stripe',[
            'stripe_id'=>$stripe_id,
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        print_r($stripe_id);
            die();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);

        Session::flash('success', 'Payment successful!');

        return back();
    }
}
