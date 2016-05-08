<?php
namespace App\Http\Controllers;
use App\Common\LanguagePage;

class WebsiteController extends Controller{
    public function index($url=''){
        $lang = new LanguagePage();
        $lang->defaultLanguage();
        new \App\Website\ViewPage($url);
    }
}
