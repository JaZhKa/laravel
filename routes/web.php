<?php

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/main', function () {
    return Inertia::render('Main/Main');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/main', [MainController::class, 'index'])->name('main.index');

// Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Route::get('/course', [CourseController::class, 'index'])->name('course.index');

// Route::middleware(['admin'])->group(function () {
//     Route::get('/about',  [AboutController::class, 'index'])->name('about.index');
// });

// // Route::get('/about', [AboutController::class, 'index', 'middleware' => 'admin'])->name('about.index');

// Route::get('/posts', [PostController::class, 'index'])->name('post.index');
// Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
// Route::post('/posts', [PostController::class, 'store'])->name('post.store');
// Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');
// Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
// Route::patch('/posts/{post}', [PostController::class, 'update'])->name('post.update');
// Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.delete');
// Route::get('/posts/update', [PostController::class, 'update']);
// Route::get('/posts/delete', [PostController::class, 'delete']);
// Route::get('/posts/restore', [PostController::class, 'restore']);
// Route::get('/posts/first_or_create', [PostController::class, 'firstOrCreate']);
// Route::get('/posts/update_or_create', [PostController::class, 'updateOrCreate']);
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
