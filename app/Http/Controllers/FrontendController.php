<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\size;
use App\Models\color;
use App\Models\ncolor;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\newproduct;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\newsubcategory;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    function index(){
        $categories = Category::all();
        $products = newproduct::where('status', 1)->latest()->get();
        return view('frontend.index',[
            'categories'=> $categories,
            'products'=> $products,
        ]);
    }

    function category_products($id){
        $category = Category::find($id);
        $category_products = newproduct::where('category_id', $id)->get();
        return view('frontend.category_product',[
            'category_products'=>$category_products,
             'category'=>$category,
        ]);
        }
    function subcategory_products($id){
        $subcategory = newsubcategory::find($id);
        $subcategory_products = newproduct::where('subcategory_id', $id)->get();
        return view('frontend.subcategory_product',[
            'subcategory_products'=>$subcategory_products,
             'subcategory'=>$subcategory,
        ]);
        }
    function product_details($slug){
        $product_id = newproduct::where('slug', $slug)->first()->id;
        $reviews = OrderProduct::where('product_id',$product_id)->whereNotNull('review')->get();
        $total_stars =OrderProduct::where('product_id',$product_id)->whereNotNull('review')->sum('stars');
        $product_details = newproduct::find( $product_id);
        $available_colors = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();
        $available_sizes = Inventory::where('product_id', $product_id)->groupBy('size_id')->selectRaw('count(*) as total, size_id')->get();
        return view('frontend.product_details',[
            'product_details'=>$product_details,
            'available_colors'=>$available_colors,
            'available_sizes'=>$available_sizes,
            'reviews'=>$reviews,
            'total_stars'=>$total_stars,
        ]);
    }
    function getSize(Request $request){
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach($sizes as $size){
           $str .='<li class="color"><input class="size_id" id="size'.$size->size_id.'" type="radio" name="size_id" value="'.$size->size_id.'">
           <label for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
       </li>';
        }
        echo $str;
    }
    function getQuantity(Request $request){
        $str = '';
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
      if($quantity == 0){
        $quantity = '<button class="abc btn btn-danger value="'.$quantity.'" ">Out of Stock</button>';
      }
      else{
        $quantity = '<button class="btn btn-success">'.$quantity.' In Stock</button>';
      }
      echo $quantity;
    }

        function review_store(Request $request){

            OrderProduct::where('customer_id',Auth::guard('customer')->id())->where('product_id', $request->product_id)->first()->update([
                'review'=>$request->review,
                'stars'=>$request->stars,
                'updated_at'=>Carbon::now(),
            ]);
            return back();
        }


function shop(Request $request){

    $data  = $request->all();




    $products = newproduct::where(function($q) use ($data){

        $min= 1;
        $max = newproduct::max('after_discount');


        if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefind'){

        $min = $data['min'];

        }


        if(!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefind'){

            $max = $data['max'];

            }




        if(!empty($data['search_input']) && $data['search_input'] != '' && $data['search_input'] != 'undefind'){
            $q->where(function($q) use ($data){
                $q->where('product_name','LIKE', '%'.$data['search_input'].'%');
                $q->orwhere('short_desp','like', '%'.$data['search_input'].'%');
                $q->orwhere('long_desp','like', '%'.$data['search_input'].'%');
            });
        }

        if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefind' ){

            $q->where(function($q) use ($data){

            $q->where('category_id',$data['category_id'] );

            });
        }

        if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefind' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefind' ){


                $q->whereBetween('after_discount', [$min, $max] );


        }


    })->get();



    $categories =Category::all();
    $colors = ncolor::all();
    $sizes = size::all();

    return view('frontend.shop',[
    'products'=>$products,
    'categories'=>$categories,
    'colors'=>$colors,
    'sizes'=>$sizes,
    ]);

    }


}
