<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        $json = json_encode($req);
        DB::select('call Login_Proc(?, @out)', [$json]);
        $selectResult = DB::select('SELECT @out AS result');
        dd($selectResult);
    }
}
