<?php

use Illuminate\Support\Facades\Route;

Route::get('/talks/upcoming', 'TalkController@upcoming');
Route::post('/user/register', 'AuthController@register');
Route::middleware(['auth:api'])->group(function () {
     Route::get('/user/my-talks', 'TalkController@userTalks');
 });
