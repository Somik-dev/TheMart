<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    function orders(){
        return view('admin.orders.orders');
    }
}
