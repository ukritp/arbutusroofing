<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $maxLoginAttempts = 5; // Amount of bad attempts user can make
    protected $lockoutTime = 300; // Time for which user is going to be blocked in seconds

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    protected function authenticated($request, $user)
    {
        // Check if user status is enabled or disabled
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            // Authentication passed...
            return redirect()->intended('/');
        }else{
            // Authentication failed...
            Auth::logout();
            return redirect('login')->withErrors(['Your account has been disabled']);;
        }
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
            'first_name'   => 'required|max:255',
            'last_name'    => 'required|max:255',
            'email'        => 'required|email|max:255|unique:users',
            'password'     => 'required|min:6|confirmed',

            'address'      => 'max:255',
            'city'         => 'max:50',
            'province'     => '',
            'postalcode'   => 'max:6',
            'phone_number' => 'digits:10',
            'status'       => '',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'password'     => bcrypt($data['password']),

            'address'      => $data['address'],
            'city'         => $data['city'],
            'province'     => $data['province'],
            'postalcode'   => $data['postalcode'],
            'phone_number' => $data['phone_number'],
            'status'       => $data['status'],
        ]);
    }
}
