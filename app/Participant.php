<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'origin'
    ];

    public function result()
    {
        return $this->hasOne('App\Result');
    }
}
