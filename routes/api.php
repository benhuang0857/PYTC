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
Route::get('login', 'ProcedureController@LoginProc');
Route::get('list/insert', 'ProcedureController@ListInsertProc');
Route::get('list/select', 'ProcedureController@ListSelectProc');
Route::get('user/insert', 'ProcedureController@UserInsertProc');
Route::get('user/select', 'ProcedureController@UserSelectProc');
Route::get('user/update', 'ProcedureController@UserUpdateProc');
