<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
include_once 'helpers.php';
include_once '../vendor/autoload.php';

class Survey extends Model
{
    
    /**
     * Lists the surveys of a user or all surveys if $userName is NULL
     * 
     * @param string the username
     * 
     * @return array containing the surveys
     * array : [sid, surveyls_title, startdate, expires, active]
     * => survey ID, survey title, start date, expiration date, is active
     */
    public static function limeSurveys(string $userName = null)
    {
        $api = connectAPI();
        $result = $api['connection']->list_surveys($api['sessionKey'], $userName);
        disconnectAPI($api);
        return $result;
    }
    
    
    /**
     * Get a specific survey from the LimeSurvey database
     * 
     * @param int the survey id
     * 
     * @return array containing the survey info
     * array : [sid, surveyls_title, startdate, expires, active]
     * => survey ID, survey title, start date, expiration date, is active
     */
    public static function limeSurvey(int $id)
    {
        $surveys = Survey::limeSurveys(NULL);
        
        //Get the (one entry) array containing the key of the survey we are looking for inside the $surveys array
        $key_array = array_keys(array_combine(array_keys($surveys), array_column($surveys, 'sid')),$id);
        //If the $id doesn't appear in the array, throw a "not found" exception
        if(!count($key_array)){
            abort (404, Lang::get('general.wrong_survey_id'));
        }
        
        return $surveys[$key_array[0]];
    }
    
    
    /**
     * Gets the survey's properties
     * 
     * @param int - the survey's ID
     * 
     * @return array containing the survey's properties
     * array[60] : [sid, owner_id, gsid, admin, active, expires, startdate,
     * adminemail, anonymized, faxto, format, savetimings, template,
     * ...] see https://api.limesurvey.org/classes/Survey.html for properties
     * The list is incorrect but it will give you an idea
     */
    public static function limeSurveyProperties(int $id)
    {
        $api = connectAPI();
        $result = $api['connection']->get_survey_properties($api['sessionKey'],$id);
        disconnectAPI($api);
        return $result;
    }
}