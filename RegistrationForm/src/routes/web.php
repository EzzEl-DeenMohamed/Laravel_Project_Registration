<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendMessageRegistrationController;



Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('login',[AuthController::class,'login'])->name('login');
Route::post('login',[AuthController::class,'loginPost'])->name('login.post');
Route::get('logout',[AuthController::class,'logout'])->name('logout');

Route::get('registration',[AuthController::class,'registration'])->name('registration');
Route::post('registration',[AuthController::class,'registrationPost'])->name('registration.post');
Route::post('/send-message-registration', [SendMessageRegistrationController::class, 'send']);


Route::get('locale/{lang}',[LocaleController::class, 'setLocale']);
Route::get('adminPlace',[AuthController::class,'adminPlace'])->name('adminPlace')->middleware('admin');

Route::get('/test-exception', function () {
    throw new \App\Exceptions\FailedToLogin('Testing custom exception');
});

