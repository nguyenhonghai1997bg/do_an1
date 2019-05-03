<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function change_language ($locale)
    {
        app()->setLocale($locale);
        session(['locale' => $locale]);
        return redirect()->back();
    }
}
