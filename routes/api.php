<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login', 'API\ApiAuthUserCtrl@authenticate');
Route::post('round/getCurrentInfo', 'API\ApiAgentController@getCurrentInfo');
Route::post('round/getLastRoundInfo', 'API\ApiAgentController@getLastRoundInfo');
Route::post('round/getHomeInfo', 'API\ApiAgentController@getHomepageInfo');
Route::post('round/getResultInfo', 'API\ApiAgentController@getResultInfo');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('round/getMyBetInfo', 'API\ApiAgentController@getMyBetInfo');
    Route::post('round/getReportInfo', 'API\ApiAgentController@getReportInfo');
    Route::post('round/confirmBet', 'API\ApiAgentController@confirmBet');
    Route::post('round/cancelBet', 'API\ApiAgentController@cancelBet');
});