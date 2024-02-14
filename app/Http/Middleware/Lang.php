<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( isset($request->locale) && in_array($request->locale, ['ar','en'])) {
            app()->setLocale($request->locale);
            session()->flash('success' , __('language changed successfully.'));
        } 
        return $next($request);
    }
}