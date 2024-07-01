<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\ncolor;
use App\Models\newproduct;
use App\Models\Product;
use App\Models\size;
use Carbon\Carbon;
use Illuminate\Http\Request;


class InventoryController extends Controller
{
   function variation(){
    $colors = ncolor::all();
    $categories = Category::all();
    return view('admin.product.variation',[
        'colors'=>$colors,
        'categories'=>$categories,
    ]);
   }

   function color_store(Request $request){
      ncolor::insert([
       'color_name'=>$request->color_name,
       'color_code'=>$request->color_code,
       'created_at'=>Carbon::now()
      ]);
      return back()->with('color','color Added');
   }
   function size_store(Request $request){
      size::insert([
        'category_id'=>$request->category_id,
       'size_name'=>$request->size_name,
       'created_at'=>Carbon::now()
      ]);
      return back()->with('size','Size Added');
   }
   function color_remove($id){
     ncolor::find($id)->delete();
     return back();
   }
   function size_remove($id){
     size::find($id)->delete();
     return back();
   }
   function inventory($id){
    $product = newproduct::find($id);
    $colors = ncolor::all();
    $inventory = Inventory::where('product_id', $id)->get();
    return view('admin.product.invertory',[
        'product'=>$product,
        'colors'=>$colors,
        'inventory'=>$inventory,
    ]);
   }

   function inventory_store(Request $request, $id){
        if(Inventory::where('product_id', $id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
         Inventory::where('product_id', $id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
         return back()->with('success','Inventory Adedded');
        }
        else{
         Inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
           ]);
           return back()->with('success','Inventory Adedded');
        }
   }
}
