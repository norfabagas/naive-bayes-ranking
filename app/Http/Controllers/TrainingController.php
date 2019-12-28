<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participant;

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
}
