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

Route::get('/setup', 'WelcomeController@setup');

Route::get('/home', 'HomeController@show');
Route::get('/teamswitchlatest', 'HomeController@switchTeamLatest');
Route::get('/userdashboard', 'HomeController@switchDashboard');
Route::get('/sites', 'HomeController@sites');
Route::get('/test', 'CommissionCalculationController@calculate');
Route::get('/setglobals', 'CommissionCalculationController@setGlobalComms');

Route::post('/new-standalone-site-port', 'HomeController@newsiteNonTenantPort');
Route::post('/new-standalone-site', 'HomeController@newsiteNonTenant');
Route::post('/newsite', 'HomeController@newsite');
Route::post('/updatesite', 'HomeController@updatesite');
Route::post('/updatesitehttps', 'HomeController@siteHttpsUpdate');

Route::post('/updatesitename', 'HomeController@updatesitename');

Route::post('/teamcommission', 'TeamCommissionController@store');

Route::get('/sitebilling', 'TeamSiteController@sitebilling');

Route::post('/updatesiteowner', 'TeamSiteController@ownerswitch');

Route::post('/kiosk/limits/update/{subTotal}', 'SubscriptionTotalController@updateLimit');

Route::get('/kiosk/sitelimits/show/{subTotal}', 'SiteSubscriptionTotalController@show');

Route::post('/kiosk/sitelimits/update/{subTotal}', 'SiteSubscriptionTotalController@updateSiteLimit');

Route::post('/kiosk/module-extras/add/{site}', 'ExtraSiteBillingController@addSiteExtra');

Route::post('/kiosk/module-extras/update/{extraBilling}', 'ExtraSiteBillingController@updateSiteExtra');

Route::get('/kiosk/module-extras/remove/{extraBilling}', 'ExtraSiteBillingController@destroy');

Route::post('/kiosk/metrics/modulecategories/create', 'ExtraModuleBillingController@store');

Route::post('/kiosk/metrics/modulecategories/update/{extraModule}', 'ExtraModuleBillingController@update');

Route::get('/kiosk/metrics/modulecategories/remove/{extraModule}', 'ExtraModuleBillingController@destroy');


Route::post('/commission/defaults', 'SettingController@updateCommission');
Route::post('/commission/update', 'SettingController@updateTeamCommission');

Route::post('/profile/payouts/update', 'UserPayoutController@store');
Route::put('/settings/profile/details', 'ProfileDetailsController@update');

Route::get('/get_team/{team}', function($team)
{
    return App\TeamSite::where('team_id', $team->id)
        ->first()->fqdn;
});