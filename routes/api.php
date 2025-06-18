<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(['status' => 'API is working!']);
});

Route::post('user', [UserController::class,"createUser"]);
Route::post('login', [AuthController::class,"loginUser"]);

Route::middleware("auth:sanctum")->group(callback:function (){
    Route::post('event', [EventController::class,"createEvent"]);
    Route::get('event/{id}', [EventController::class,"getEvent"]);
    Route::put('event/{id}', [EventController::class,"updateEvent"]);
    Route::delete('event/{id}', [EventController::class,"deleteEvent"]);
    
    
    
    Route::get('event/filter', [EventController::class,"filterEvent"]);
});