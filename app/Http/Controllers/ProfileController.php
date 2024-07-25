<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($id){
        $user = User::findOrFail($id);
        return view('profile.edit')->with('user',$user);;
    
    
    }
    
    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            
        ]);
    
        $user->update($validatedData);
        return redirect()->route('profile.edit',$user->id);
    }


     public function show($id ,Request $request) 
     {
        $user = User::findOrFail($id);
    
        return view('profile.partials.profile', [
            'user' => $request->user(),
        ]);
    }
     
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
