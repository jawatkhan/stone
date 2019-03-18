<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Libraries\Library;

class CategoryController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function category(){
    	$categories = \App\Category::where('parent_id','=',0)->latest()->get();
    	return view('dashboard.item_category.category',compact('categories'));
    }

    public function category_insert(Request $request){
    	$this->validate($request,[
            'category_name' => 'required',
        ]);
    	$all = \App\Category::orderBy('id','desc')->where('parent_id','=',0)->first();
        $data = new \App\Category;
        if(count($all)>0){
        	$data->code_no = $all->code_no+1;
        }else{
        	$data->code_no = 101;
        }
        $data->category_name = $request->category_name;
        $data->save();
        return redirect()->back();
    }

    public function sub_category($id){
    	$braedCumb= DB::select("CALL CategoryProcedure($id)");
    	$categories = \App\Category::where('parent_id','=',$id)->latest()->get();
    	return view('dashboard.item_category.sub_category',compact('categories','id','subcategory','parentName','braedCumb'));
    }

    public function sub_category_insert(Request $request){
    	$this->validate($request,[
            'category_name' => 'required',
        ]);
    	$all = \App\Category::orderBy('id','desc')->where('id','=',$request->categoryid)->first();
        $serchChild = \App\Category::orderBy('id','desc')->where('parent_id','=',$request->categoryid)->first();
        $data = new \App\Category;
        if(count($all)>0){
            if(count($serchChild)>0){
            	$data->code_no = $all->code_no.'.'.((substr($serchChild->code_no,-3))+1);
            }else{
                $data->code_no = $all->code_no.'.'.((substr($all->code_no,-3))+1);
            }
        }else{
        	$data->code_no = 101;
        }
        $data->category_name = $request->category_name;
        $data->parent_id = $request->categoryid;
        $data->save();
        return redirect()->back();
    }

    public function category_edit($id){
    	$category = \App\Category::find($id);
    	$categories = \App\Category::where('parent_id','=',0)->latest()->get();
    	return view('dashboard.item_category.edit',compact('categories','category'));
    }
    public function category_update(Request $request){
    	$this->validate($request,[
            'category_name' => 'required',
        ]);
    	$all = \App\Category::orderBy('id','desc')->where('parent_id','=',0)->first();
        $data = \App\Category::find($request->categoryid);
        $data->category_name = $request->category_name;
        $data->save();
        return redirect('/category');
    }

    public function sub_category_edit($parentid,$id){
    	$braedCumb=DB::select("CALL CategoryProcedure($parentid)");
    	$category = \App\Category::find($id);
    	$categories = \App\Category::where('parent_id','=',$parentid)->latest()->get();
    	return view('dashboard.item_category.sub_category_edit',compact('categories','id','braedCumb','category'));
    }

    public function sub_category_update(Request $request){
    	$this->validate($request,[
            'category_name' => 'required',
        ]);
    	$all = \App\Category::orderBy('id','desc')->first();
        $data = \App\Category::find($request->categoryid);
        $data->category_name = $request->category_name;
        $data->save();
        return redirect()->action('CategoryController@sub_category', ['id'=>$data->parent_id]);
    }

    public function category_delete($id){
    	$childSerch = \App\Category::where('parent_id','=',$id)->get();
    	if(count($childSerch)>0){
    		return redirect()->back()->with('message','Sub Category Delete First.');
    	}else{
    		$del= \App\Category::find($id)->delete();
    		return redirect()->back()->with('message','Category Deleted.');
    	}
    }
}