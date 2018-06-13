<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


/**
 * The user (surveyor) controller
 */
class SurveyorsController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the surveyors page.
     * 
     * Send all surveyors (users) to the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.surveyors', ['surveyors' => User::all()]);
    }
    
    /**
     * Delete a surveyor
     * 
     * @param int the id of the surveyor
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(int $id)
    {
        User::destroy($id);
        return redirect()->route('surveyors');
    }
}
