<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
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
        'survey_id','id_importe','firstname','lastname','gender','birthdate',
        'mail','phone1','phone2','field1','field2','field3','field4','field5',
        'field6','field7','field8','field9'
    ];
    
    /**
     * Import participants to the DB
     *
     * @param array of string the entries to save
     * 
     * @return boolean - the result of the import
     */
    public static function importParticipants(array $participants)
    {
        if(!$participants){
            return false;
        }
        for ($i = 0; $i < count($participants); $i ++)
        {
            Participant::firstOrCreate($participants[$i]);
        }
        return true;
    }
}