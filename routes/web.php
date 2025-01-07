<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/signup', [UserController::class, 'showSignupForm' ])->name('signup');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/signup', [UserController::class, 'signup']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/dashboard', [StudentController::class, 'store']);
    Route::post('/students/{id}/update', [StudentController::class, 'update']);
    Route::delete('/students/{id}/delete', [StudentController::class, 'delete'])->name('students.delete');

    Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
    Route::post('/student/import', [StudentController::class, 'import'])->name('students.import');

    Route::post('/certificates', [StudentController::class, 'generateCert'])->name('students.certificates');

});

//TEST for PDF download
Route::get('/test-pdf', function () {
    $pdf = PDF::loadHTML('<h1>Test PDF</h1>');
    return $pdf->download('test.pdf');
});
