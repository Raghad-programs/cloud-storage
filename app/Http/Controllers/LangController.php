<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{

    public function change($lang){
        if(in_array($lang , ['en' , 'ar'])){
            App::setLocale($lang);
            Session::put('locale' , $lang);
        }
        return back();
    }
    // public function change($lang){
    //     Session::put('lang' , $lang);
    //     return back();
    // }
}
