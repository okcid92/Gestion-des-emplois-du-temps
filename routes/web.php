<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SalleController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Redirect to appropriate dashboard based on role
    Route::get('/', function () {
        return app(DashboardController::class)->index();
    })->name('dashboard');

    // Admin routes
    Route::middleware(['auth', 'role:administrator'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
            Route::resource('users', UserController::class);
            Route::post('/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('users.reset-password');
            Route::resource('salles', SalleController::class);
            Route::resource('classes', ClassController::class);
            
            // Routes pour la gestion des emplois du temps
            Route::resource('schedules', ScheduleController::class);
            Route::get('/schedules-classic', [ScheduleController::class, 'classicView'])->name('schedules.classic');
            Route::get('/schedules/download', [ScheduleController::class, 'download'])->name('schedules.download');
            Route::get('/schedules/print', [DashboardController::class, 'printSchedule'])->name('schedules.print');
        });
    });

    // Professor routes
    Route::middleware(['auth', 'role:professor'])->prefix('professor')->name('professor.')->group(function () {
        Route::get('/schedules', [ProfessorController::class, 'schedules'])->name('schedules');
        Route::get('/schedules/download', [ProfessorController::class, 'downloadSchedule'])->name('schedule.download');
    });

    // Student routes
    Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/schedule', [StudentController::class, 'schedule'])->name('schedule');
        Route::get('/schedule/download', [StudentController::class, 'downloadSchedule'])->name('schedule.download');
    });
});
