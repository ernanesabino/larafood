<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/plans', 'Admin\PlanController@index')->name('plans.index');

Route::get('/', function () {
    return view('welcome');
});
