<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Mail;
use App\Mail\verifyEmail;
use Response;
use App\Role;
use App\User;
use App\Organization;
use DB;
use can;
use App\Libraries\Library;

class AdminController extends Controller
{

    use RegistersUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }

    public function clientRegisterForm(){
        //$roles = Role::orderBy('name')->pluck('name','id');
        $roles = Role::where('name','Administrator')->pluck('name','id');
        return view('admin.dashboard.register',compact('roles'));
    }

    public function clientCreate(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',

            'org_name' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'store_address' => 'nullable|string|max:255',
            'org_email' => 'nullable|string|email|max:255',
            'phone_no' => 'nullable|string|min:11',
            'logo' => 'nullable',
        ]);

        DB::beginTransaction();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'verifyToken' => Str::random(40),
            // 'password' => bcrypt($request->password),
        ]);
        User::where('id','=',$user->id)->update(['author_id'=>$user->id]);
        $user->roles()->attach($request->role);

        $thisUser = User::findOrFail($user->id);
        $this->sendEmail($thisUser);

        if($request->hasFile('logo')){
        $extension = $request->logo->getClientOriginalExtension();
        $filename = 'logo'.rand(1111,9999).'.'.$extension;
            $request->logo->move(storage_path('app/public/images'), $filename);
        }
        if(isset($filename)) {
            Organization::insert([
                'user_id' => $user->id,
                'org_name' => $request->org_name,
                'office_address' => $request->office_address,
                'store_address' => $request->store_address,
                'office_email' => $request->org_email,
                'phone_no' => $request->phone_no,
                'logo' => $filename,
            ]);
        }else{
            Organization::insert([
                'user_id' => $user->id,
                'org_name' => $request->org_name,
                'office_address' => $request->office_address,
                'store_address' => $request->store_address,
                'office_email' => $request->org_email,
                'phone_no' => $request->phone_no,
            ]);
        }

        DB::commit();
        return redirect()->back()->with('message','Please Check User Email.');
    }

    public function clientList(){
        $clients = DB::table('users')->join('organizations','organizations.user_id','=','users.id')->select('users.*','organizations.org_name','organizations.office_address','organizations.phone_no','organizations.logo')->get();
        return view('admin/dashboard/client-list',compact('clients'));
    }

    public function clientApproved(Request $request){
        $data = User::find($request->id);
        if($data->status == 0){
            $data->status = 1;
            $data->save();
        }elseif($data->status == 1){
            $data->status = 0;
            $data->save();
        }

        return Response::json(['success' => '1', 'userid' => $request->id]);
    }

    public function sendEmail($thisUser){
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }
    // public function verifyEmailFirst(){
    //     return view('email.verifyEmailFirst');
    // }

    
}
