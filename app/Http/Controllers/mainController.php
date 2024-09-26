<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class mainController extends Controller
{

    function bar_graph(){
        $default_list=5;

        $results = DB::select("WITH ranked_sectors AS (
            SELECT sector, count(distinct(topic)) AS topic_count,
                   ROW_NUMBER() OVER (ORDER BY count(distinct(topic)) DESC) AS rank
            FROM topics
            WHERE length(sector) > 0
            GROUP BY sector
          )
          SELECT sector, topic_count
          FROM ranked_sectors
          WHERE rank <= ".$default_list."
          UNION ALL
          SELECT 'Others', SUM(topic_count)
          FROM ranked_sectors
          WHERE rank > ".$default_list.";
        ");

        return $results;

    }

    function line_graph(){

$default_cond="5";

$results = DB::select("SELECT 
    start_year, 
    round(AVG(intensity)) AS avg_intensity
FROM 
    public.topics
WHERE 
    start_year IS NOT NULL
    AND start_year % ".$default_cond." = 0 
GROUP BY 
    start_year
ORDER BY 
    start_year ASC;
");

return $results;



    }
    function show_dashboard(){

        $results=$this->bar_graph();


        $result_line=$this->line_graph();

        $label = [];
        $label_data = [];

        foreach ($results as $result) {
            $label[] = $result->sector;
            $label_data[] = $result->topic_count;
        }

        $label_line = [];
        $label_data_line = [];

        foreach ($result_line as $result_lines) {
            $label_line[] = $result_lines->start_year;
            $label_data_line[] = $result_lines->avg_intensity;
        }



        return view('welcome', compact('label','label_data','label_line','label_data_line'));

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
