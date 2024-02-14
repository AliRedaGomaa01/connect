<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // public function lang(?string $locale, Request $request)
    // {
    //     if (isset($locale) && in_array($locale, ['en', 'ar'])) {
    //         dd(request()->path() );
    //         return app()->setLocale('$locale');
    //     }
    // }

}