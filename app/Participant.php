<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'name'
    ];

    public function results()
    {
        return $this->hasMany('App\Result');
    }
}
