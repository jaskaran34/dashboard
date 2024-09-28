<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FetchData extends Controller
{

    function get_data(Request $request){

        
            return $this->data_barchart($request->listval_mychart, $request->end_year ? $request->end_year : '#');
                

    }
    function data_barchart($default_list,$end_year) {

       // return json_encode($end_year);

       //$years = '2018,2019';
         $yearsArray = explode(',', $end_year);

        $cond='';
        if($end_year!='#'){
            $cond = ' and end_year IN (' . implode(',', $yearsArray) . ') ';
        }     
        
        if($default_list=="0"){
    
            
            $results = DB::select("WITH ranked_sectors AS (
                SELECT sector, count(distinct(topic)) AS topic_count,
                       ROW_NUMBER() OVER (ORDER BY count(distinct(topic)) DESC) AS rank
                FROM topics
                WHERE length(sector) > 0 ".$cond."
                GROUP BY sector
              )
              SELECT sector, topic_count
              FROM ranked_sectors order by topic_count desc");
    
        }else{
    
    
            $results = DB::select("WITH ranked_sectors AS (
                SELECT sector, count(distinct(topic)) AS topic_count,
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
