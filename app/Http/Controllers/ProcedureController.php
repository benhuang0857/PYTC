<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        $email = $req->email;
        $passwd = $req->password;
        $login = DB::select(
            'call Login_Proc(?,?)', [$req->email, $req->passwd]
        );

        dd($login);
    }
}
