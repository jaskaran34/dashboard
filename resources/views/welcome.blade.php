<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

       
@vite(['resources/css/app.css'])
<style> 
.dropdown-checkbox {
            position: relative;
            display: inline-block;
        }

        .dropdown-checkbox-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-checkbox-content label {
            display: block;
            padding: 8px 16px;
            cursor: pointer;
        }

        .dropdown-checkbox-content label:hover {
            background-color: #f1f1f1;
        }

        .dropdown-checkbox:hover .dropdown-checkbox-content {
            display: block;
        }
.design{
    margin: 10px auto;
    padding: 10px;
}

</style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">


    <div class="container" style="margin: auto auto;">

    <div class="row design">
            

            <div class="col-5">

            <div class="card">
                <div class="card-header">
                <table style="padding: 10px;">
                    <tr>
                        <td>
                            <label>End Year</label>
                        
                        <div class="dropdown-checkbox">
        <button type="button" onclick="toggleDropdown()" id="toggleDropdown_btn">Select</button>
        <div id="dropdownContent" class="dropdown-checkbox-content" style="display: none;">

        <?php
//$abc=['1','2','3'];

        ?>
@foreach($end_year_arr as $end_year)
<label><input type="checkbox" name="options[]" value="{{ $end_year }}" onclick="handleCheckboxChange(this)"> {{ $end_year }}</label>
@endforeach         
</div>
    </div>
                        </td>
                        <td>

                        </td>
                        <td>
                            <label>region</label>
                        </td>
                        
                        <td>
                            <button class="btn btn-primary" onclick="filter_data();">filter</button>
                        </td>
                    </tr>
                </table>
    
        <div id="selectedOptions" style="margin-top: 20px;"></div>
</div>            
</div>
    </div>
</div>


        <div class="row design">
            

        <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        
                    <label>List: </label>
                    <select id="change1" onchange="call_func()">
                            <option value="5">Top 5 Sectors</option>
                            <option value="10">Top 10 Sectors</option>
                            <option value="20">Top 20 Sectors</option>
                            <option value="0">All</option>
                        </select>
                        <label>Impact</label>
                        <select id="filter_impact" onchange="call_func()">
                            <option value="#">select</option>
                            <option value="4">high</option>
                            <option value="3">medium</option>
                            <option value="2">low</option>
                        </select>
                            



                    </div>
                    <div class="card-body>">
                    <canvas id="myChart" ></canvas>
                    </div>
                </div>
            
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart2" ></canvas>
                    </div>
                </div>
            
            </div>




        </div>
        <div class="row design">

        <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        
                    
                        

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart_stacked" ></canvas>
                    </div>
                </div>
            
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart_pie" ></canvas>
                    </div>
                </div>
            
            </div>

        </div>
    
</div>


        
        
        @vite(['resources/js/app.js'])

        @vite(['resources/js/script1.js'])

            
        
        <script>
    function toggleDropdown() {
        const dropdownContent = document.getElementById('dropdownContent');
        dropdownContent.style.display = dropdownContent.style.display === 'none' ? 'block' : 'none';
    }

    function handleCheckboxChange(checkbox) {
        const selectedOptionsDiv = document.getElementById('selectedOptions');
        let selectedOptions = [];
        const checkboxes = document.querySelectorAll('.dropdown-checkbox-content input[type="checkbox"]');
        
        checkboxes.forEach((cb) => {
            if (cb.checked) {
                selectedOptions.push(cb.value);
            }
        });
       // document.getElementById('selectedOptions').innerHTML=selectedOptions;
        document.getElementById('selectedOptions').value=selectedOptions;

        if(selectedOptions.length>0){
            document.getElementById('toggleDropdown_btn').innerHTML=selectedOptions;
            //alert(document.getElementById('toggleDropdown_btn').innerHTML);
           // =selectedOptions;
        }
        else{
            document.getElementById('toggleDropdown_btn').innerHTML='Select';
        }
        
        //alert(document.getElementById('selectedOptions').value);
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-checkbox button')) {
            const dropdowns = document.getElementsByClassName("dropdown-checkbox-content");
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    }
</script>

        <script>






    window.label= @json($label);
    window.label_data = @json($label_data);
    window.label_line = @json($label_line);
    window.label_data_line = @json($label_data_line);
    window.label_pie = @json($label_pie);
    window.label_data_pie = @json($label_data_pie);

    window.label_stacked = @json($label_stacked);
    window.label_data_stacked_impact = @json($label_data_stacked_impact);
    window.label_data_stacked_intensity = @json($label_data_stacked_intensity);
    window.label_data_stacked_topic_count = @json($label_data_stacked_topic_count);
   
    
</script>


    </body>
</html>
