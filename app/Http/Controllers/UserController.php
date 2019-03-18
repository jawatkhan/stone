<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Mail;
use App\Mail\verifyEmail;
use App\Role;
use App\User;
use Auth;
use Response;
use DB;
use App\Libraries\Library;

class UserController extends Controller
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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function userCreate(Request $request)
    {
    	$this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
        ]);
        $user = User::create([
        	'author_id'=> Auth::user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'verifyToken' => Str::random(40),
            // 'password' => bcrypt($request->password),
        ]);

        $user->roles()->attach($request->role);
// ------email verifications-------
        $thisUser = User::findOrFail($user->id);
        $this->sendEmail($thisUser);
// -------end----
        return redirect()->back()->with('message','Please Check User Email.');
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $roles = Role::orderBy('name','asc')->whereNotIn('name',array('Administrator'))->get();
        return view('auth.register',compact('roles'));
    }
    // -------------email verification-----------------------
    public function sendEmail($thisUser){
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }
    
    

   
    // -----------verification end-----------
    public function userList(){
    	//$userList1 = User::where('author_id','=',Auth::user()->id);
        $userList = DB::table('users')->where('users.author_id','=',Auth::user()->id)
                    ->leftjoin('role_users','role_users.user_id','=','users.id')
                    ->leftjoin('roles','roles.id','=','role_users.role_id')
                    ->select('users.*','roles.name as role_name')->get();
        //return $userList;
    	return view('auth.userlist',compact('userList'));
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
    public function deleteUser($id){
    	$data = User::find($id);
    	$data->delete();
    	return redirect()->back();
    }
}
