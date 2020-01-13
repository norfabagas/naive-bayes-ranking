<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participant;
use App\Result;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    /**
     * display all participants
     * 
     * @return Illuminate\View\View
     */
    public function index()
    {
        if (auth()->user()->role == 'teacher') {
            return redirect()->route('training.test');
        }

        $participants = Participant::paginate(10);
        return view('training.index')
            ->with(compact(['participants']));
    }

    /***
     * handle excel submit
     * 
     * @return void
     */
    public function submitExcel(Request $request)
    {
        if (auth()->user()->role == 'teacher') {
            return redirect()->route('training.test');
        }

        $validator = Validator::make($request->all(), [
            'excel' => 'required|file|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $csv = readCSV($request->file('excel')->getRealPath());
    
            DB::beginTransaction();

            Participant::query()->delete();            

            foreach ($csv as $line) {
                if ($line == false) {
                    continue;
                }

                $participant = Participant::create([
                    'name' => $line[0]
                ]);
    
                Result::create([
                    'participant_id' => $participant->id,
                    'twk' => resultDictionary($line[1]),
                    'tiu' => resultDictionary($line[2]),
                    'tkp' => resultDictionary($line[3]),
                    'tpa' => resultDictionary($line[4]),
                    'tbi' => resultDictionary($line[5]),
                    'result' => testResult($line[6])
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            abort(403, $e->getMessage());
        }

        Session::flash('message', 'Data stored');

        return redirect()
            ->route('training.index');
    }

    /**
     * display all statistics and probabilities
     * 
     * @return Illuminate\View\View
     */
    public function statistic()
    {
        if (auth()->user()->role == 'teacher') {
            return redirect()->route('training.test');
        }

        $results = Result::all();

        $testResult = $this->testResult($results);

        $twkResult = $this->result($results, 'twk');
        $tiuResult = $this->result($results, 'tiu');
        $tkpResult = $this->result($results, 'tkp');
        $tpaResult = $this->result($results, 'tpa');
        $tbiResult = $this->result($results, 'tbi');
        
        return view('training.statistic')
            ->with(compact(['testResult', 'twkResult', 'tiuResult', 'tkpResult', 'tpaResult', 'tbiResult']));
    }

    /**
     * display detailed statistic based on test type
     * 
     * @param string $test
     * 
     * @return Illuminate\View\View
     */
    public function statisticDetail($test)
    {
        if (!in_array($test, availableTest())) {
            return redirect()
                ->route('training.statistic');
        }

        $results = Result::all();

        $detailedResults = $this->getDetailedResults($results, $test);

        return view('training.statistic_detail')
            ->with(compact(['test', 'detailedResults']));
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

        if ($request->has(['name', 'twk', 'tiu', 'tkp', 'tpa', 'tbi'])) {
            $resultArray = $this->resultArray();
            $results = Result::all();
            
            $passedPrediction = $this->result($results, 'twk')[$resultArray[$request->twk]] *
                                $this->result($results, 'tiu')[$resultArray[$request->tiu]] *
                                $this->result($results, 'tkp')[$resultArray[$request->tkp]] *
                                $this->result($results, 'tpa')[$resultArray[$request->tpa]] *
                                $this->result($results, 'tbi')[$resultArray[$request->tbi]] *
                                $this->testResult($results)['passed'];
            
            $passedPrediction = round($passedPrediction * 100, 1);

            $failedPrediction = $this->result($results, 'twk')[$resultArray[$request->twk + 3]] *
                                $this->result($results, 'tiu')[$resultArray[$request->tiu + 3]] *
                                $this->result($results, 'tkp')[$resultArray[$request->tkp + 3]] *
                                $this->result($results, 'tpa')[$resultArray[$request->tpa + 3]] *
                                $this->result($results, 'tbi')[$resultArray[$request->tbi + 3]] *
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
        return Participant::where($filter, $value)->whereHas('results', function ($query) use ($result) {
            $query->where('result', $result);
        })->count() / $results->where('result', 1)->count(); 
    }

    /**
     * get detailed results 
     * 
     * @param App\Result $results
     * @param string $test
     * 
     * @return array $results
     */
    protected function getDetailedResults($results, $test)
    {
        $detailedResults = [];

        $detailedResults['low_failed'] = $this->getNameFromResults($test, 1, 0);
        $detailedResults['low_failed_count'] = $this->getNameFromResults($test, 1, 0, 'count');
        $detailedResults['low_passed'] = $this->getNameFromResults($test, 1, 1);
        $detailedResults['low_passed_count'] = $this->getNameFromResults($test, 1, 1, 'count');
        
        $detailedResults['mid_failed'] = $this->getNameFromResults($test, 2, 0);
        $detailedResults['mid_failed_count'] = $this->getNameFromResults($test, 2, 0, 'count');
        $detailedResults['mid_passed'] = $this->getNameFromResults($test, 2, 1);
        $detailedResults['mid_passed_count'] = $this->getNameFromResults($test, 2, 1, 'count');
        
        $detailedResults['high_failed'] = $this->getNameFromResults($test, 3, 0);
        $detailedResults['high_failed_count'] = $this->getNameFromResults($test, 3, 0, 'count');
        $detailedResults['high_passed'] = $this->getNameFromResults($test, 3, 1);
        $detailedResults['high_passed_count'] = $this->getNameFromResults($test, 3, 1, 'count');

        $detailedResults['low_count'] = ($detailedResults['low_failed_count'] > $detailedResults['low_passed_count']) ? $detailedResults['low_failed_count'] : $detailedResults['low_passed_count'];
        $detailedResults['mid_count'] = ($detailedResults['mid_failed_count'] > $detailedResults['mid_passed_count']) ? $detailedResults['mid_failed_count'] : $detailedResults['mid_passed_count'];
        $detailedResults['high_count'] = ($detailedResults['high_failed_count'] > $detailedResults['high_passed_count']) ? $detailedResults['high_failed_count'] : $detailedResults['high_passed_count'];

        // dd($detailedResults);
        

        return $detailedResults;
    }

    /**
     * helper for getDetailedResults method
     * 
     * @param string $test
     * @param integer $testResult
     * @param integer $result
     * @param string $type (count, get)
     * 
     * @return array $names
     */
    protected function getNameFromResults($test, $testResult, $result, $type = 'get')
    {
        $names = DB::table('results')
            ->join('participants', 'results.participant_id', '=', 'participants.id')
            ->select('participants.name AS name')
            ->where($test, $testResult)
            ->where('result', $result);
        
        if ($type == 'get') {
            return $names
                ->get()
                ->toArray();
        } else if ($type == 'count') {
            return $names
                ->count();
        } else {
            return [];
        }
    }
}
