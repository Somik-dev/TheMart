<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    function brand(){
        $brands =Brand::all();
        return view('admin.brand.brand',[
           'brands'=>$brands,
        ]);
    }
    function brand_store(Request $request){
     $request->validate([
        'brand_name'=>'required',
        'brand_logo'=>'required|image',
     ]);

     $logo = $request->brand_logo;
     $extension = $logo->extension();
     $file_name = Str::lower(str_replace(' ','-',$request->brand_name )).'.'.$extension;
     Image::make($logo)->save(public_path('uploads/brand/'.$file_name));

     Brand::insert([
        'brand_name'=>$request->brand_name,
        'brand_logo'=>$file_name,
        'created_at'=>Carbon::now(),
     ]);
     return back()->with('brand', 'New Brand Added');
    }


    function brand_edit($id){
      $brand = Brand::find($id);
      return view('admin.brand.edit', [
          'brand'=> $brand,
      ]);
    }
    function brand_update(Request $request,$id){
     $brand = Brand::find($id);
     $request->validate([
     'brand_name'=>'required',
     ]);

     if($request->brand_logo == ''){
       Brand::find($id)->update([
        'brand_name'=>$request->brand_name,
       ]);
       return back()->with('success', 'Brand updated');
     }
     else{
        $request->validate([
            'brand_logo'=>'required|image',
            ]);
     }

     $current = public_path('uploads/brand/'.$brand->brand_logo);
     unlink($current);

     $img = $request->brand_logo;
     $extension = $img->extension();
     $file_name = Str::lower(str_replace(' ','-',$request->brand_name )).'.'.$extension;
     Image::make($img)->save(public_path('uploads/brand/'.$file_name));
     Brand::find($id)->update([
        'brand_name'=>$request->brand_name,
        'brand_logo'=>$file_name,
       ]);
       return back()->with('success', 'Brand updated');
    }
    function brand_delete($id){
        $brand = Brand::find($id);
        $current = public_path('uploads/brand/'.$brand->brand_logo);
        unlink($current);
        $brand->delete();
        return back()->with('success', 'Brand Delete');
    }
}
