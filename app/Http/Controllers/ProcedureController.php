<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        $email = json_encode($req->user_email);
        $passwd = json_encode($req->user_password);

        //dd($email);
        $login = DB::select(
            'call Login_Proc(?,?)', [$email, $passwd]
        );

        dd($login);
    }
}
