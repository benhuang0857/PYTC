<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTmp;
use App\PositionTmp;
use App\ListMenu;
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
                'pageNumber' => (int)($key/$totalPage) #錯誤頁數
            ];
            array_push($usersArr, $combin);
        }

        try
        {
            return json_encode([
                "totalCount" => $totalCount, 
                "totalPage" => $totalPage, 
                "data" => $combin
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }
    }

    #Mysql Call Proc User_Update_Proc
    public function UserUpdateProc(Request $req)
    {
        $user = UserTmp::where('id', $req->email)->first();
        $user->password = $req->password;
        $user->name = $req->name;

        try
        {
            $user->save();
            return response(200)->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }

    }

    #Mysql Call Proc List_Select_Proc
    public function ListSelectProc(Request $req)
    {
        $group_id = $req->group_id;
        $lists = ListMenu::where('group_id', $group_id)
                         ->where('item_value', '!=', '')->get();

        $menuArr = array();
        $totalCount = 0;

        foreach($lists as $key => $list)
        {
            $combin = [
                'text' => $list->item_value,
                'value' => $list->item_name
            ];
            array_push($menuArr, $combin);
        }

        $totalCount = count($menuArr);

        try
        {
            return json_encode(
                [
                    'totalCount' => $totalCount,
                    'totalPage' => 0,
                    'data' => $menuArr,
                    'pageSize' => 10,
                    'pageNumber' => 1
                ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }
    }
}
