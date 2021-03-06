<?php

namespace Hotels\Http\Controllers\Auth;

use Hotels\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Hotels\User;

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
    protected $redirectTo = '/hotels';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
      * Redirect the user to the Google authentication page.
      *
      * @return \Illuminate\Http\Response
      */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

        /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try
        {
            $user = Socialite::driver('google')->user();
        }
        catch (\Exception $e)
        {
            return redirect('/login');
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();

        if($existingUser)
        {
            // log them in
            auth()->login($existingUser, true);
        }
        else
        {
            // create a new user
            $password_hashed = password_hash($user->id, PASSWORD_DEFAULT);
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->password        = $password_hashed;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();

            auth()->login($newUser, true);
        }
        return redirect()->route('home');
    }

}
