<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private const ACCEPTED_LANGUAGES = [
        'vi',
        'en',
    ];

    private const LANG_KEY = 'lang';

    public function changeLanguage(Request $request, string $lang)
    {
        if (in_array($lang, self::ACCEPTED_LANGUAGES)) {
            session()->put(self::LANG_KEY, $lang);

            return back();
        }

        abort(400);
    }
}
