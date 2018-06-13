<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    /**
     * The primary key (not standard "id")
     * 
     * @var string
     */
    protected $primaryKey = "survey_id";
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_id','var1','var2','var3','var4','var5','var6','var7','var8',
        'var9','varlabel1','varlabel2','varlabel3','varlabel4','varlabel5',
        'varlabel6','varlabel7','varlabel8','varlabel9','description'
    ];
    
    /**
     * The name of the columns to import from the CSV header
     *
     * @const array
     */
    const IMPORT_FORMAT = [
        'survey_id','varlabel1','varlabel2','varlabel3','varlabel4','varlabel5',
        'varlabel6','varlabel7','varlabel8','varlabel9'
    ];
    
    /**
     * The name of the columns of the additional attributes
     * 
     * @const array
     */
    const ADD_ATTR = [
        'varlabel1','varlabel2','varlabel3','varlabel4','varlabel5',
        'varlabel6','varlabel7','varlabel8','varlabel9'
    ];
    
    /**
     * Import a survey's customization to the DB
     *
     * @param array of string the entry to save
     * 
     * @return boolean - the result of the import
     */
    public static function importCustomization(array $customization, int $survey_id)
    {
        if(!$customization){
            return false;
        }
        array_unshift($customization, $survey_id);
        $entry = array_combine(Customization::IMPORT_FORMAT, $customization);
        
        Customization::firstOrCreate($entry);
        return true;
    }
    
    /**
     * Get an array of the additional attributes
     *
     * @param int - the survey id
     * 
     * @return array
     */
    public function getAddAttrArray()
    {
        $custom = $this->select(Customization::ADD_ATTR)->get();
        $result = array_values($custom->toArray()[0]);
        array_unshift($result, __('general.select_attr'));
        return $result;
    }
    
    
    /**
     * Update the customization preferences of the current survey
     * 
     * @return boolean - the result
     */
    public function savePreferences()
    {
        $result = false;
        $request = request()->toArray();
        $changes = array();
        
        if($request['description'] !== ""){
            $changes['description'] = $request['description'];
        }
        
        $params = array_slice($request, 2);
        foreach(array_keys($params) as $key){
            if($params[$key]!==null && $params[$key]>0){
                $changes[$key] = $params[$key];
            }
        }

        if($changes){
            $this->update($changes);
            $result = true;
        }
        return $result;
    }
}