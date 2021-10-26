<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    public function LoginProc(Request $req)
    {
        $email = $req->user_email;
        $passwd = $req->user_password;

        $login = DB::select(
            'call Login_Proc(?)', json_decode([$email, $passwd])
        );

        dd($login);
    }
}
