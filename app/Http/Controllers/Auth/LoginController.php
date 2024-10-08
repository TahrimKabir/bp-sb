<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        if ($request->input('loginType') === 'member') {
            // Member login
            $member = Member::where('mobile', $request->input('mobile'))
                ->where('bpid', $request->input('bpid'))
                ->first();

            if ($member) {
                Auth::guard('member')->login($member);
                return redirect()->intended('/member/homepage/');
            }
        } elseif ($request->input('loginType') === 'examiner') {
            // Examiner login
            $user = Auth::guard('web')->getProvider()->retrieveByCredentials(
                $request->only('email', 'password')
            );

            if ($user && $user->role === 'examiner') {
                // If user is an examiner, authenticate them
                Auth::guard('web')->login($user);
                return redirect()->intended('/examiner/homepage');
            }
        } else {
            // Admin login (default to web guard)
            return Auth::guard('web')->attempt(
                $request->only('email', 'password'),
                $request->filled('remember')
            );
        }

        return false;
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
            // Redirect member
            return redirect()->intended('/member/homepage/');
        } elseif (Auth::guard('web')->check()) {
            // Redirect based on the user role
            $user = Auth::guard('web')->user();
            if ($user->role === 'examiner') {
                return redirect()->intended('/examiner/homepage');
            } else {
                return redirect()->intended('/admin/homepage');
            }
        }

        return redirect('/home');
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
