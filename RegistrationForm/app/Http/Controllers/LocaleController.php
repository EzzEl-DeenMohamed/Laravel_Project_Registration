<?php

namespace App\Http\Controllers;


use App\Services\LocaleService;


class LocaleController extends Controller
{
    private LocaleService $_localeServices;
    public function __construct(LocaleService $localeServices) {
        $this->_localeServices = $localeServices;
    }
    public function setLocale($lang){
        $this->_localeServices->setLocaleServices($lang);
        return back();
    }
}
