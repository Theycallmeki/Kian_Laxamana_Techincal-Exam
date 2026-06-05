<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // We added ->names('api.employees') here so it doesn't conflict with web routes!
    Route::apiResource('employees', \App\Http\Controllers\Api\EmployeeController::class)->names('api.employees');

    // Also we might need to get factories for the select dropdown when editing an employee
    Route::get('factories', function () {
        return response()->json(\App\Models\Factory::all());
    });
});
