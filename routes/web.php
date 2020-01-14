<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('login/teacher', 'Auth\LoginController@showLoginFormForTeacher')->name('login.teacher');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'TrainingController@index')->name('training.index');
    Route::post('/', 'TrainingController@submitExcel')->name('training.submitExcel');
    Route::get('/statistic', 'TrainingController@statistic')->name('training.statistic');
    Route::get('/statistic/{test}', 'TrainingController@statisticDetail')->name('training.statistic.detail');
    Route::get('/test', 'TrainingController@test')->name('training.test');
});