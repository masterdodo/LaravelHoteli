<?php

namespace Hotels\Http\Controllers\Auth;

use Hotels\User;
use Hotels\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use GuzzleHttp\Client;

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
    protected $redirectTo = '/hotels';

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'g-recaptcha-response' => ['required', 'string'],
        ],
        [
            'g-recaptcha-response.required' => 'ReCAPTCHA Error. Try again!',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Hotels\User
     */

    protected function create(array $data)
    {
        $recaptcha_response = $data['g-recaptcha-response'];

        if($this->saveApiData($recaptcha_response))
        {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'editor' => 0,
            ]);
        }
    }

    protected function saveApiData($response)
    {
        $client = new Client();
        $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'response' => $response,
                'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
            ]
        ]);
        $success = json_decode($res->getBody()->getContents());
        $success = $success->success;

        if($success)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
