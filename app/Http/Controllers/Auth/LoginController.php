<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        if ($request->input('loginType') === 'member') {
            $member = Member::where('mobile', $request->input('mobile'))
                ->where('bpid', $request->input('bpid'))
                ->first();

            if ($member) {
                Auth::guard('member')->login($member);
                return redirect()->intended('/member/homepage/');
            }
        }

        // For admin login, attempt login with email and password directly
        return Auth::guard('web')->attempt(
            $request->only('email', 'password'), // Using only email and password fields from the request
            $request->filled('remember')
        );
    }


    public function login(Request $request)
    {
        $request->validate([
            'loginType' => 'required|string',
        ]);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return redirect()->back()->withErrors(['message' => 'Incorrect Credentials.']);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        if (Auth::guard('member')->check()) {
            $member = Auth::guard('member')->user();
            return redirect()->intended('/member/homepage/'); // Redirect member to member home
        } else {
            return redirect()->intended('/admin/homepage'); // Redirect admin to admin home
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Logout the user from the web guard
        Auth::guard('member')->logout(); // Logout the user from the member guard if needed

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return  redirect('/');
    }

}
