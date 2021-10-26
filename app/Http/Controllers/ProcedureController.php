<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        $out = "";
        $reqJson = json_encode($req);
        $out = "";
        DB::select('call Login_Proc(?,?)', [$reqJson, $out]);

        dd(json_decode($out));
    }
}
