<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ArtistGroup extends Model
{
    protected $table = 'tbl_artist_group';

    public function artist()
    {
        return $this->hasMany('App\Models\Artist');
    }

    public function group(){
        return $this->hasMany('App\Models\Group');
    }

}
