<?php
namespace App\Services;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleService
{
    public function setLocaleServices($lang){
        if(in_array($lang,['en','ar'])){
            App::setLocale($lang);
            Session::put('locale',$lang);
        }
    }
}
