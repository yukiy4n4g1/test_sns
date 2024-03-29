<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\User;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        return "/user/" . Auth::user()->id;;
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::logout();
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect("/");
    }

    public function redirectGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $userData = Socialite::driver('github')->stateless()->user();
        $user = User::firstOrCreate(
            [
                'name' => $userData->name,
                'email' => $userData->email
            ],
            ['password' => '']
        );
        Auth::login($user);
        return redirect("/user/" . Auth::user()->id);
    }
}
