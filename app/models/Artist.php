<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'tbl_artist';

    public function artistType()
    {
        return $this->belongsTo('App\Models\ArtistType');
    }

}
