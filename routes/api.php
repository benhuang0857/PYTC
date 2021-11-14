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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//請在URL加上api/{route_name}這樣才有辦法calling下方API
Route::post('signin', 'ProcedureController@LoginProc')->middleware('cors');
Route::post('signup', 'ProcedureController@UserInsertProc')->middleware('cors');
Route::post('employee', 'ProcedureController@UserSelectProc')->middleware('cors');
Route::post('employee/update', 'ProcedureController@UserUpdateProc')->middleware('cors');

Route::post('menu', 'ProcedureController@ListSelectProc')->middleware('cors');

