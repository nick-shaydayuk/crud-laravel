<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
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

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::/* middleware('auth')-> */ resource('person', PersonController::class);
Route::post('person/{id}/restore', [PersonController::class, 'restore'])->name('person.restore');
Route::delete('person/{id}/force-delete', [PersonController::class, 'forceDelete'])->name('person.forceDelete');
Route::post('person/{id}/ban', [PersonController::class, 'ban'])->name('person.ban');
Route::post('person/{id}/unban', [PersonController::class, 'unban'])->name('person.unban');
Route::delete('person/{id}/delete', [PersonController::class, 'delete'])->name('person.delete');

require __DIR__ . '/auth.php';
