<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScreenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
//    Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//    Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
//    Route::get('/user/{id}/screens', [ScreenController::class, 'otherPageScreens']);
//    Screens
    Route::get('/screens', [ScreenController::class, 'index']);
//    Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/update-screen-project', [ProjectController::class, 'updateScreenProject'])->name('update.screen.project');
    Route::post('/add-screen', [ProjectController::class, 'addScreen'])->name('add.screen');
    Route::post('/create-project', [ProjectController::class, 'createProject'])->name('create.project');
    Route::get('/add-project', [ProjectController::class, 'addProject'])->name('add.project');



    Route::post('/register-uuid', [ScreenController::class, 'registerUUID'])->name('screen.registerUUID');
    Route::get('/view', [ScreenController::class, 'view'])->name('screen.view');
    Route::post('/fetchdata', [ScreenController::class, 'fetchdata'])->name('screen.fetchdata');



});

require __DIR__.'/auth.php';
