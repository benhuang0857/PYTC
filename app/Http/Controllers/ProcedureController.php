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

    #Mysql Call Proc List_Insert_Proc 開發中
    public function ListInsertProc(Request $req)
    {
        $gid = $req->gid;
        $gname = $req->gname;
        $mid = $req->mid;
        $id = $req->id;
        $item_no = $req->item_no;
        $item_name = $req->item_name;
        $upd_user = $req->upd_user;
        //$json = 'json_object("gid","'.$gid.'","gname","'.$gname.'","mid","'.$mid.'","id","'.$id.'","item_no","'.$item_no.'","item_name","'.$item_name.'","upd_user","'.$upd_user.'")';
        $json = `JSON_OBJECT("name","Jane","email","Jane@pyct.com","password","test","position",'[{"area": 2, "unit": 2}]')`;

        DB::select('call List_Insert_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');

        dd($selectResult);
        //return $selectResult;
    }

    #Mysql Call Proc List_Select_Proc
    public function ListSelectProc(Request $req)
    {
        $func = $req->func;
        $gid = $req->gid;
        $mid = $req->mid;
        $json = 'json_object("func","'.$func.'","gid","'.$gid.'","mid","'.$mid.'")';

        DB::select('call List_Select_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');

        $jObj = json_decode($selectResult[0]->result);
        if($jObj != null)
        {
            return json_encode(
                $jObj
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

    #Mysql Call Proc User_Insert_Proc 有異常
    public function UserInsertProc(Request $req)
    {
        $name = $req->name;
        $email = $req->email;
        $password = $req->password;
        $position = $req->position; //有異常
        $upd_user = $req->upd_user;
        $json = 'json_object("name","'.$name.'","email","'.$email.'","password","'.$password.'","position","'.$position.'","upd_user","'.$upd_user.'")';

        DB::select('call User_Insert_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');

        $jObj = json_decode($selectResult[0]->result);
        if($jObj != null)
        {
            return json_encode(
                $jObj
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

    #Mysql Call Proc User_Select_Proc
    public function UserSelectProc(Request $req)
    {
        $func = $req->func;
        $id = $req->id;
        $keyword = $req->keyword;
        $position_unit = $req->position_unit;
        $position_area = $req->position_area;
        $enable = $req->enable;
        $json = 'json_object("func","'.$func.'","id","'.$id.'","keyword","'.$keyword.'","position_unit","'.$position_unit.'","position_area","'.$position_area.'","enable","'.$enable.'")';

        DB::select('call User_Select_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');

        $jObj = json_decode($selectResult[0]->result);
        if($jObj != null)
        {
            return json_encode(
                $jObj
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

    #Mysql Call Proc User_Update_Proc
    public function UserUpdateProc(Request $req)
    {
        $id = $req->id;
        $name = $req->name;
        $email = $req->email;
        $password = $req->password;
        $position = $req->position;
        $enable_cd = $req->enable_cd;
        $upd_user = $req->upd_user;
        $json = 'json_object("id","'.$id.'","name","'.$name.'","email","'.$email.'","password","'.$password.'","position","'.$position.'","enable_cd","'.$enable_cd.'","upd_user","'.$upd_user.'")';

        DB::select('call User_Update_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');

        $jObj = json_decode($selectResult[0]->result);
        if($jObj != null)
        {
            return json_encode(
                $jObj
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
}
