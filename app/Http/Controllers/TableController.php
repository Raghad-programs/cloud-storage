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
        $users = User::where('Depatrment_id' , auth()->user()->Depatrment_id)->get();
        return view('dashboard.layouts.table')->with('users',$users);
    }
}
