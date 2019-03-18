<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Organization;
use App\Libraries\Library;

class OrganizationController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->author_id;
        $orgs = Organization::where('user_id','=',$user)->first();
        return view('dashboard/organization/index',compact('orgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard/organization/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $bangla = array(
                    'phone_no' => $request->phone_no,
                    'mobile_no1' => $request->mobile_no1,
                    'mobile_no2' => $request->mobile_no2,
                );
            $english = Library::bn2en($bangla);
        $data = Organization::find($request->id);
        $data->org_name = $request->org_name;
        $data->business_title = $request->business_title;
        $data->office_address = $request->office_address;
        $data->store_address = $request->store_address;
        $data->phone_no = $english['phone_no'];
        $data->mobile_no1 = $english['mobile_no1'];
        $data->mobile_no2 = $english['mobile_no2'];
        $data->office_email = $request->email;
        if($request->hasFile('logo')){
        $extension = $request->logo->getClientOriginalExtension();
        $filename = 'logo'.rand(1111,9999).'.'.$extension;
            $request->logo->move(storage_path('app/public/images'), $filename);
        }
        if(isset($filename)){
           $data->logo = $filename; 
       }
        $data->save();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function editOrg(Request $request){
        $data = Organization::find($request->id);
        return Response()->json($data);
    }
    public function orgload(){
        $data = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return Response()->json($data);
    }
}
