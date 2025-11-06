<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StudentController;

Route::get('/send', [SmsController::class, 'send']);


Route::get('/', function () {
    return view('home');
})->name('home.page');

Route::get('/about', function () {
    return view('about');
});

Route::post('/save', [StudentController::class, 'store'])->name('student.save');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('test', function() {
    dispatch(function() {
        logger('hello from the queue!');
    })->delay(5);
    return 'Done';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
