<?php

use Illuminate\Support\Facades\Route;
use KiranoDev\LaravelSeo\Http\Controllers\Api\SeoController;

Route::prefix(config('seo.api_prefix') . 'seo')
    ->controller(SeoController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::patch('/', 'update');
});