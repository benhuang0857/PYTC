<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTmp;
use App\PositionTmp;
use DB;
use DateTime;

class ProcedureController extends Controller
{
    #Mysql Call Proc Login_Proc
    public function LoginProc(Request $req)
    {
        $id         = $req->email;
        $password   = $req->password;

        try
        {
            $user = User::where('id', $id)->where('password', $password)->firstOrFail();
            return json_encode(
                array(
                    'email' => $id,
                    'status' => $user->isEnable
                ), JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }
    }

    #Mysql Call Proc User_Insert_Proc
    public function UserInsertProc(Request $req)
    {
        try
        {
            $now = new DateTime();

            $PositionTmp = new PositionTmp;
            $PositionTmp->id           = $req->email;
            $PositionTmp->unit         = '0';
            $PositionTmp->area         = '0';
            $PositionTmp->upd_user     = $req->upd_user;
            $PositionTmp->upd_date     = $now->format('Ymd');
            $PositionTmp->upd_time     = $now->format('His');
            $PositionTmp->save();

            $UserTmp = new UserTmp;
            $UserTmp->id           = $req->email;
            $UserTmp->password     = $req->password;
            $UserTmp->name         = $req->name;
            $UserTmp->upd_user     = $req->upd_user;
            $UserTmp->upd_date     = $now->format('Ymd');
            $UserTmp->upd_time     = $now->format('His');
            $UserTmp->save();

            return response(200)->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }
    }

    #Mysql Call Proc User_Select_Proc
    public function UserSelectProc(Request $req)
    {
        $keyword = $req->keyword;
        $unit = $req->unit;
        $area = $req->area;
        $isEnable = $req->isEnable;
        $pageSize = $req->pageSize;

        $users = DB::table('User')
                ->leftJoin('User_Position' , function($join) {
                    $join->on('User.id', '=', 'User_Position.id');
                })
                ->where('User_Position.unit', $unit)
                ->where('User_Position.area', $area)
                ->where('User.isEnable', $isEnable)
                ->get();

        $totalCount = count( $users );
        $totalPage = ceil( $totalCount/$pageSize );

        $usersArr = array();

        foreach($users as $key => $user)
        {
            $combin = [
                'email' => $user->id,
                'name' => $user->name,
                'unit' => $user->unit,
                'area' => $user->area,
                'isEnable' => $user->isEnable,
                'pageNumber' => (int)floor($key/$totalPage)
            ];
            array_push($usersArr, $combin);
        }

        dd($usersArr);

        try
        {
            $id = $req->email;
            $user = User::where('id', $id)->firstOrFail();
            return json_encode($user, JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
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
}
