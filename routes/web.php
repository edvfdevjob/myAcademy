<?php

use Illuminate\Support\Facades\Route;

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
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD Academia
    Route::get('/academy/list', function() {
        return view('academy.index');
    })->name('academy.index');
    Route::get('/academy/create/{id?}', function($id = null) {
        return view('academy.create', ['id' => $id]);
    })->name('academy.create');
    
    // CRUD Curso
    Route::get('/course/list', function() {
        return view('course.index');
    })->name('course.index');
    Route::get('/course/create/{id?}', function($id = null) {
        return view('course.create', ['id' => $id]);
    })->name('course.create');

    // CRUD Estudiante
    Route::get('/student/list', function() {
        return view('student.index');
    })->name('student.index');
    Route::get('/student/create/{id?}', function($id = null) {
        return view('student.create', ['id' => $id]);
    })->name('student.create');

    // CRUD Pagos
    Route::get('/payment/list', function() {
        return view('payment.index');
    })->name('payment.index');


    // CRUD Comunicados
    Route::get('/comunication/list', function() {
        return view('comunication.index');
    })->name('comunication.index');
    Route::get('/comunication/create/{id?}', function($id = null) {
        return view('comunication.create', ['id' => $id]);
    })->name('comunication.create');
});
