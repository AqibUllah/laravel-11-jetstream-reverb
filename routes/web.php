<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $users = \App\Models\User::all();
        return Inertia::render('Dashboard',compact('users'));
    })->name('dashboard');
});


Route::post('send-message',function (\Illuminate\Http\Request $request) {
   \App\Events\TestEvent::dispatch($request->message,auth()->id());
})->name('send-message');
