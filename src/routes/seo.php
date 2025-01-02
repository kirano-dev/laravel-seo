<?php

use Illuminate\Support\Facades\Route;
use KiranoDev\LaravelSeo\Http\Controllers\Api\SeoController;

Route::prefix(config('seo.api_prefix'))->group(function () {
    Route::apiResource('seo', SeoController::class)->except(['show']);
});