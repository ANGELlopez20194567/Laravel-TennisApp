<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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
    protected $redirectTo = '/login';
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

protected function login(Request $request){
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // Regenerate session to prevent session fixation attacks

        $user_role = Auth::user()->role;

        switch ($user_role) {
            case 1:
                return redirect('/admin');
            case 2:
                return redirect('/vendedor');
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Oooops, algo falló');
        }
    } else {
        return redirect('/login')->with('error', 'Credenciales incorrectas');
    }
}


    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate(); // Invalidate session
    $request->session()->regenerateToken(); // Regenerate CSRF token

    return redirect('/login'); // Redirect to login page
}
}
