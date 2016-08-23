<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'tbl_group';

    public function artist()
    {
        return $this->hasMany('App\Models\Artist');
    }

}
