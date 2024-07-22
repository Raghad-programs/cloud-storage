<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TableController extends Controller
{
    public function table()
    {
        
        $users = User::all();
       
        // dd($users);

        return view('dashboard.table')->with('users',$users);
    }
}
