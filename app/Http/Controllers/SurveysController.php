<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Customization;

class SurveysController extends Controller
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
     * Show the surveys page.
     * 
     * Send all surveys to the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.surveys', ['surveys' => Survey::limeSurveys(NULL)]);
    }
    
    
    /**
     * Show a survey page.
     *
     * Send info to the view : survey info and properties, customization
     *
     * @param int the survey's id
     * 
     * @return \Illuminate\Http\Response
     */
    public function survey(int $survey_id)
    {
        //Get the survey and populate the CatiSup DB if it is only in the LimeSurvey DB
        $survey = Survey::limeSurvey($survey_id);
        //Get the Customization model
        $customization = Customization::find($survey_id);
        
        
        return view('pages.survey',
                ['survey_properties' => Survey::limeSurveyProperties($survey_id),
                    'survey_info' => $survey,
                    'customization' => $customization
                ]);
    }
    
    
    /**
     * Import PSV or CSV file containing participants and customizations
     *
     * @param int the survey's id
     * 
     * @return \Illuminate\Http\Response
     */
    public function import(int $survey_id){
        FileController::importFromFile(request(), $survey_id);
        return back()->with('import_status', __('general.imported'));
    }
    
    
    /**
     * Save the customization changes
     *
     * @param int the survey's id
     * 
     * @return \Illuminate\Http\Response
     */
    public function custom(int $survey_id){
        if(!Customization::find($survey_id)->savePreferences()){
            abort (404, Lang::get('general.wrong_input'));
        }
        return back()->with('custom_status', __('general.customized'));
    }
}