<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SmartCityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes (SRS 10.4)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/smart-city', [SmartCityController::class, 'index'])->name('smart-city');
Route::get('/competition', [CompetitionController::class, 'index'])->name('competition');
Route::get('/rules', [CompetitionController::class, 'rules'])->name('rules');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/organizer', [HomeController::class, 'organizer'])->name('organizer');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])
    ->middleware('throttle:10,1') // Rate limiting for registration (SRS 8.2)
    ->name('register.store');
Route::get('/registration/success', [RegistrationController::class, 'success'])->name('registration.success');

/*
|--------------------------------------------------------------------------
| Admin routes (SRS 7.1)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])
        ->middleware('throttle:5,1') // Rate limiting for login (SRS 8.2)
        ->name('login.attempt');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
        Route::get('/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');
        Route::get('/registrations/{registration}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
        Route::patch('/registrations/{registration}', [AdminRegistrationController::class, 'update'])->name('registrations.update');
        Route::delete('/registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');

        Route::get('/faqs', [AdminController::class, 'faqs'])->name('faqs.index');
        Route::post('/faqs', [AdminController::class, 'storeFaq'])->name('faqs.store');
        Route::patch('/faqs/{faq}', [AdminController::class, 'updateFaq'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [AdminController::class, 'destroyFaq'])->name('faqs.destroy');

        Route::get('/content', [AdminController::class, 'content'])->name('content.index');
        Route::post('/content', [AdminController::class, 'updateContent'])->name('content.update');

        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});
