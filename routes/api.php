<?php

use Illuminate\Support\Facades\Route;

Route::get(
    '/list-contexts',
    [\Novius\LaravelNovaContexts\Http\Controllers\ContextController::class, 'listContexts']
);

Route::post(
    '/update-current-context',
    [\Novius\LaravelNovaContexts\Http\Controllers\ContextController::class, 'updateCurrentContext']
);
