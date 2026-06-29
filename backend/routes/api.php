<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\Admin\EquipmentController;
use App\Http\Controllers\Api\Admin\FaqController;
use App\Http\Controllers\Api\Admin\HeroController;
use App\Http\Controllers\Api\Admin\PageController;
use App\Http\Controllers\Api\Admin\PriceController;
use App\Http\Controllers\Api\Admin\RouteController;
use Illuminate\Support\Facades\Route;

// Public API
Route::prefix('v1')->group(function () {
    Route::get('hero', [PublicController::class, 'hero']);
    Route::get('routes', [PublicController::class, 'routes']);
    Route::get('routes/{slug}', [PublicController::class, 'route']);
    Route::get('equipment', [PublicController::class, 'equipment']);
    Route::get('prices', [PublicController::class, 'prices']);
    Route::get('faqs', [PublicController::class, 'faqs']);
    Route::get('pages/{slug}', [PublicController::class, 'page']);
});

// Auth
Route::prefix('v1/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Admin API (protected)
Route::prefix('v1/admin')->middleware(['auth:sanctum'])->group(function () {
    // Hero
    Route::apiResource('hero', HeroController::class);

    // Routes
    Route::apiResource('routes', RouteController::class);
    Route::post('routes/{route}/gallery', [RouteController::class, 'addGalleryImage']);
    Route::delete('routes/{route}/gallery/{mediaId}', [RouteController::class, 'removeGalleryImage']);

    // Equipment
    Route::apiResource('equipment', EquipmentController::class);

    // Prices
    Route::apiResource('prices', PriceController::class);

    // FAQ
    Route::apiResource('faqs', FaqController::class);
    Route::post('faqs/reorder', [FaqController::class, 'reorder']);

    // Pages
    Route::apiResource('pages', PageController::class);
});
