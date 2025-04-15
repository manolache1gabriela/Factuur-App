<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Models\Client;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $clients = Client::all();
    return Inertia::render('Welcome', ['clients' => $clients]);
})->name('home');
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';