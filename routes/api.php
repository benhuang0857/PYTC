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
Route::post('login', 'ProcedureController@LoginProc')->middleware('cors');
Route::post('list/insert', 'ProcedureController@ListInsertProc')->middleware('cors');
Route::post('list/select', 'ProcedureController@ListSelectProc')->middleware('cors');
Route::get('user/insert', 'ProcedureController@UserInsertProc')->middleware('cors');
Route::get('user/select', 'ProcedureController@UserSelectProc')->middleware('cors');
Route::get('user/update', 'ProcedureController@UserUpdateProc')->middleware('cors');
