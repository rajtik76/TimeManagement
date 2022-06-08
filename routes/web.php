<?php declare(strict_types=1);

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTrackingTimeController;
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

    Route::controller(TaskController::class)->group(function () {
        Route::get('/tasks', 'index')->name('task.index');
        Route::get('/tasks/create', 'create')->name('task.create');
        Route::post('/tasks', 'store')->name('task.store');
        Route::get('/tasks/{task}/edit', 'edit')->name('task.edit');
        Route::put('/tasks/{task}', 'update')->name('task.update');
        Route::delete('/tasks/{task}', 'destroy')->name('task.destroy');
        Route::get('/tasks/{task}/tracking', 'trackingTimeIndex')->name('task.tracking');
        Route::get('/tasks/inactive/toggle', 'toggleDisplayInactiveTask')->name('tasks.inactive.toggle');
    });

    Route::controller(TaskTrackingTimeController::class)->group(function() {
        Route::delete('/tracking-times/{trackingTime}', 'destroy')->name('tracking-times.destroy');
        Route::get('/tracking-times/pdf/{year}/{month}', 'toPdf')->name('tracking-times.pdf');
    });
});
