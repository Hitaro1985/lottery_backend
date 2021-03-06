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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->group(function() {
	Route::get('/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\LoginController@login')->name('admin.login.submit');
	Route::get('/logout', 'Auth\LoginController@logout')->name('admin.logout');
	
	Route::group(['middleware' => ['auth:admin']], function() {
		Route::get('/', 'AdminController@index')->name('admin.dashboard');
		Route::post('/getbetexpects', 'AdminAgentController@getbetexpects');
		Route::get('/betmanage', 'AdminBetController@index')->name('betcontroller');
		Route::post('/betmanage/setresult', 'AdminBetController@setresult');
		Route::post('/betmanage/pay', 'AdminBetController@pay');
        Route::get('/report-admin', 'ReportController@index')->name('report');
        Route::get('/report', 'ReportController@report_agent');
        Route::get('/result', 'ResultController@index')->name('result');
        Route::get('/credit', 'AdminAgentController@view_credit');
        Route::get('/trans-admin', 'AdminAgentController@trans_admin');
        Route::get('/trans', 'AdminAgentController@trans');
        Route::post('/serverSide', 'AdminBetController@serverSide')->name('serverSide');
		Route::get('/magentmanage', 'AdminAgentController@index');
		Route::post('/magentmanage/accept', 'AdminAgentController@master_accept');
		Route::post('/magentmanage/delete', 'AdminAgentController@master_delete');
		Route::post('/magentmanage/update-info', 'AdminAgentController@master_update_info');
        Route::post('/magentmanage/create-new', 'AdminAgentController@master_create_new');
        Route::get('/sagentmanage', 'AdminAgentController@sagentmanage');
        Route::post('/sagentmanage/create-new', 'AdminAgentController@senior_create_new');
		Route::get('/agentmanage', 'AdminAgentController@agentmanage');
		Route::post('/agentmanage/accept', 'AdminAgentController@accept');
		Route::post('/agentmanage/delete', 'AdminAgentController@delete');
		Route::post('/agentmanage/update-info', 'AdminAgentController@update_info');
        Route::post('/agentmanage/create-new', 'AdminAgentController@create_new');
		Route::post('/magentmange/sendmoney', 'AdminAgentController@sendmoney');
        Route::post('/agentmange/sendmoney', 'AdminAgentController@sendmoney');
		Route::post('/betmanagement/startnumberbet', 'AdminAgentController@startnumberbet');
        Route::post('/betmanagement/stopnumberbet', 'AdminAgentController@stopnumberbet');
        Route::post('/betstatus', 'AdminAgentController@betstatus');
        Route::get('/jackmanage', 'JackpotController@index');
        Route::post('/jackpot/getAgents', 'JackpotController@getAgents');
        Route::post('/jackpot/getReceipts', 'JackpotController@getReceipts');
        Route::post('/jackpot/getJack', 'JackpotController@getJack');
        Route::post('/jackpot/release', 'JackpotController@release');
        Route::post('/jackpot/releaseMajor', 'JackpotController@releaseMajor');
//		Route::resource('/creditcard', 'AdminCreditController');
	});
	Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
	Route::post('/register', 'Auth\RegisterController@register')->name('admin.register.submit');
});