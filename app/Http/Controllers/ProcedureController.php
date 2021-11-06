<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class ProcedureController extends Controller
{
    #Mysql Call Proc Login_Proc
    public function LoginProc(Request $req)
    {
        $id         = $req->email;
        $password   = $req->password;

        $q = DB::select('SELECT Login_Func("'.$id.'", "'.$password.'") as Result from dual');
        
        dd( $q[0]->Result );

        //dd(json_decode( $q[0] ));
        // try {
        //     $user = User::where('id', $id)->where('password', $password)->firstOrFail();
        //     //dd($user);
        //     return json_encode(
        //         array(
        //             'email' => $id,
        //             'status' => $user->isEnable
        //         ), JSON_UNESCAPED_UNICODE);
        // } catch (\Throwable $th) {
            
        //     return response(json_encode(
        //         array(
        //             //'errorMsg' => 'User Not Found'
        //         )
        //     ), 404)->header('Content-Type', 'application/json');
        // }
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
        $json = 'json_object("gid","'.$gid.'","gname","'.$gname.'","mid","'.$mid.'","id","'.$id.'","item_no","'.$item_no.'","item_name","'.$item_name.'","upd_user","'.$upd_user.'")';

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
                $jObj, JSON_UNESCAPED_UNICODE
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
        //$json = 'json_object("name","'.$name.'","email","'.$email.'","password","'.$password.'","position","'.$position.'","upd_user","'.$upd_user.'")';

        $json = 'JSON_OBJECT("name","Janee","email","Janeee@pyct.com","password","test","position",JSON_ARRAY(JSON_OBJECT("area",1,"unit",2),JSON_OBJECT("area",1,"unit",3)))';

        DB::select('call User_Insert_Proc('.$json.', @out)');
        $selectResult = DB::select('SELECT @out AS result');

        $jObj = json_decode($selectResult[0]->result);
        if($jObj != null)
        {
            return json_encode($jObj, JSON_UNESCAPED_UNICODE);
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
                $jObj, JSON_UNESCAPED_UNICODE
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
                $jObj, JSON_UNESCAPED_UNICODE
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
