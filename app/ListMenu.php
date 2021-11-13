<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListMenu extends Model
{
    public $timestamps = false;
    protected $table = 'List';
    protected $guarded = [];
}
