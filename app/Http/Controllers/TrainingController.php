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
     * 
     * @return Illuminate\View\View
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
     * display test
     * 
     * @return Illuminate\View\View
     */
    public function test(Request $request)
    {
        // initiate used variables
        $result = '';
        $passedPrediction = $failedPrediction = 0;
        $resultDict = [
            0 => 'undefined',
            1 => 'RENDAH',
            2 => 'SEDANG',
            3 => 'TINGGI'
        ];

        $classDict = [
            0 => 'TIDAK LULUS',
            1 => 'LULUS'
        ];

        if ($request->has(['name', 'twk', 'tiu', 'tkp', 'tpa', 'tbi', 'gender', 'origin', 'actual'])) {
            $resultArray = $this->resultArray();
            $results = Result::all();
            
            $passedPrediction = $this->result($results, 'twk')[$resultArray[$request->twk]] *
                                $this->result($results, 'tiu')[$resultArray[$request->tiu]] *
                                $this->result($results, 'tkp')[$resultArray[$request->tkp]] *
                                $this->result($results, 'tpa')[$resultArray[$request->tpa]] *
                                $this->result($results, 'tbi')[$resultArray[$request->tbi]] *
                                $this->participantResultSingle($results, 'gender', $request->gender, 1) *
                                $this->participantResultSingle($results, 'origin', $request->origin, 1) *
                                $this->testResult($results)['passed'];
            
            $passedPrediction = round($passedPrediction * 100, 1);

            $failedPrediction = $this->result($results, 'twk')[$resultArray[$request->twk + 3]] *
                                $this->result($results, 'tiu')[$resultArray[$request->tiu + 3]] *
                                $this->result($results, 'tkp')[$resultArray[$request->tkp + 3]] *
                                $this->result($results, 'tpa')[$resultArray[$request->tpa + 3]] *
                                $this->result($results, 'tbi')[$resultArray[$request->tbi + 3]] *
                                $this->participantResultSingle($results, 'gender', $request->gender, 0) *
                                $this->participantResultSingle($results, 'origin', $request->origin, 0) *
                                $this->testResult($results)['failed'];

            $failedPrediction = round($failedPrediction  * 100, 1);

            if ($passedPrediction > $failedPrediction) {
                $result = 'LULUS';
            } else {
                $result = 'TIDAK LULUS';
            }

        } else {
            $result = '';
        }

        return view('training.test')
            ->with(compact(['result', 'passedPrediction', 'failedPrediction', 'resultDict', 'classDict']));
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

    /**
     * result array
     * 
     * @return array
     */
    protected function resultArray()
    {
        return [
            1 => 'low_passed',
            2 => 'mid_passed',
            3 => 'high_passed',
            4 => 'low_failed',
            5 => 'mid_failed',
            6 => 'high_failed'
        ];
    }

    /**
     * participant result for single data
     * 
     * @param App\Result $results
     * @param string $filter
     * @param string $value
     * @param integer $result
     * 
     * @return double 
     */
    protected function participantResultSingle($results, $filter, $value, $result)
    {
        return Participant::where($filter, $value)->whereHas('result', function ($query) use ($result) {
            $query->where('result', $result);
        })->count() / $results->where('result', 1)->count(); 
    }
}
