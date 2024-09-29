<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FetchData extends Controller
{

    function  filter_single_data_bar(Request $request){

        $cond=" where 1=1 and sector='".$request->label."'";

        $result=DB::select("select '".$request->label."' as sector,sum(distinct_topic) as distinct_topic,sum(distinct_swot) as distinct_swot,sum(distinct_pestle ) as distinct_pestle,
	sum(max_intensity) as max_intensity ,sum(distinct_regions) as distinct_regions from(       
	select count(distinct(topic)) as distinct_topic,0 as distinct_swot, 0 as distinct_pestle,0 as max_intensity,0  as distinct_regions from topics ".$cond."    
	union 
	select 0 as distinct_topic,count(distinct(swot)) as distinct_swot,0 as distinct_pestle,0 as max_intensity,0  as distinct_regions from topics ".$cond." 
        union 
	select 0 as distinct_topic,0 as distinct_swot,count(distinct(pestle)) as distinct_pestle,0 as max_intensity,0  as distinct_regions from topics ".$cond." 
        union 
	select 0 as distinct_topic,0 as distinct_swot,0  as distinct_pestle,max(intensity) as max_intensity ,0  as distinct_regions from topics ".$cond." 
        union 
	select 0 as distinct_topic,0 as distinct_swot,0  as distinct_pestle,0 as  max_intensity,count(distinct(region)) as distinct_regions from topics ".$cond." and  length(region)>0  
)");

return json_encode($result);
    }

    function filter_data_radar(Request $request){
        return $this->data_radar($request->end_year ? $request->end_year : '#'
        ,$request->region ? $request->region : '#'
        , $request->relevance ? $request->relevance : '#'
        ,$request->min_intensity ? $request->min_intensity : '#'
        ,$request->max_intensity ? $request->max_intensity : '#'
    );

    }
    function data_radar($end_year,$region,$relevance,$min_intensity,$max_intensity){

        $cond=$this->get_cond($end_year,$region,$relevance,$min_intensity,$max_intensity);

   
        //return $cond;

        $result_stacked = DB::select("SELECT sector, 
       round(AVG(impact)) AS avg_impact, 
       round(AVG(likelihood)) AS avg_intensity,
       COUNT(*) AS topic_count
FROM public.topics where length(sector)>0 and impact is not null ".$cond."
GROUP BY sector
ORDER BY avg_impact  desc limit 5");
            
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

return json_encode([
    'label_stacked'=>$label_stacked,
    'label_data_stacked_impact'=>$label_data_stacked_impact,
    'label_data_stacked_intensity'=>$label_data_stacked_intensity,
    'label_data_stacked_topic_count'=>$label_data_stacked_topic_count,
]);


    }

    function filter_data_bar_stacked(Request $request){

        
        return $this->data_barstacked($request->end_year ? $request->end_year : '#'
        ,$request->region ? $request->region : '#'
        , $request->relevance ? $request->relevance : '#'
        ,$request->min_intensity ? $request->min_intensity : '#'
        ,$request->max_intensity ? $request->max_intensity : '#'
    );

    }

    function get_cond($end_year,$region,$relevance,$min_intensity,$max_intensity){
        

        $yearsArray = explode(',', $end_year);

        $cond='';
        if($end_year!='#'){
            $cond = ' and end_year IN (' . implode(',', $yearsArray) . ') ';
        }
        
        $regionArray = explode(',', $region);

        if ($region != '#') {
            // Add single quotes around each region element
            $regionArray = array_map(function($region) {
                return "'" . trim($region) . "'";
            }, $regionArray);

            if (in_array("'World'", $regionArray)) {
                // Add the condition for region='' if "world" is present
                $regionArray[] = "''";  // Add empty string condition
            }
            
            // Now implode the array with commas
            $cond = $cond.' and region IN (' . implode(',', $regionArray) . ') ';
        }

        
        $cond=$cond.' and intensity between '.$min_intensity.' and '.$max_intensity;

        //return $cond;
     

        if($relevance!='#'){
            if($relevance>2){
                $cond = $cond.' and relevance='.$relevance;
            }
            
            
        }

        return $cond;

    }
    function data_barstacked($end_year,$region,$relevance,$min_intensity,$max_intensity){
  
        //return "jhjs";
        $cond=$this->get_cond($end_year,$region,$relevance,$min_intensity,$max_intensity);

        $bar_stacked_chart = DB::select("WITH ranked_sectors AS (
            select sector,sum(impact2) as impact2,sum(impact3) as impact3,sum(impact4) as impact4,
                                   ROW_NUMBER() OVER (ORDER BY sum(impact2+impact3+impact4) DESC) AS rank from (
            select sector,count(impact) as impact2,0 as impact3,0 as impact4 from topics where length(sector)>0 and impact='2' ".$cond." group by sector
            union all
            select sector,0 as impact2,count(impact) as impact3,0 as impact4 from topics where length(sector)>0 and impact='3' ".$cond." group by sector
            union all
            select sector,0 as impact2,0 as impact3,count(impact) as impact4 from topics where length(sector)>0 and impact='4' ".$cond." group by sector	
            ) as c  group by sector  order by sum(impact2+impact3+impact4) desc
            
                )
                          SELECT sector,impact2,impact3,impact4 
                          FROM ranked_sectors
                          WHERE rank <= 5");

                          
        
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

                          return json_encode([
                            'sector_bar_stacked'=>$sector_bar_stacked,
                            'low'=>$low,
                            'medium'=>$medium,
                            'high'=>$high,
                        ]);
                          
    }

    function filter_data_pie(Request $request){

        return $this->data_piechart($request->end_year ? $request->end_year : '#'
        ,$request->region ? $request->region : '#'
        , $request->relevance ? $request->relevance : '#'
        ,$request->min_intensity ? $request->min_intensity : '#'
        ,$request->max_intensity ? $request->max_intensity : '#'
    );

    }

    function data_piechart($end_year,$region,$relevance,$min_intensity,$max_intensity){

        $cond=$this->get_cond($end_year,$region,$relevance,$min_intensity,$max_intensity);



        $result_pie = DB::select("select  distinct swot,count(*) AS category_count from topics where 1=1 ".$cond." group by swot;");
       // return $result_pie;   


        $label_pie = [];
        $label_data_pie = [];

        foreach ($result_pie as $result_pies) {

            if($result_pies->swot=='')
            {
                $label_pie[] = 'No Data';
            }else{

                $label_pie[] = $result_pies->swot;
            }
            
            $label_data_pie[] = $result_pies->category_count;
        }

        return json_encode([
            'label'=>$label_pie,
            'label_data'=>$label_data_pie
        ]);


    }
    function get_data_line(Request $request){

        return $this->data_linechart($request->end_year ? $request->end_year : '#'
        ,$request->region ? $request->region : '#'
        , $request->relevance ? $request->relevance : '#'
        ,$request->min_intensity ? $request->min_intensity : '#'
        ,$request->max_intensity ? $request->max_intensity : '#'
    );

        
    }

    function data_linechart($end_year,$region,$relevance,$min_intensity,$max_intensity) {

        $cond=$this->get_cond($end_year,$region,$relevance,$min_intensity,$max_intensity);


    //return $cond;    
        
                $result_line = DB::select("select distinct pestle,count(*) from topics where 1=1 ".$cond."	group by pestle");

                
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


        return json_encode([
            'label'=>$label_line,
            'label_data'=>$label_data_line
        ]);



    }


    function get_data(Request $request){
 
        
        
            return $this->data_barchart($request->listval_mychart, $request->end_year ? $request->end_year : '#'
            , $request->impact ? $request->impact : '#'
            , $request->region ? $request->region : '#'
            , $request->relevance ? $request->relevance : '#'
            ,$request->min_intensity ? $request->min_intensity : '#'
            ,$request->max_intensity ? $request->max_intensity : '#'
        );
                
            
    }

    function data_barchart($default_list,$end_year,$impact,$region,$relevance,$min_intensity,$max_intensity) {

       // return json_encode($end_year);

       //$years = '2018,2019';

       $cond=$this->get_cond($end_year,$region,$relevance,$min_intensity,$max_intensity);

         
        if($impact!='#'){
            if($impact>2){
                $cond = $cond.' and impact='.$impact;
            }
            else{
                $cond = $cond.' and  (impact=2 or impact is null)';
                
            }
            
        } 

               //return json_encode($relevance);

        
        
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
