<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\OwnCors;

use App\Http\Controllers\AnnotationController;

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
        Route::post("/all", [AnnotationController::class, "getAllByCanvasId"]); 
        Route::post("/get_by_categories", [AnnotationController::class, "getByCategories"]); 
        Route::post("/create", [AnnotationController::class, "create"]);
        Route::post("/update", [AnnotationController::class, "update"]);
        Route::post("/delete", [AnnotationController::class, "delete"]);
    });
});