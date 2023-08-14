<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\instructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\topicController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Models\Transaksi;

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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/staff', function () {
//     return view('staff');
// })->middleware(['auth', 'verified'])->name('staff');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/staff', [StaffController::class, 'edit'])->name('staff.edit');
//     Route::patch('/staff', [StaffController::class, 'update'])->name('staff.update');
//     Route::delete('/staff', [StaffController::class, 'destroy'])->name('staff.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create/{id}', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::get('/list-transaksi', [TransaksiController::class, 'list_order'])->name('transaksi.list_order');
    Route::get('/list-transaksi/submit/{id}', [TransaksiController::class, 'submit'])->name('transaksi.submit');

});
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/instructor', [InstructorController::class, 'list'])->name('instructor.list');
    Route::get('/instructor/add', [InstructorController::class, 'add'])->name('instructor.add');
    Route::get('/instructor/edit/{id}', [InstructorController::class, 'edit'])->name('instructor.edit');
    Route::post('/instructor/update/{id}', [InstructorController::class, 'update'])->name('instructor.update');
    Route::get('/instructor/delete/{id}', [InstructorController::class, 'delete'])->name('instructor.delete');
    Route::get('/instructor/{id}', [InstructorController::class, 'view'])->name('instructor.view');
    Route::post('/instructor', [InstructorController::class, 'store'])->name('instructor.store');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/topic', [topicController::class, 'index'])->name('topics.index');
    Route::get('/topic/create', [topicController::class, 'create'])->name('topics.create');
    Route::get('/topic/edit/{id}', [topicController::class, 'edit'])->name('topics.edit');
    Route::post('/topic/update/{id}', [topicController::class, 'update'])->name('topics.update');
    Route::get('/topic/destroy/{id}', [topicController::class, 'destroy'])->name('topics.destroy');
    Route::post('/topic', [topicController::class, 'store'])->name('topics.store');
});

Route::middleware(['auth','role:staff,admin'])->group(function () {
    Route::get('/Course', [CourseController::class, 'index'])->name('course.index');
    Route::get('/Course/create', [CourseController::class, 'create'])->name('course.create');
    Route::get('/Course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('/Course/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::get('/Course/destroy/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::post('/Course', [CourseController::class, 'store'])->name('course.store');
    Route::get('/laporan-penjualan', [LaporanController::class, 'laporan'])->name('laporan');

});
require __DIR__.'/auth.php';
