<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use App\Models\Topic;
class mainController extends Controller
{

    function show_dashboard(){

        return view('welcome');

    }
    function fetch_data() {


        $utf8_fields = [
            'sector', 'topic', 'insight', 'swot', 'url', 
            'region', 'city', 'country', 'pestle', 'source', 'title'
        ];
    
        function setNullIfEmpty(array $data, array $fields) {
            foreach ($fields as $field) {
                if (empty($data[$field])) {
                    $data[$field] = null;
                }
            }
            return $data;
        }
    
        $nullableFields = [
            'citylng', 'citylat', 'intensity', 'impact', 
            'relevance', 'likelihood', 'end_year', 'start_year'
        ];
        
        // Function to validate and clean UTF-8 fields
        function cleanUtf8Field($value) {
            if (!mb_check_encoding($value, 'UTF-8')) {
                // Convert invalid byte sequences to valid UTF-8
                return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
            return $value;
        }
    
    $str_arr=array();
    
        $reader = Reader::createFromPath(public_path('Data.csv'));
    $reader->setHeaderOffset(0);
    $i=0;
    
    
    foreach ($reader->getRecords() as $data) {
    
    
        $data = setNullIfEmpty($data, $nullableFields);    
    
        foreach ($utf8_fields as $field) {
            if (isset($data[$field])) {
                $data[$field] = cleanUtf8Field($data[$field]);
            }
        }
    
        
    
        
    
        //return $data;
        $topic = new Topic();
        try{
        $topic->fill($data)->save();
        }
        catch(Exception $e){
       
           //return $e;
        
           $data_err=[
            
            'insight'=>$data['insight'],
            'url'=>$data['url'],
            'added'=>$data['added'],
        ];
        
    
        
        array_push($str_arr, json_encode($data_err));
    
       
        }
    
        
        
    }
    
        return "done";
    }
}
