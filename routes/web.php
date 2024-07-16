<?php

use App\Http\Controllers\PersonController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('people', PersonController::class);
Route::post('people/{id}/ban', [PersonController::class, 'ban'])->name('people.ban');
Route::post('people/{id}/unban', [PersonController::class, 'unban'])->name('people.unban');

require __DIR__ . '/auth.php';
