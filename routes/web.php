<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StudentController;

//Route::get('/send', [SmsController::class, 'send']);


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

// Student Inquiries
// Public store route for contact form submissions
Route::post('/inquiries', [\App\Http\Controllers\StudentInquiryController::class, 'store'])->name('inquiries.store');

// Protected routes for managing inquiries in the dashboard
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/inquiries', [\App\Http\Controllers\StudentInquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{studentInquiry}', [\App\Http\Controllers\StudentInquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{studentInquiry}', [\App\Http\Controllers\StudentInquiryController::class, 'update'])->name('inquiries.update');
    Route::delete('/inquiries/{studentInquiry}', [\App\Http\Controllers\StudentInquiryController::class, 'destroy'])->name('inquiries.destroy');
});

Route::get('test', function() {
    dispatch(function() {
        logger('hello from the queue!');
    })->delay(5);
    return 'Done';
});

Route::get('/dashboard', [StudentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Student CRUD endpoints (index served at /dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::patch('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::post('/students/{student}/approve', [StudentController::class, 'approve'])->name('students.approve');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Download: Case Guidelines document
Route::get('/download/case-guidelines', function () {
    $path = public_path('docs/CASE_GUIDELINES.html');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->download($path, 'MUBS_Case_Guidelines.html');
})->name('download.case-guidelines');

require __DIR__.'/auth.php';
