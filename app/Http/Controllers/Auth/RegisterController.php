<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Role;
use Mail;
use App\Mail\verifyEmail;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // 'password' => bcrypt($data['password']),
            'verifyToken' => Str::random(40),
        ]);

        $user->roles()->attach($data['role']);
        // $thisUser = User::findOrFail($user->id);
        // $this->sendEmail($thisUser);

        return $user;
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $roles = Role::orderBy('name')->pluck('name','id');
        return view('auth.register',compact('roles'));
    }

    Public function verifyEmailFirst(){
        return view('email.verifyEmailFirst');
    }

    public function sendEmailDone($email,$verifyToken){

        $user = User::where(['email'=>$email,'verifyToken'=>$verifyToken])->first();
        if ($user) {
            return view('auth.insertPassword');
        }else{
           return 'Page Not found';
        }
    }

    public function updatePassword(Request $request){
        
        $this->validate($request,[
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::where(['email'=>$request->email])->first();
        if($user){
            User::where(['email'=>$request->email])->update(['password'=>bcrypt($request->password),'status'=>'1','verifyToken'=>Null]);
            return redirect('/home');
        }else{
            return 'email not found';
        }
        
    }

}
