<?php declare(strict_types=1);

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LoginController::class, 'display'])->name('login.display');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::middleware('auth:web')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('task.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
    Route::get('/tasks/{task}/tracking', [TaskController::class, 'trackingTimeIndex'])->name('task.tracking');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
});
