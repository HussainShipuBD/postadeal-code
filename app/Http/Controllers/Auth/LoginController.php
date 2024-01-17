<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Session;
use Exception;

class LoginController extends Controller
{

/*    public function __construct()
    {
        $this->middleware('guest');
    }

*/    protected $providers = [
         'facebook','google'
    ];

    public function show()
    {
        return view('auth.register');
    }

    public function redirectToProvider($driver)
    {
        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }

  
    public function handleProviderCallback( $driver )
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty( $user->email )
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function sendSuccessResponse()
    {
              $notification = array(
                    'message' => __('messages.Logged success'),
                    'alert-type' => 'success',
                );
           
            session()->put('notification', $notification);

            return redirect()->route('main.index');
    }

    protected function sendFailedResponse($msg = null)
    {

        $notification = array(
                    'message' => __('messages.Unable to login, try with another provider to login.'),
                    'alert-type' => 'success',
                );
          session()->put('notification', $notification);

             return redirect()->route('auth.login');

        /*return redirect()->route('social.login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);*/
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = User::where('email', $providerUser->getEmail())->first();

        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
 
           $user->update([
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token
            ]);
        } else {
            // create a new user
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'provider' => $driver,
                'provider_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                'status' => '1',
                'userId' => Str::uuid()->toString(),
                'emailVerification' => '0',
                'fbVerification' => '1',
                'rating' => '0',
                'reviews' => '0',
                'chatNotification' => 'true',
                'emailNotification' => 'true',
                'pushNotification' => 'true',
                'chatCount' => '0',
                'notificationCount' => '1',
                'online_status' => 'online'
            ]);
        }

        // login the user
        Auth::login($user, true);

        return $this->sendSuccessResponse();
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}