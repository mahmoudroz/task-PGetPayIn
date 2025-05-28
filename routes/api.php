<?php

use App\Http\Controllers\Api\V1\User\Activity\ActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ChangeLanguage;
use App\Http\Middleware\CustomSanctumAuth;
use App\Http\Controllers\Api\V1\User\Post\PostController;
use App\Http\Controllers\Api\V1\User\Profile\ProfileController;
use App\Http\Controllers\Api\V1\User\Authentication\Login\LoginController;
use App\Http\Controllers\Api\V1\User\Authentication\Register\RegisterController;
use App\Http\Controllers\Api\V1\User\Platform\PlatformController;

Route::group([
    'prefix'        => 'v1/user',
    'namespace'     => 'App\Http\Controllers\Api\V1',
    'middleware'    => ['api', ChangeLanguage::class],
], function () {
   
    Route::group(['prefix' => 'auth',], function () {
        Route::post('/register', [RegisterController::class, 'register']);
        Route::post('/login', [LoginController::class, 'login']);
        
    });

    Route::group(['middleware' => [CustomSanctumAuth::class]], function () {
        
        Route::prefix('profile')->controller(ProfileController::class)->group(function () {
            Route::get('/', 'show');
            Route::put('/', 'update');
            Route::post('/logout', 'logout');
        });

        Route::get('/platforms', [PlatformController::class, 'index']);
        Route::apiResource('posts', PostController::class);
        Route::get('/activities', [ActivityController::class, 'index']);


    });

});
