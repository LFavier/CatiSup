<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participant;
use App\Customization;

class FileController extends Controller
{
    
    /**
    * The name of the columns of the Customization table
    * 
    * @var array of string - the header for the file import
    */
    const IMPORT_HEADER = ["survey_id","id_importe","firstname","lastname",
        "gender","birthdate","mail","phone1","phone2","field1","field2",
        "field3","field4","field5","field6","field7","field8","field9"];


    /**
    * Import participants from a PSV/CSV file to the database
    * 
    * @param request - the current request
    * @param survey_id - the current request id
    * 
    * @return boolean - the result of the import
    */
    public static function importFromFile(Request $request, int $survey_id){
        $result = false;
        if($request->file('participants')){
            $file = $request->file('participants');
            $importArray = FileController::psvToArray($file->getRealPath(), $survey_id);
            if($importArray){
                $result = Participant::importParticipants($importArray); 
            }
        }
        return $result;
    }

    
    /**
    * Convert a PSV or CSV file into an array for storage in the DB
    * Calls importAttributes - adds the additional attributes to the DB if they don't exist
    * 
    * @param string - the path of the file to convert
    * @param survey_id - the current request id
    * 
    * @return array - the array of entries
    */
    private static function psvToArray(string $filepath, int $survey_id){
        if (!file_exists($filepath) || !is_readable($filepath)){
            return false;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filepath, 'r')) !== false)
        {
            //If no pipe is found in the file, consider it is a CSV and use coma as a delimiter
            $line = fgets($handle);
            $delimiter = (strpos($line, '|') === false) ? ',' : '|';
            rewind($handle);

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            { 
                if (!$header){
                    //Check the header format
                    if(!FileController::validFormat($row))
                    {
                        return $data; //return the empty array if format is wrong
                    }
                    //Import the additionnal attributes
                    FileController::importAttributes($row, $survey_id);
                    $header = FileController::IMPORT_HEADER;
                }
                else
                {
                    $entry = FileController::characterEncode($row);
                    //add the survey id to the data (as a string)
                    array_unshift($entry, $survey_id);
                    $data[] = array_combine($header, $entry);
                }
            }
            fclose($handle);
        }
        return $data;
    }


    /**
    * Check the format of the imported file's header
    * 
    * Used in psvToArray
    * 
    * @param array of string - the file's header
    * 
    * @return boolean - the validity of the format
    */
    private static function validFormat(array $header){
        $format = explode(',', env('IMPORT_FILE_FORMAT'));
        for ($i=0;$i<count($format);$i++)
        {
            if(strtolower($header[$i]) !== strtolower($format[$i]))
            {
                return false;
            }
        }
        return true;
    }
    
    
    /**
    * Change the character encoding to the ENV "IMPORT_CHARSET" variable
    *
    * Used in psvToArray
    * 
    * @param array of strings - the array of strings to encode
    * 
    * @return array of strings - the encoded array of strings
    */
    private static function characterEncode(array $entry){
        $encoding = mb_detect_encoding($entry[0]);
        for ($i=0;$i<count($entry);$i++)
        {
            $entry[$i] = mb_convert_encoding($entry[$i], env('IMPORT_CHARSET'), $encoding);
            $entry[$i] = iconv($encoding, env('IMPORT_CHARSET').'//IGNORE', $entry[$i]);
        }
        return $entry;
    }

    
    /**
    * Import the additional attributes to the Customization table in the DB if
    * they don't exist
    * 
    * Used in psvToArray
    * 
    * @param array of strings - the array of strings to encode
    * @param survey_id - the current request id
    * 
    * @return boolean - the result
    */
    private static function importAttributes(array $header, int $survey_id){
        if(!$header){
            return false;
        }
        //The position of the attributes in the array
        $offset = count(explode(',', env('IMPORT_FILE_FORMAT')));
        
        $attributes = array_slice($header, $offset);

        Customization::importCustomization($attributes, $survey_id);
        
        return true;
    }
}