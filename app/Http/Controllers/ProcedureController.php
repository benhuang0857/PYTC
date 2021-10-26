<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        //$reqJson = json_encode($req);
        //$reqJson = `json_object("email","test4","password","test")`;
        $out = "";
        //DB::select('call Login_Proc(?,?)', [$reqJson, $out]);
        DB::select('call login_proc(json_object("email","test4","password","test"),?);', [$out]);
        dd($out);
    }
}
