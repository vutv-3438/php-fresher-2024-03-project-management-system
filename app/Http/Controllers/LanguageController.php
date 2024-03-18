<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private const ACCEPTED_LANGUAGES = [
        'vi',
        'en'
    ];

    private const LANG_KEY = 'lang';

    public function changeLanguage(Request $request, string $lang)
    {
        if (!in_array($lang, static::ACCEPTED_LANGUAGES)) {
            abort(400);
            return;
        }

        session()->put(static::LANG_KEY, $lang);
        return redirect()->back();
    }
}
