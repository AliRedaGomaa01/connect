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
        if ($request->hasHeader('X-Localization') && in_array($request->header('X-Localization'), ['ar','en'])) {
            $locale = $request->header('X-Localization');
        }
        else if( isset($request->locale) && in_array($request->locale, ['ar','en'])) {
            $locale = $request->locale;
        } else {
            $locale = session('locale') ?? app()->currentLocale();
        }
        app()->setLocale($locale);
        session()->put('locale', $locale);
        $request->headers->set('X-Localization', $locale);
        return $next($request);
    }
}