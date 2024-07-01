<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\newsubcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        return view('admin.subcategory.subcategory',[
            'categories'=>$categories,
        ]);
    }
    function subcategory_store(Request $request){
    $request->validate([
    'category'=>'required',
     'category_name'=>'required',
    ]);

    if(newsubcategory::where('category_id', $request->category)->where('category_name',$request->category_name)->exists()){
        return back()->with('exists', 'subcategory already exists');
    }
    else{
        newsubcategory::insert([
            'category_id'=>$request->category,
             'category_name'=>$request->category_name,
             'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'subcategory added successfully');
    }
    }
    function subcategory_edit($id){
        $categories = Category::all();
        $subcategory = newsubcategory::find($id);
        return view('admin.subcategory.edit',[
            'categories'=>$categories,
            'subcategory'=>$subcategory,
        ]);
    }
    function subcategory_update(Request $request, $id){

        if(newsubcategory::where('category_id', $request->category)->where('category_name',$request->category_name)->exists()){
            return back()->with('exists', 'subcategory already exists');
        }
        else{
            newsubcategory::find($id)->update([
                'category_id'=>$request->category,
                'category_name'=>$request->category_name,
                 'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated', 'subcategory updated successfully');
        }
    }
    function subcategory_delete($id){
        newsubcategory::find($id)->delete();
        return back()->with('Deleted', 'subcategory Deleted');
    }
}
