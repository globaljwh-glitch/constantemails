<?php

//use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\ContactEnquiryController;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/contact-enquiries', [ContactEnquiryController::class, 'store']);
// });

use App\Http\Controllers\Api\ContactEnquiryController;

Route::middleware(['auth:sanctum', 'abilities:contact-enquiries'])
    ->post('/contact-enquiries', [ContactEnquiryController::class, 'store']);