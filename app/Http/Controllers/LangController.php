<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LangController extends Controller
{

    public function change($lang){
        if(in_array($lang , ['en' , 'ar'])){
            App::setLocale($lang);
            Session::put('locale' , $lang);
        }

        return back();
    }

    public function changeWelcome($lang)
{
    if (in_array($lang, ['en', 'ar'])) {
        App::setLocale($lang);
        Session::put('locale', $lang);
    }

    // Try redirecting to the welcome route instead of back()
    return redirect()->route('welcome');
}
    
}
