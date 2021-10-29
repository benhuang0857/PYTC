<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProcedureController extends Controller
{
    #Mysql Call Proc Login_Proc
    public function LoginProc(Request $req)
    {
        $email = $req->email;
        $password = $req->password;
        $json = 'json_object("email","'.$email.'","password","'.$password.'")';

        DB::select('call Login_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');
        
        // str_replace('[','', $selectResult);
        // str_replace(']','', $selectResult);

        return json_encode($selectResult[0]->result);
    }

    #Mysql Call Proc List_Insert_Proc
    public function ListInsertProc(Request $req)
    {
        $json = json_encode($req);
        DB::select('call List_Insert_Proc(?, @out)', [$json]);
        $selectResult = DB::select('SELECT @out AS result');
        return $selectResult;
    }

    #Mysql Call Proc List_Select_Proc
    public function ListSelectProc(Request $req)
    {
        $json = json_encode($req);
        DB::select('call List_Select_Proc(?, @out)', [$json]);
        $selectResult = DB::select('SELECT @out AS result');
        return $selectResult;
    }

    #Mysql Call Proc User_Insert_Proc
    public function UserInsertProc(Request $req)
    {
        $json = json_encode($req);
        DB::select('call User_Insert_Proc(?, @out)', [$json]);
        $selectResult = DB::select('SELECT @out AS result');
        return $selectResult;
    }

    #Mysql Call Proc User_Select_Proc
    public function UserSelectProc(Request $req)
    {
        $json = json_encode($req);
        DB::select('call User_Select_Proc(?, @out)', [$json]);
        $selectResult = DB::select('SELECT @out AS result');
        return $selectResult;
    }

    #Mysql Call Proc User_Update_Proc
    public function UserUpdateProc(Request $req)
    {
        $json = json_encode($req);
        DB::select('call User_Update_Proc(?, @out)', [$json]);
        $selectResult = DB::select('SELECT @out AS result');
        return $selectResult;
    }
}
