<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AcademyController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ComunicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Credenciales Invalidas'], 401);
    }

    $user = Auth::user();

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // academias
    Route::get('/academy/list', [AcademyController::class, 'index']);
    Route::get('/academy/show/{id}', [AcademyController::class, 'show']);
    // cursos
    Route::get('/course/list', [CourseController::class, 'index']);
    Route::get('/course/show/{id}', [CourseController::class, 'show']);
    // estudiantes
    Route::get('/student/list', [StudentController::class, 'index']);
    Route::get('/student/show/{id}', [StudentController::class, 'show']);
    Route::post('/student/create', [StudentController::class, 'store']);
    Route::put('/student/edit/{id}', [StudentController::class, 'update']);
    Route::delete('/student/delete/{id}', [StudentController::class, 'destroy']);
    // pagos
    Route::post('/payment/create', [PaymentController::class, 'store']);
    Route::delete('/payment/delete/{id}', [PaymentController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // academias admin
    Route::post('/academy/create', [AcademyController::class, 'store']);
    Route::put('/academy/edit/{id}', [AcademyController::class, 'update']);
    Route::delete('/academy/delete/{id}', [AcademyController::class, 'destroy']);

    // cursos admin
    Route::post('/course/create', [CourseController::class, 'store']);
    Route::put('/course/edit/{id}', [CourseController::class, 'update']);
    Route::delete('/course/delete/{id}', [CourseController::class, 'destroy']);

    // comunicados admin
    Route::get('/comunication/list', [ComunicationController::class, 'index']);
    Route::get('/comunication/resend/{id}', [ComunicationController::class, 'resend']);
});
