<?php
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::post('/clients', [ClientController::class, 'store']);