<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
});

use App\Http\Controllers\ProductController;

Route::get('/upload-csv-paths', [ProductController::class, 'uploadCSVFromPaths']);

use App\Http\Controllers\QueueManagerController;

Route::post('/queue/start', [QueueManagerController::class, 'startQueue'])->name('queue.start');
Route::post('/queue/stop', [QueueManagerController::class, 'stopQueue'])->name('queue.stop');

use Illuminate\Http\Request;
use App\Models\JobStatus;

Route::get('/queue/progress', function (Request $request) {
    return response()->json(JobStatus::all());
});
