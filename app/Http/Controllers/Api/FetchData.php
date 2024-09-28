<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FetchData extends Controller
{

    function get_data_line(Request $request){

        return $this->data_linechart($request->listval_mychart, $request->end_year ? $request->end_year : '#'
        , $request->impact ? $request->impact : '#');

    }

    function data_linechart($default_cond,$end_year,$impact) {

        $yearsArray = explode(',', $end_year);

        $cond='';
        if($end_year!='#'){
            $cond = ' and end_year IN (' . implode(',', $yearsArray) . ') ';
        }  

        if($impact!='#'){
            $cond = $cond.' and impact='.$impact;
        }  
        
                $result_line = DB::select("SELECT 
            start_year, 
            round(AVG(intensity)) AS avg_intensity
        FROM 
            public.topics
        WHERE 
            start_year IS NOT NULL
            AND start_year % ".$default_cond." = 0 ".$cond." 
        GROUP BY 
            start_year
        ORDER BY 
            start_year ASC;
        ");

        $label_line = [];
        $label_data_line = [];

        foreach ($result_line as $result_lines) {
            $label_line[] = $result_lines->start_year;
            $label_data_line[] = $result_lines->avg_intensity;
        }
        return json_encode([
            'label'=>$label_line,
            'label_data'=>$label_data_line
        ]);



    }


    function get_data(Request $request){

        
            return $this->data_barchart($request->listval_mychart, $request->end_year ? $request->end_year : '#'
            , $request->impact ? $request->impact : '#');
                

    }

    function data_barchart($default_list,$end_year,$impact) {

       // return json_encode($end_year);

       //$years = '2018,2019';
         $yearsArray = explode(',', $end_year);

        $cond='';
        if($end_year!='#'){
            $cond = ' and end_year IN (' . implode(',', $yearsArray) . ') ';
        }  
        
        if($impact!='#'){
            if($impact>2){
                $cond = $cond.' and impact='.$impact;
            }
            else{
                $cond = $cond.' and  (impact=2 or impact is null)';
                
            }
            
        }  
        
        if($default_list=="0"){
    
            
            $results = DB::select("WITH ranked_sectors AS (
                SELECT sector, count(topic) AS topic_count,
                       ROW_NUMBER() OVER (ORDER BY count(distinct(topic)) DESC) AS rank
                FROM topics
                WHERE length(sector) > 0 ".$cond."
                GROUP BY sector
              )
              SELECT sector, topic_count
              FROM ranked_sectors order by topic_count desc");
    
        }else{
    
    
            $results = DB::select("WITH ranked_sectors AS (
                SELECT sector, count(topic) AS topic_count,
                       ROW_NUMBER() OVER (ORDER BY count(distinct(topic)) DESC) AS rank
                FROM topics
                WHERE length(sector) > 0 ".$cond."
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
        }
            $label = [];
            $label_data = [];
    
    foreach ($results as $result) {
        $label[] = $result->sector;
        $label_data[] = $result->topic_count;
    }
    
    return json_encode([
        'label'=>$label,
        'label_data'=>$label_data
    ]);
    
    }
}
