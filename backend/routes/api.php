<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

route::apiResource('anime', AnimeController::class);
route::apiResource('genre', GenreController::class);