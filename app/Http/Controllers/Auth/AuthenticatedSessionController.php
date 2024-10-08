<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('dashboard.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Get the authenticated user
        $user = Auth::user();

        // Send the welcome email
       // Mail::to($user->email)->send(new WelcomeEmail($user->name));

        // Regenerate the session
        $request->session()->regenerate();

        // Redirect the user to the intended destination
        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function checkLogin(Request $request): RedirectResponse
    {
        $request->validate([
            "email" => ["required", "string"],
            "password" => ["required", "string"]
        ]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->get('remember'))) {
            return redirect()->intended($this->redirectPath());
        } else {
            return redirect()->back()
                ->withInput(['email' => $request->email])
                ->withErrors(['errorResponse' => 'These credentials do not match our records']);
        }
    }

    protected function redirectPath()
    {
        return route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
