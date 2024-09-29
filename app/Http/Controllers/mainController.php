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
            SELECT sector, count(topic) AS topic_count,
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

$results = DB::select("select distinct pestle,count(*) from topics	group by pestle");

return $results;



    }
    function pie_graph(){
        

        $results = DB::select("select  distinct swot,count(*) AS category_count from topics group by swot;");
        
        return $results;

    }

    function stacked_graph(){

        $results = DB::select("SELECT sector, 
       round(AVG(impact)) AS avg_impact, 
       round(AVG(likelihood)) AS avg_intensity,
       COUNT(*) AS topic_count
FROM public.topics where length(sector)>0 and impact is not null
GROUP BY sector
ORDER BY avg_impact  desc limit 5");
            
            return $results;
    }

    function fetch_end_year(){

        $results = DB::select("SELECT distinct end_year FROM public.topics order by end_year");
            
            return $results;

    }

    function fetch_region(){

        $results = DB::select("select distinct region from topics where length(region)>0 order by region");
            
            return $results;

    }

    function get_intensity(){


        $results = DB::select("select  MIN(distinct(intensity)),MAX(distinct(intensity)) from topics");
            
            return $results;
        
    }

    function bar_stacked_chart(){

        $results = DB::select("WITH ranked_sectors AS (
select sector,sum(impact2) as impact2,sum(impact3) as impact3,sum(impact4) as impact4,
                       ROW_NUMBER() OVER (ORDER BY sum(impact2+impact3+impact4) DESC) AS rank from (
select sector,count(impact) as impact2,0 as impact3,0 as impact4 from topics where length(sector)>0 and impact='2' group by sector
union all
select sector,0 as impact2,count(impact) as impact3,0 as impact4 from topics where length(sector)>0 and impact='3' group by sector
union all
select sector,0 as impact2,0 as impact3,count(impact) as impact4 from topics where length(sector)>0 and impact='4' group by sector	
) as c  group by sector  order by sum(impact2+impact3+impact4) desc

    )
              SELECT sector,impact2,impact3,impact4 
              FROM ranked_sectors
              WHERE rank <= 5");

        return $results;

    }
    function show_dashboard(){

        $results=$this->bar_graph();


        $result_line=$this->line_graph();

        $result_pie=$this->pie_graph();

        $result_stacked=$this->stacked_graph();

        $end_year_filter=$this->fetch_end_year();

        $region_arr=$this->fetch_region();

        
        $intensity=$this->get_intensity();

        $bar_stacked_chart=$this->bar_stacked_chart();
        
        $low = [];
        $medium = [];
        $high = [];
        $sector_bar_stacked = [];
       

        foreach ($bar_stacked_chart as $bar_stacked_chart) {
            $sector_bar_stacked[] = $bar_stacked_chart->sector;
            $low[] = $bar_stacked_chart->impact2;
            $medium[] = $bar_stacked_chart->impact3;
            $high[] = $bar_stacked_chart->impact4;
           
        }
        



        $min_intensity = [];
        $max_intensity = [];
       

        foreach ($intensity as $intensity) {
            $min_intensity[] = $intensity->min;
            $max_intensity[] = $intensity->max;
           
        }

    

        $region = [];
       

        foreach ($region_arr as $region_arrs) {
            $region[] = $region_arrs->region;
           
        }
        
        
        $end_year_arr = [];
       

        foreach ($end_year_filter as $end_year_filters) {
            $end_year_arr[] = $end_year_filters->end_year;
           
        }
        //return $end_year_arr; 
        
        $label = [];
        $label_data = [];

        foreach ($results as $result) {
            $label[] = $result->sector;
            $label_data[] = $result->topic_count;
        }


        $label_stacked = [];
        $label_data_stacked_impact = [];
        $label_data_stacked_intensity = [];
        $label_data_stacked_topic_count = [];

        

        foreach ($result_stacked as $result_stackeds) {
            $label_stacked[] = $result_stackeds->sector;
            $label_data_stacked_impact[] = $result_stackeds->avg_impact;
            $label_data_stacked_intensity[] = $result_stackeds->avg_intensity;
            $label_data_stacked_topic_count[] = $result_stackeds->topic_count;
            
        }

        //return $label_data_stacked_intensity;exit;
        $label_line = [];
        $label_data_line = [];

        foreach ($result_line as $result_lines) {
            
            if($result_lines->pestle=='')
            {

            }
            else{
                $label_line[] = $result_lines->pestle;
                $label_data_line[] = $result_lines->count;
            }
            
        }

        foreach ($result_line as $result_lines) {
            
            if($result_lines->pestle=='')
            {
                $label_line[] = 'No Data';
                $label_data_line[] = $result_lines->count;
            }
            
        }


        $label_pie = [];
        $label_data_pie = [];

        foreach ($result_pie as $result_pies) {

            if($result_pies->swot=='')
            {
                $label_pie[] = 'No Data';
            }else{

            }
            $label_pie[] = $result_pies->swot;
            $label_data_pie[] = $result_pies->category_count;
        }

        //return $label_pie;exit;



        return view('welcome', compact('label','label_data','label_line','label_data_line','label_pie', 'label_data_pie','label_stacked','label_data_stacked_impact','label_data_stacked_intensity',
    'label_data_stacked_topic_count','end_year_arr','region','min_intensity','max_intensity','sector_bar_stacked','low','medium','high'));

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
