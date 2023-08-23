<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\OwnCors;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([OwnCors::class])->group(function() {
    Route::prefix("annotations")->group(function() {
        Route::post("", [App\Http\Controllers\AnnotationController::class, "create"]);
        Route::put("", [App\Http\Controllers\AnnotationController::class, "update"]);
        Route::delete("", [App\Http\Controllers\AnnotationController::class, "delete"]);
    });
});