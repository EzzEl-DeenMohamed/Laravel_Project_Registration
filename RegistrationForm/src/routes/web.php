<?php

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\SendMessageRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('Registration-Form1', [RegistrationController::class, 'registration'])->name('registration');
Route::post('Registration-Form1', [RegistrationController::class, 'registrationPost'])->name('registration.post');

Route::get('Registration-Form2', [RegistrationController::class, 'registration2'])
    ->name('registration2')->middleware('check.registration.progress:1');
Route::post('Registration-Form2', [RegistrationController::class, 'registrationPost2'])
    ->name('registration.post2');

Route::get('Registration-Form3', [RegistrationController::class, 'registration3'])
    ->name('registration3')->middleware('check.registration.progress:1');
Route::post('Registration-Form3', [RegistrationController::class, 'registrationPost3'])
    ->name('registration.post3');

Route::post('/send-message-registration', [SendMessageRegistrationController::class, 'send']);

Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);
Route::get('adminPlace', [RegistrationController::class, 'adminPlace'])->name('adminPlace')->middleware('admin');

Route::get('/test-exception', function () {
    throw new \App\Exceptions\FailedToLogin('Testing custom exception');
});

