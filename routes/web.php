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
		Route::get('/betmanage', 'AdminBetController@index')->name('betcontroller');
		Route::post('/betmanage/setresult', 'AdminBetController@setresult');
		Route::post('/betmanage/pay', 'AdminBetController@pay');
        Route::get('/report-admin', 'ReportController@index')->name('report');
        Route::get('/report', 'ReportController@report_agent');
        Route::get('/credit', 'AdminAgentController@view_credit');
        Route::get('/trans-admin', 'AdminAgentController@trans_admin');
        Route::get('/trans', 'AdminAgentController@trans');
		Route::get('/magentmanage', 'AdminAgentController@index');
		Route::post('/magentmanage/accept', 'AdminAgentController@master_accept');
		Route::post('/magentmanage/delete', 'AdminAgentController@master_delete');
		Route::post('/magentmanage/update-info', 'AdminAgentController@master_update_info');
		Route::get('/agentmanage', 'AdminAgentController@agentmanage');
		Route::post('/agentmanage/accept', 'AdminAgentController@accept');
		Route::post('/agentmanage/delete', 'AdminAgentController@delete');
		Route::post('/agentmanage/update-info', 'AdminAgentController@update_info');
		Route::post('/magentmange/sendmoney', 'AdminAgentController@sendmoney');
        Route::post('/agentmange/sendmoney', 'AdminAgentController@sendmoney');
		Route::post('/betmanagement/startnumberbet', 'AdminAgentController@startnumberbet');
        Route::post('/betmanagement/stopnumberbet', 'AdminAgentController@stopnumberbet');
//		Route::resource('/creditcard', 'AdminCreditController');
	});
	Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
	Route::post('/register', 'Auth\RegisterController@register')->name('admin.register.submit');
});