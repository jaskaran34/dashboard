<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/get_data_topic', function (Request $request) {

    $default_list=$request->listval;
    $label=$request->label;

});
Route::get('/get_data', function (Request $request) {

    

    $default_list=$request->listval;
    
    if($default_list=="0"){

        $results = DB::select("WITH ranked_sectors AS (
            SELECT sector, count(distinct(topic)) AS topic_count,
                   ROW_NUMBER() OVER (ORDER BY count(distinct(topic)) DESC) AS rank
            FROM topics
            WHERE length(sector) > 0
            GROUP BY sector
          )
          SELECT sector, topic_count
          FROM ranked_sectors order by topic_count desc");

    }else{


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

});
