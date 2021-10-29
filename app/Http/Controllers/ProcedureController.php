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

        $jObj = json_decode($selectResult[0]->result);
        if($jObj->status == 'Y')
        {
            return json_encode(
                array(
                    'id' => $jObj->id,
                    'email' => $email,
                    'status' => $jObj->status
                )
            );
        }
        else
        {
            return response(json_encode(
                array(
                    //'errorMsg' => 'User Not Found'
                )
            ), 404)->header('Content-Type', 'application/json');
        }
    }

    #Mysql Call Proc List_Insert_Proc
    public function ListInsertProc(Request $req)
    {
        $gid = $req->gid;
        $gname = $req->gname;
        $mid = $req->mid;
        $id = $req->id;
        $item_no = $req->item_no;
        $item_name = $req->item_name;
        $upd_user = $req->upd_user;
        $json = 'json_object("gid","'.$gid.'","gname","'.$gname.'","mid","'.$mid.'","id","'.$id.'","item_no","'.$item_no.'","item_name","'.$item_name.'","upd_user","'.$upd_user.'")';

        dd($json);

        DB::select('call List_Insert_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');

        dd($selectResult);
        //return $selectResult;
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
