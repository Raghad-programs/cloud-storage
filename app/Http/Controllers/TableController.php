<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;

class TableController extends Controller
{
    public function table()
    {

        $users = User::with('department')->get();
        return view('dashboard.layouts.table')->with('users',$users);

    }
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('table')->with('success', 'User deleted successfully');
    }

    
}
