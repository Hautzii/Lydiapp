<?php

use App\Http\Controllers\FormationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/interns', [InternController::class, 'index'])->name('interns.index');
Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::middleware([App\Http\Middleware\IsAdmin::class])->group(function () {

    Route::get('/interns/create', [InternController::class, 'create'])->name('interns.create');
    Route::post('/interns/create', [InternController::class, 'store'])->name('interns.store');
    Route::get('/interns/{intern}/edit', [InternController::class, 'edit'])->name('interns.edit');
    Route::patch('/interns/{intern}', [InternController::class, 'update'])->name('interns.update');
    Route::delete('/interns/{intern}', [InternController::class, 'destroy'])->name('interns.destroy');
    Route::resource('interns', InternController::class)->except('index');
    Route::get('/formations/create', [FormationController::class, 'create'])->name('formations.create');
    Route::post('/formations/create', [FormationController::class, 'store'])->name('formations.store');
    Route::get('/formations/{formation}/edit', [FormationController::class, 'edit'])->name('formations.edit');
    Route::patch('/formations/{formation}', [FormationController::class, 'update'])->name('formations.update');
    Route::delete('/formations/{formation}', [FormationController::class, 'destroy'])->name('formations.destroy');
    Route::post('/interns/{intern}/favorite', [InternController::class, 'favorite'])->name('interns.favorite');
    Route::delete('/interns/{intern}/favorite', [InternController::class, 'unfavorite'])->name('interns.unfavorite');
    Route::get('/interns/favorites', [InternController::class, 'favorites'])->name('interns.favorites');
});

require __DIR__.'/auth.php';
