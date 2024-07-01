<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\newsubcategory;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    function category(){
        $categories = category::Paginate(5);
        return view('admin.category.category',[
            'categories'=>$categories,
        ]);
    }
    function category_post(Request $request){
      $request->validate([
        'category_name'=>'required|unique:categories',
        'category_img'=>'required',
        'category_img'=>'image',
        'photo'=>'file|max:512',
         'photo'=>'dimensions:min_width=50,min_height=50',
      ]);
      $img = $request->category_img;
      $extension = $img->extension();
      $file_name = Str::lower(str_replace(' ','-', $request->category_name)).'-'.random_int(100000,900000).'.'.$extension;
      Image::make($img)->save(public_path('uploads/categories/'.$file_name));

     category::insert([
       'category_name'=>$request->category_name,
       'category_img'=>$file_name,
       'created_at'=>Carbon::now(),
     ]);
     return back()->with('success','category added successfully');
    }

    function category_edit($category_id){
        $category_info = Category::find($category_id);
        return view('admin.category.edit',[
            'category_info'=>$category_info,
        ]);
    }
    function category_update(Request $request){
        $category = Category::find($request->category_id);
      if($request->category_img == ''){
        category::find($request->category_id)->update([
            'category_name'=>$request->category_name,
             'updated_at' =>Carbon::now(),
        ]);
        return redirect('/category');
      }
      else{
         $current_img = public_path('uploads/categories/' . $category->category_img);
         unlink($current_img);
         $img = $request->category_img;
         $extension = $img->extension();
         $file_name = Str::lower(str_replace(' ','-', $request->category_name)).'-'.random_int(100000,900000).'.'.$extension;
         Image::make($img)->save(public_path('uploads/categories/'.$file_name));

         category::find($request->category_id)->update([
            'category_name'=>$request->category_name,
            'category_img'=>$file_name,
             'updated_at' =>Carbon::now(),
        ]);
        return redirect('/category');
      }
    }
    function category_soft_delete($category_id){
     category::find($category_id)->delete();
     return back();
    }

    function category_trash(){
        $trash_category = Category::onlyTrashed()->get();
        return view('admin.category.tras', [
          'trash_category'=> $trash_category,
        ]);
    }
    function category_restore($id){
     Category::onlyTrashed()->find($id)->restore();
     return back();
    }
    function category_hard_delete($id){
        $category = Category::onlyTrashed()->find($id);
        $img = public_path('uploads/categories/'.$category->category_img);
        unlink($img);
      $subcategory = newsubcategory::where('category_id',$id)->get();
      foreach( $subcategory as $sub){
        newsubcategory::find($sub->id)->update([
            'category_id'=>12,
        ]);
      }


     Category::onlyTrashed($id)->forceDelete();
     return back();
    }

    function delete_checked(Request $request){
        foreach($request->category_id as $category){
             Category::find($category)->delete();
        }
        return back();
     }
    function restore_checked(Request $request){
        foreach($request->category_id as $category){
             Category::onlyTrashed()->find($category)->restore();
        }
        return back();
     }
}
