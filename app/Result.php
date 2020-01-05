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
        'tbi',
        'result'
    ];

    /**
     * return has one App\Participant
     */
    public function participant()
    {
        return $this->belongsTo('App\Participant');
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
     * return human readable test result
     */
    public function getTestResultAttribute()
    {
        return $this->testResult($this->result);
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

    /**
     * convert test result value to human readable string
     * 
     * @param integer $result
     */
    protected function testResult($result)
    {
        if ($result > 0) {
            return 'LULUS';
        } else {
            return 'TIDAK LULUS';
        }
    }
}
