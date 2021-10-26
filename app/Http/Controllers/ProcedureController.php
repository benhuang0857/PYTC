<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        //$out = "";
        DB::select('call testproc(?, @out)', [10]);
        $selectResult = DB::select('SELECT @out AS planReportID');
        dd($selectResult);
    }
}
