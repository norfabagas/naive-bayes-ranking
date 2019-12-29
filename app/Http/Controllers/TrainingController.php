<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participant;
use App\Result;

class TrainingController extends Controller
{
    /**
     * display all participants
     * 
     * @return Illuminate\View\View
     */
    public function index()
    {
        $participants = Participant::paginate(10);
        return view('training.index')
            ->with(compact(['participants']));
    }

    /**
     * display all statistics and probabilities
     */
    public function statistic()
    {
        $results = Result::all();

        $testResult = $this->testResult($results);

        $twkResult = $this->result($results, 'twk');
        $tiuResult = $this->result($results, 'tiu');
        $tkpResult = $this->result($results, 'tkp');
        $tpaResult = $this->result($results, 'tpa');
        $tbiResult = $this->result($results, 'tbi');

        $gender = $this->participantResult($results, 'gender', ['LAKI', 'PEREMPUAN']);
        $origin = $this->participantResult($results, 'origin', ['JABODETABEK', 'LUAR']);
        
        return view('training.statistic')
            ->with(compact(['testResult', 'twkResult', 'tiuResult', 'tkpResult', 'tpaResult', 'tbiResult', 'gender', 'origin']));
    }

    /**
     * summarize passed and failed value
     * 
     * @param App\Result $results
     * 
     * @return array $testResult
     */
    protected function testResult($results)
    {
        $testResult = [
            'passed' => $results->where('result', 1)->count() / $results->count(),
            'failed' => $results->where('result', 0)->count() / $results->count()
        ];

        return $testResult;
    }

    /**
     * summarize test result
     * 
     * @param App\Result $results
     * @param string $testType
     * 
     * @return array $result
     */
    protected function result($results, $testType)
    {
        $result = [
            'low_passed' => $results->where('result', 1)->where($testType, 1)->count() / $results->where('result', 1)->count(),
            'mid_passed' => $results->where('result', 1)->where($testType, 2)->count() / $results->where('result', 1)->count(),
            'high_passed' => $results->where('result', 1)->where($testType, 3)->count() / $results->where('result', 1)->count(),
            'low_failed' => $results->where('result', 0)->where($testType, 1)->count() / $results->where('result', 0)->count(),
            'mid_failed' => $results->where('result', 0)->where($testType, 2)->count() / $results->where('result', 0)->count(),
            'high_failed' => $results->where('result', 0)->where($testType, 3)->count() / $results->where('result', 0)->count(),
        ];

        return $result;
    }

    /**
     * summarize participant gender
     * 
     * @param App\Result $results
     * @param string $filter
     * @param array $value
     * 
     * @return array $gender
     */
    protected function participantResult($results, $filter, $value)
    {
        $gender = [
            'first_passed' => Participant::where($filter, $value[0])->whereHas('result', function ($query) { $query->where('result', 1); })->count() / $results->where('result', 1)->count(),
            'first_failed' => Participant::where($filter, $value[0])->whereHas('result', function ($query) { $query->where('result', 0); })->count() / $results->where('result', 0)->count(),
            'second_passed' => Participant::where($filter, $value[1])->whereHas('result', function ($query) { $query->where('result', 1); })->count() / $results->where('result', 1)->count(),
            'second_failed' => Participant::where($filter, $value[1])->whereHas('result', function ($query) { $query->where('result', 0); })->count() / $results->where('result', 0)->count(),
        ];

        return $gender;
    }
}
