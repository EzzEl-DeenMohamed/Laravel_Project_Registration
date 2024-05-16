<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('login',[AuthManager::class,'login'])->name('login');
Route::post('login',[AuthManager::class,'loginPost'])->name('login.post');
Route::get('registration',[AuthManager::class,'registration'])->name('registration');
Route::post('registration',[AuthManager::class,'registrationPost'])->name('registration.post');
Route::get('logout',[AuthManager::class,'logout'])->name('logout');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});
