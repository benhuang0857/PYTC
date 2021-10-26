<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        $out = "";
        $out = DB::select('call testproc(?, @outint)', [ 10 ]);
        dd($out);
    }
}
