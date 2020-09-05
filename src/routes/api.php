<?php

use Illuminate\Support\Facades\Route;

Route::get('/talks/upcoming', 'TalkController@upcoming');
Route::post('/user/register', 'AuthController@register');
Route::post('/user/login', 'AuthController@login');

Route::middleware(['auth:api'])->group(
    function () {
        Route::get('/user/my-talks', 'TalkController@userTalks');
        Route::post('/talks', 'TalkController@create');
        Route::get('/talks/{id}', 'TalkController@read');
        Route::post('/talks/{id}', 'TalkController@edit');
        Route::put('/talks/{id}', 'TalkController@publish');
    }
);
