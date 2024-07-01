<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRre;
use App\Models\Category;
use App\Models\newsubcategory;
use App\Models\Brand;
use App\Models\Inventory;
use App\Models\newproduct;
use App\Models\ProductGallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductControler extends Controller
{
    function product(){
        $categories = Category::all();
        $sub_categories = newsubcategory::all();
        $brands = Brand::all();
        return view('admin.product.index',[
           'categories' =>$categories,
           'sub_categories' =>$sub_categories,
           'brands' =>$brands,
        ]);
    }
  function getSubcategory(Request $request){
    $str = '<option value="">Select Subcategory</option>';
    $subcategories = newsubcategory::where('category_id', $request->category_id)->get();
    foreach($subcategories  as $subcategory){
        $str .='<option value="'.$subcategory->id.'">'.$subcategory->category_name.'</option>';
    }
    echo $str;
  }
  function product_store(Request $request){
    $after_implode = implode(',', $request->tags);

    $preview = $request->preview;
    $extension = $preview->extension();
    $file_name = Str::lower(str_replace(' ','-', $request->product_name)).'-'.random_int(100000,900000).'.'.$extension;

    Image::make($preview)->save(public_path('uploads/products/preview/'.$file_name));

      $product_id = newproduct::insertGetId([
        'category_id'=>$request->category,
        'subcategory_id'=>$request->subcategory,
        'brand_id'=>$request->brand,
        'product_name'=>$request->product_name,
        'price'=>$request->price,
        'discount'=>$request->discount,
        'after_discount'=>$request->price -($request->price*$request->discount/100),
        'tags'=> $after_implode,
        'short_desp'=>$request->short_desp,
        'long_desp'=>$request->long_desp,
        'long_desp'=>$request->long_desp,
        'preview'=>$file_name,
        'slug'=>Str::lower(str_replace(' ','-', $request->product_name)).'-'.random_int(100000,9000000),
        'created_at'=>Carbon::now(),
    ]);

    foreach( $request->gallery as $gal){
      $extension = $gal->extension();
      $file_name = Str::lower(str_replace(' ','-', $request->product_name)).'-'.random_int(100000,900000).'.'.$extension;
      Image::make($gal)->save(public_path('uploads/products/gallery/'.$file_name));

      ProductGallery::insert([
        'product_id'=>$product_id,
         'gallery'=>$file_name,
      ]);

    }
    return back()->with('success','Product Added');
  }
  function product_list(){
    $products = newproduct::all();
    return view('admin.product.list',[
        'products'=> $products,
    ]);
  }
  function product_delete($id){
    $product = newproduct::find($id);
    $gallery = ProductGallery::where('product_id',$id)->get();

    $preview = public_path('uploads/products/preview/' .$product->preview);
    unlink($preview);

    foreach($gallery as $gal){
      $gal_img = public_path('uploads/products/gallery/'. $gal->gallery);
      unlink($gal_img);
      ProductGallery::find($gal->id)->delete();
    }
    newproduct::find($id)->delete();

    $inventories = Inventory::where('product_id',$id)->get();
    foreach($inventories as $inventory){
        Inventory::find($inventory->id)->delete();
    }

    return back();
  }
  function product_show($id){
    $product = newproduct::find($id);
    $galleries = ProductGallery::where('product_id',$id)->get();
    return view('admin.product.show',[
        'product'=> $product,
        'galleries'=> $galleries,
    ]);
  }

  function changeStatus(Request $request){
    newproduct::find($request->product_id)->update([
      'status'=>$request->status,
    ]);
  }
}
