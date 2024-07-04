<?php

use App\Http\Controllers\PeopleController;
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

Route::/* middleware('auth')-> */ resource('people', PeopleController::class)->except(['destroy']);
Route::post('people/{id}/restore', [PeopleController::class, 'restore'])->name('people.restore');
Route::delete('people/{id}/force-delete', [PeopleController::class, 'forceDelete'])->name('people.forceDelete');
Route::patch('people/{id}/ban', [PeopleController::class, 'ban'])->name('people.ban');
Route::patch('people/{id}/unban', [PeopleController::class, 'unban'])->name('people.unban');
Route::delete('people/{id}/delete', [PeopleController::class, 'delete'])->name('people.delete');

require __DIR__ . '/auth.php';
