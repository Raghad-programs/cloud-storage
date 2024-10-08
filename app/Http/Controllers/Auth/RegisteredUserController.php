<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Department;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;


class RegisteredUserController extends Controller

{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $departments = Department::all();

        return view('dashboard.auth.register')->with(
        "departments",$departments
        );
    }    

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'phone_number' => ['required'],
        'department' => ['required', 'exists:departments,id'],
    ]);

    $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'profile_pic' => '-',
        'phone_number' => $request->phone_number,
        'Depatrment_id' => $request->department,
        'role_id' => 2
    ]);

    event(new Registered($user));

    // Send welcome email and current employee  
    $current_employee = Auth::user();

    Mail::to($user->email)->send(new WelcomeEmail($user,$current_employee));

    flash()->success('showfileandtypes.Register_Account_success');
    return redirect(route('table', absolute: false));
}
}

