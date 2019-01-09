<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');
Route::get('/sites', 'HomeController@sites');
Route::get('/test', 'CommissionCalculationController@calculate');
Route::get('/setglobals', 'CommissionCalculationController@setGlobalComms');

Route::post('/newsite', 'HomeController@newsite');
Route::post('/updatesite', 'HomeController@updatesite');
Route::post('/updatesitename', 'HomeController@updatesite');

Route::post('/teamcommission', 'TeamCommissionController@store');

Route::get('/sitebilling', 'TeamSiteController@sitebilling');

Route::post('/commission/defaults', 'SettingController@updateCommission');
Route::post('/commission/update', 'SettingController@updateTeamCommission');

Route::post('/profile/payouts/update', 'UserPayoutController@store');

Route::get('/get_team/{team}', function($team)
{
    return App\TeamSite::where('team_id', $team->id)
        ->first()->fqdn;
});