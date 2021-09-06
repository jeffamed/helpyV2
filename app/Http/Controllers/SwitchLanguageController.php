<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SwitchLanguageController extends Controller
{
    public function switchLang($lang)
    {
        Session::put('locale', $lang);
        $response = ['status' => 'success', 'code' => '200', 'message' => 'Language was switched.', 'method' => 'GET'];
        return $response;
    }

    public function getLanguage()
    {
        $dir    = resource_path('lang'); //this for server
        $files2 = array_diff(scandir($dir), array('..', '.','.DS_Store'));

        return $files2;
    }
}
