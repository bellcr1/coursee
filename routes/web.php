<?php

use App\Http\Controllers\CoachController;
use App\Http\Controllers\FavoriteController;  // Add this line
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TranscriptionController;

use App\Http\Controllers\ContactController;


use App\Models\User;
use App\Http\Controllers\FeedbackController;

Route::resource('users', UserController::class)->middleware('auth');
Route::resource('courses', CourseController::class)->middleware('auth');
Route::resource('categories', CategoryController::class);





Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin-count', [App\Http\Controllers\UserController::class, 'countAdmins'])->name('admin.count');

// Course User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/coursesss', [CourseController::class, 'call'])->name('courses');
    Route::post('/coursesss', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/coursesss/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/course/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('course.details');
    Route::get('/courses/details/{id}', [CourseController::class, 'courseDetails'])->name('courses.coursedetails');
    Route::get('/checkout/{id}', [CourseController::class, 'checkout'])->name('checkout');
    Route::middleware(['auth'])->group(function () {
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/toggle/{course}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    });
});


// Remove this route as we'll use favorites.index instead
// Route::get('/favorite', function () {
//     return view('favorite');
// })->name('favorite');

// Update the favorites routes
Route::middleware(['auth'])->group(function () {
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
    Route::post('/favorite/toggle/{course}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
});

Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

Route::get('/trainers', [App\Http\Controllers\TrainerController::class, 'index'])->name('trainers');
// Remove or comment out this line
// Route::get('/coach/{id}', [App\Http\Controllers\TrainerController::class, 'show'])->name('coach.profile');

// Group all coach-related routes together
Route::middleware(['auth'])->group(function () {
    Route::get('/coach/{id}', [CoachController::class, 'show'])->name('coach.profile');
    Route::get('/coach/{id}/edit', [CoachController::class, 'edit'])->name('coach.edit');
    Route::put('/coach/{id}', [CoachController::class, 'update'])->name('coach.update');
});

// Update profile routes to use UserController instead
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{id}/editadmin', [UserController::class, 'edit'])->name('profile.editadmin');
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');
});
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


Route::get('/stats', [App\Http\Controllers\AdminController::class, 'percentageStats'])
    ->name('stats.page')
    ->middleware('auth');

    Route::middleware(['auth'])->group(function () {
        Route::get('/my-courses', function () {
            return view('boughtencourse');
        })->name('my-courses');
    });
    Route::get('/coach/{id}/edit', [CoachController::class, 'edit'])->name('coach.edit');
Route::put('/coach/{id}', [CoachController::class, 'update'])->name('coach.update');
Route::get('/profile/{id}/edit', [CoachController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}', [CoachController::class, 'update'])->name('profile.update');
// For CoachController
Route::get('/coach/{id}', [CoachController::class, 'show'])->name('coach.profile');

// OR for TrainerController
Route::post('/courses/{course}/purchase', [App\Http\Controllers\CourseController::class, 'purchase'])
    ->middleware('auth')
    ->name('courses.purchase');



    Route::get('/course/{id}/show', [CourseController::class, 'showquiz'])->name('course.show');
    Route::post('/quiz/launch', [CourseController::class, 'launchQuiz'])->name('quiz.launch');
    Route::post('/quiz/submit', [CourseController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/download-pdf/{pdfId}', [CourseController::class, 'downloadPdf'])->name('pdf.download');
    Route::post('/transcribe', [TranscriptionController::class, 'transcribe'])->name('transcribe');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contracts', [\App\Http\Controllers\Admin\ContractController::class, 'index'])->name('admin.contracts.index');
    Route::get('/contracts/create', [\App\Http\Controllers\Admin\ContractController::class, 'create'])->name('admin.contracts.create');
    Route::post('/contracts', [\App\Http\Controllers\Admin\ContractController::class, 'store'])->name('admin.contracts.store');
    Route::delete('/contracts/{contract}', [\App\Http\Controllers\Admin\ContractController::class, 'destroy'])->name('admin.contracts.destroy');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts.index');
    Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
});
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback', [FeedbackController::class, 'index'])->name('admin.feedback.index');
Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('admin.feedback.destroy');
