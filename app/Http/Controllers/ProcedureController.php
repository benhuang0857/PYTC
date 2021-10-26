<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        DB::select('call Login_Proc(?, @out)', [$req]);
        $selectResult = DB::select('SELECT @out AS result');
        dd($selectResult);
    }
}
