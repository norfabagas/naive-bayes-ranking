<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'participant_id',
        'twk',
        'tiu',
        'tkp',
        'tpa',
        'tbi'
    ];

    /**
     * return has one App\Participant
     */
    public function participant()
    {
        return $this->hasOne('App\Participant');
    }

    /**
     * return human readable twk test result
     */
    public function getTwkResultAttribute()
    {
        return $this->resultString($this->twk);
    }

    /**
     * return human readable tiu test result
     */
    public function getTiuResultAttribute()
    {
        return $this->resultString($this->tiu);
    }

    /**
     * return human readable tkp test result
     */
    public function getTkpResultAttribute()
    {
        return $this->resultString($this->tkp);
    }

    /**
     * return human readable tpa test result
     */
    public function getTpaResultAttribute()
    {
        return $this->resultString($this->tpa);
    }

    /**
     * return human readable tbi test result
     */
    public function getTbiResultAttribute()
    {
        return $this->resultString($this->tbi);
    }

    /**
     * convert test value to human readable string
     * 
     * @param integer $value
     */
    protected function resultString($value)
    {
        switch ($value) {
            case 1:
                return 'RENDAH';
            case 2:
                return 'SEDANG';
            case 3:
                return 'TINGGI';
            default:
                return 'undefined';
        }
    }
}
