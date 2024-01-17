<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use App\Mail\SignupEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;
use App\Models\User;
use App\Models\Setting;
use Hash;

  
class AuthController extends Controller
{


        public function __construct()
    {

    }
   

  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
                    if(Auth::user())
             {
                return redirect()->route('main.index');
             }  


        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
                    if(Auth::user())
             {
                return redirect()->route('main.index');
             }  

        return view('auth.register');
    }


    public function verify($userId)
    {
        $user = User::where('userId', $userId)->where('emailVerification', 0)->first();

       if( $user ) {
           $user->update([
                'emailVerification' => '1'
            ]);
                Auth::login($user, true);

              $notification = array(
                    'message' => __('messages.Email Verfied successfully'),
                    'alert-type' => 'success',
                );
           
            session()->put('notification', $notification);

            return redirect()->route('main.index');

        } else {

            $notification = array(
                    'message' => __('messages.You have already verified, Please login.'),
                    'alert-type' => 'success',
                );
          session()->put('notification', $notification);

             return redirect()->route('auth.login');

        }

    }      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function reset()
    {
        $settings = Setting::first();

        $userId = 'bb2442b2-ae3f-4625-978d-96bd5f0bed21';

         $valueArray = [
            'site_title' => $settings['siteName'],
            'site_logo' => url("/storage/app/public/admin_assets/dark.png"),
            'media_url' => url("/storage/app/public/admin_assets/"),
            'verify_url' => url("/auth/verify").'/'.$userId,
            'email_header' => 'Welcome to '.$settings['siteName'],
            'email_message' => 'Your user account is registered successfully. Signin to continue to your account',
            'email_details' => 'Please click on the button below to verify your email address!',
            'email_footer' => $settings['copyrightText'],
            'facebook_link' => $settings['facebookURL'],
            'twitter_link' => $settings['twitterURL'],
            'linkedin_link' => $settings['linkedinURL']
        ];
        
        try {
            \Mail::to('bnadesh@gmail.com')->send(new SignupEmail($valueArray));
            echo 'Mail send successfully';
        } catch (\Exception $e) {
            echo 'Error - '.$e;
        }

    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {

        $this->validate(
                $request,
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ],
                [
                    'email.required' => __('messages.Please enter user E-mail.'),
                    'password.required' => __('messages.Please enter the password.')
                ]
            );


        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {

            if(auth()->user()->emailVerification == 0)
             {
               Auth::logout();
                $notification = array(
                    'message' => __('messages.Please verify your email address'),
                    'alert-type' => 'success',
                );
           
            session()->put('notification', $notification);

            return redirect()->route('main.index');
             }   

          $notification = array(
                    'message' => __('messages.Login success'),
                    'alert-type' => 'success',
                );
           
            session()->put('notification', $notification);

            return redirect()->route('main.index');

        } else {

          $notification = array(
                    'message' => __('messages.Invalid Username or Password'),
                    'alert-type' => 'error',
                );
           
            session()->put('notification', $notification);

           return redirect()->back();

        }
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  

          $settings = Setting::first();

        $this->validate(
                $request,
                [
                    'name' => 'required|min:3|max:50',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'required|min:6'
                ],
                [
                    'name.required' => __('messages.Please enter user name.'),
                    'name.min' => __('messages.The name must be at least 3 characters.'),
                    'name.max' => __('messages.The name may not be greater than 30 characters.'),
                    'email.required' => __('messages.Please enter user E-mail.'),
                    'email.unique' => __('messages.Sorry, Email already register.'),
                    'password.required' => __('messages.Please enter the password.'),
                    'password.min' => __('messages.The name must be at least 6 characters.'),
                    'password_confirmation.required' => __('messages.Please enter the confirm password.')
                ]
            );

            $userData = new User();
            $userData->name = $request->name;
            $userData->email = $request->email;
            $userData->password = Hash::make($request->password);
            $userData->status = 1;
            $userData->userId = Str::uuid()->toString();
            $userData->emailVerification = 0;
            $userData->fbVerification = 0;
            $userData->rating = 0;
            $userData->reviews = 0;
            $userData->chatNotification = true;
            $userData->emailNotification = true;
            $userData->pushNotification = true;
            $userData->chatCount = 0;
            $userData->notificationCount = 1;
            $userData->online_status = "online";

            if ($userData->save()) {


        $userId = $userData->userId;
        $toemail = $userData->email;

         $valueArray = [
            'site_title' => $settings['siteName'],
            'site_logo' => url("/storage/app/public/admin_assets/dark.png"),
            'media_url' => url("/storage/app/public/admin_assets/"),
            'verify_url' => url("/auth/verify").'/'.$userId,
            'email_header' => 'Welcome to '.$settings['siteName'],
            'email_message' => 'Your user account is registered successfully. Signin to continue to your account',
            'email_details' => 'Please click on the button below to verify your email address!',
            'email_footer' => $settings['copyrightText'],
            'facebook_link' => $settings['facebookURL'],
            'twitter_link' => $settings['twitterURL'],
            'linkedin_link' => $settings['linkedinURL']
        ];
        
            try {
                \Mail::to($toemail)->send(new SignupEmail($valueArray));
                 //echo 'Mail send successfully';
            } catch (\Exception $e) {
               // echo 'Error - '.$e;
            }
                $notification = array(
                    'message' => __('messages.Registration created successfully'),
                    'alert-type' => 'success',
                );
            } else {
                $notification = array(
                    'message' => __('messages.Something went wrong'),
                    'alert-type' => 'error',
                );
            }
            session()->put('notification', $notification);

            return redirect()->route('auth.login');

    }



    public function postReset(Request $request)
    {  
        $this->validate(
                $request,
                [
                    'email' => 'required|email',
                    'password' => 'required|min:6',
                ],
                [
                    'email.required' => __('messages.Please enter user E-mail.'),
                    'password.required' => __('messages.Please enter the password.'),
                    'password.min' => __('messages.The name must be at least 6 characters.')
                ]
            );

        $email = $request->email;
        $password = Hash::make($request->password);

        $user = User::where('email', $email)->first();

        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
 
           $user->update([
                'password' => $password
            ]);

              $notification = array(
            'message' => __('messages.Reset Password successfully'),
            'alert-type' => 'success',
        );

           session()->put('notification', $notification);

            return redirect()->route('auth.login');


       } else {

                $notification = array(
                    'message' => __('messages.Email not register yet'),
                    'alert-type' => 'error',
                );

            session()->put('notification', $notification);

            return redirect()->route('auth.reset');

       }


    }

    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
       
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {

        Auth::logout();
        $notification = array(
                    'message' => __('messages.Logged Out successfully'),
                    'alert-type' => 'success',
                );
           
            session()->put('notification', $notification);

            return redirect()->route('main.index');
    }
}