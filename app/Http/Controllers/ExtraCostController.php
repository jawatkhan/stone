<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use App\ExtraCost;
use Auth;
use App\Libraries\Library;

class ExtraCostController extends Controller
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
    public function index(){
    	$extraCost = ExtraCost::where('user_id',Auth::user()->author_id)->where('owner_id','=','1')->paginate(10);
    	return view('dashboard.extra_costs.extracost',compact('extraCost'));
    }

    public function insertextracost(Request $request){
    	$validator = Validator::make($request->all(),[
            'owner_id' => 'required',
            'date' => 'required',
            'description' => 'required|string',
            'extra_cost' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'extra_cost' => $request->extra_cost,
                );
            $english = Library::bn2en($bangla);
            $data = new ExtraCost;
            $data->user_id = Auth::user()->author_id;
            $data->posting_author_id = Auth::user()->id;
            $data->owner_id = $request->owner_id;
            $data->descriptions = $request->description;
            $data->amount = $english['extra_cost'];
            $data->date = $request->date;
            $data->save();
            return Response::json(['success' => '1']);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }
    public function getextracost(Request $request){
    	$data = ExtraCost::find($request->id);
    	return Response()->json($data);
    }

    public function getextracostupdate(Request $request){
    	$validator = Validator::make($request->all(),[
            'owner_id' => 'required',
            'date' => 'required',
            'description' => 'required|string',
            'extra_cost' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'extra_cost' => $request->extra_cost,
                );
            $english = Library::bn2en($bangla);
            $data = ExtraCost::find($request->id);
            $data->user_id = Auth::user()->author_id;
            $data->posting_author_id = Auth::user()->id;
            $data->owner_id = $request->owner_id;
            $data->descriptions = $request->description;
            $data->amount = $english['extra_cost'];
            $data->date = $request->date;
            $data->save();
            return Response::json(['success' => '1']);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }
    public function destroy($id){
    	$del = ExtraCost::find($id);
    	$del->delete();
    	return back();
    }
}
