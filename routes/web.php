<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AisDataPositionController;


Route::get('/', [AisDataPositionController::class, 'streamData']);
