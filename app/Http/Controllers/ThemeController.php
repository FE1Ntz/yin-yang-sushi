<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    public function setTheme(Request $request)
    {
        Session::put('theme', $request->theme);
        return response()->json(['status' => 'success', 'data' => Session::get('theme','white')]);
    }

    public function getTheme()
    {
        $theme = Session::get('theme', 'white'); // 'white' as a default
        return response()->json(['theme' => $theme]);
    }
}
