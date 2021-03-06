<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTmp;
use App\PositionTmp;
use App\Position;
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
        $unitArr = $req->units;
        try
        {
            $now = new DateTime();
            foreach ($unitArr as $item) {
                $PositionTmp = new Position;
                $PositionTmp->id           = $req->email;
                $PositionTmp->unit         = $item['unit'];
                $PositionTmp->area         = $item['area'];
                $PositionTmp->upd_user     = 'admin@gmail.com';
                $PositionTmp->upd_date     = $now->format('Ymd');
                $PositionTmp->upd_time     = $now->format('His');
                $PositionTmp->save();
            }
            
            $UserTmp = new User;
            $UserTmp->id           = $req->email;
            $UserTmp->password     = $req->password;
            $UserTmp->name         = $req->name;
            $UserTmp->isEnable     = 'Y';
            $UserTmp->upd_user     = 'admin@gmail.com';
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
        $pageSize = 10;
        $pageNumber = 1;

        if($isEnable != "")
        {
            if($unit != "" && $area != "" )
            {
                $users = DB::table('User')
                    ->leftJoin('User_Position' , function($join) {
                        $join->on('User.id', '=', 'User_Position.id');
                    })
                    ->where('User_Position.unit', $unit)
                    ->where('User_Position.area', $area)
                    ->where('User.isEnable', $isEnable)
                    ->get();
            }

            if($unit == "" && $area == "" )
            {
                $users = DB::table('User')
                    ->leftJoin('User_Position' , function($join) {
                        $join->on('User.id', '=', 'User_Position.id');
                    })
                    ->where('User.isEnable', $isEnable)
                    ->get();
            }
        }
        else
        {
            if($unit != "" && $area != "" )
            {
                $users = DB::table('User')
                    ->leftJoin('User_Position' , function($join) {
                        $join->on('User.id', '=', 'User_Position.id');
                    })
                    ->where('User_Position.unit', $unit)
                    ->where('User_Position.area', $area)
                    ->get();
            }

            if($unit == "" && $area == "" )
            {
                $users = DB::table('User')
                    ->leftJoin('User_Position' , function($join) {
                        $join->on('User.id', '=', 'User_Position.id');
                    })->get();
            }
        }

        //dd($users);

        $totalCount = count( $users );
        $totalPage = ceil( $totalCount/$pageSize );

        $usersArr = array();

        foreach($users as $key => $user)
        {
            $unitsArr = array();
            $positions = Position::where('id', $user->id)->get();

            foreach ($positions as $key => $pos) {

                $areaName = ListMenu::where('group_id', 'pos_area')
                                    ->where('item_value', $pos->area)->first()->item_name;
                $unitName = ListMenu::where('group_id', 'pos_unit')
                                    ->where('item_value', $pos->unit)->first()->item_name;

                $unitTmp = [
                    'unit' => $unitName,
                    'area' => $areaName,
                ];
                $unitTmpJson = $unitTmp;
                array_push($unitsArr, $unitTmpJson);
            }

            $combin = [
                'email' => $user->id,
                'name' => $user->name,
                'units' => $unitsArr,
                'isEnable' => $user->isEnable,
            ];
            array_push($usersArr, $combin);
        }

        try
        {
            return json_encode([
                "totalCount" => $totalCount, 
                "totalPage" => $totalPage, 
                "data" => $usersArr,
                'pageSize' => $pageSize,
                'pageNumber' => $totalPage
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }
    }

    #Mysql Call Proc User_Select_Proc One person
    public function UserSelectOneProc(Request $req)
    {
        $id = $req->email;

        $users = DB::table('User')
        ->leftJoin('User_Position' , function($join) {
            $join->on('User.id', '=', 'User_Position.id');
        })
        ->where('User.id', $id)
        ->get();

        $usersArr = array();

        foreach($users as $key => $user)
        {
            $unitsArr = array();
            $positions = Position::where('id', $user->id)->get();

            foreach ($positions as $key => $pos) {

                // $areaName = ListMenu::where('group_id', 'pos_area')
                //                     ->where('item_value', $pos->area)->first()->item_name;
                // $unitName = ListMenu::where('group_id', 'pos_unit')
                //                     ->where('item_value', $pos->unit)->first()->item_name;

                $unitTmp = [
                    'unit' => $pos->unit,
                    'area' => $pos->area,
                ];
                $unitTmpJson = $unitTmp;
                array_push($unitsArr, $unitTmpJson);
            }
        }

        $isEnabled = true;
        if($user->isEnable == 'Y')
        {
            $isEnabled = true;
        }
        else
        {
            $isEnabled = false;
        }

        try
        {
            return json_encode([
                'email' => $user->id,
                'name' => $user->name,
                'isEnable' => $isEnabled,
                'units' => $unitsArr
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }
    }

    #Mysql Call Proc User_Select_Proc One person
    public function UserDeleteOneProc(Request $req)
    {
        $id = $req->email;
        $user = DB::table('User')->where('id', $id)->first();
        $user->isEnable = 'N'; 
        $user->save();

        try
        {
            return json_encode(200);
        } catch (\Throwable $th) {
            return response(json_encode($th), 404)->header('Content-Type', 'application/json');
        }
    }

    #Mysql Call Proc User_Update_Proc
    public function UserUpdateProc(Request $req)
    {
        $user = User::where('id', $req->email)->first();
        //$user->password     = $req->password;
        $user->name         = $req->name;

        $user->isEnable     = 'Y';
        if($req->isEnable == '0')
        {
            $user->isEnable = 'N';
        }
        else
        {
            $user->isEnable = 'Y';
        }

        // $now = new DateTime();
        $user->upd_user     = 'admin@gmail.com';
        // $user->upd_date     = $now->format('Ymd');
        // $user->upd_time     = $now->format('His');
        $user->save();

        $units = $req->units;

        //Kill
        $positions = Position::where('id', $req->email)->delete();
        
        foreach ($units as $unitItem) {
            $position = new Position;
            $position->id       = $req->email;
            $position->unit     = $unitItem['unit'];
            $position->area     = $unitItem['area'];
            $position->upd_user = 'admin@gmail.com';
            // $position->upd_date = $now->format('Ymd');
            // $position->upd_time = $now->format('His');
            $position->save();
        }

        try
        {
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
                'text' => $list->item_name,
                'value' => $list->item_value
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
