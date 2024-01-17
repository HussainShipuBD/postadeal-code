<?php

use App\Models\Admin;
namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use Config;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
     public function showLoginForm()
    {
    
   // echo "hai"; die;
        //$siteSettings = Settings::first();
        //$social = json_decode($siteSettings->social_links);
        return view('admin.auth.login');
    
    }
    
    
    public function login(Request $request)
    {
       // echo "<pre>"; print_r($request->password); die;
//echo "hai"; die;
       /* $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:30', 
            'password' => 'required|min:6|max:20|regex:/^\S*$/u',
            ],
            [
            'email.required' => trans('app.Enter Email'),
            'email.max'=>trans('app.Only :max characters allowed'),
            'email.email'=>trans('app.Invalid Email'),
            'password.required' => trans('app.Enter Password'),
            'password.min'=>trans('app.Enter atleast :min characters'),
            'password.max'=>trans('app.Only :max characters allowed'),
            'password.regex'=>trans('app.Space not allowed'),
            ]);
        if ($validator->fails()) {
            //return Redirect::back()->withErrors($validator)->withInput();
            return redirect()->back()->withErrors($validator)->withInput();

        }else{ */
            //$advertiser = Advertiser::where('email', $request->email)->first();

            
          /*  if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){ 
                //echo "hai"; die;
                return redirect()->intended('admin/dashboard')->with('success','Logged in successfully');

            }else{
                //$validator->errors()->add('email', 'Invalid Credentials!');
                return redirect()->back();  
            } */


            $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

        //}   
        
    }
    
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
}
