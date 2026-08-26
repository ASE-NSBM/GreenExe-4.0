<?php

use App\Http\Controllers\Admin\RegistrationExportController;
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
|
| The administration area is the Filament panel registered by
| App\Providers\Filament\AdminPanelProvider, which owns /admin and covers
| FR-56 to FR-71. Only the CSV export stays a plain route: it streams a file
| download, which is not something a Livewire page can return.
|
*/

Route::get('/admin/export', RegistrationExportController::class)
    ->middleware('admin')
    ->name('admin.registrations.export');

// SRS 7.1 names two paths that Filament exposes under different URLs. These
// keep the documented addresses working.
Route::redirect('/admin/dashboard', '/admin')->name('admin.dashboard');
Route::redirect('/admin/content', '/admin/competition-information')->name('admin.content.index');
