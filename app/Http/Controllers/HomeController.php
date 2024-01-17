<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
    }

    public function verifyemail($userId)
    {


           $userData = User::findOrFail($userId);

            if($userData->emailVerification == "1") {
                $notification = array(
                    'message' => trans('Email is already Verified'),
                );

                session()->put('notification', $notification);


                return redirect('/');

            } else {


                $userData->emailVerification = "1";



                // ends here
                if ($userData->save()) {
                    $notification = array(
                        'message' => trans('Email Verification has been Done Successfully'),
                    );
                } else {
                    $notification = array(
                        'message' => trans('Something went wrong, Please try again'),
                    );
                }

                session()->put('notification', $notification);

                return redirect('/');

            }
          
        }
}
