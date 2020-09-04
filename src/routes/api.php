<?php

use Illuminate\Support\Facades\Route;

Route::get('/talks/upcoming', 'TalkController@upcoming');