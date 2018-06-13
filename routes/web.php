<?php
use App\Http\Controllers\FileController;
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

Route::get('/', function () {
    return view('pages.welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('pages.home');
//Surveyors page
Route::get('/surveyors', 'SurveyorsController@index')->name('surveyors');
//Delete a surveyor
Route::delete('surveyors/{id}', 'SurveyorsController@delete')->name('delete_surveyor');
//Surveys page
Route::get('/surveys', 'SurveysController@index')->name('surveys');
//Survey page
Route::get('/survey/{survey_id}', 'SurveysController@survey')->name('survey');
//Import participant file
Route::post('/survey/{survey_id}', 'SurveysController@import')->name('fileImport');
//change survey customization
Route::post('/survey/{survey_id}/custom', 'SurveysController@custom')->name('customization');