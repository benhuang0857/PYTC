<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTmp extends Model
{
    public $timestamps = false;
    protected $table = 'User_Tmp';
    protected $guarded = [];
}
