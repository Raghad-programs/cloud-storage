<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;


class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // $locale = Session::get('locale') ?? 'en';
        // Session::put('locale' , $locale);
        // App::setLocale($locale);

        // if($request->hasHeader('Accept-Language')){
        //     App::setLocale($request->header("Accept-Language"));
        // }
        if(Session::has('locale')){
            App::setLocale(session()->get('locale'));
        }
        return $next($request);
    }
}
