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
                <table style="padding: 10px;">
                    <tr>
                        <td>
                        <div class="dropdown-checkbox">
        <button type="button" onclick="toggleDropdown()">Select Options</button>
        <div id="dropdownContent" class="dropdown-checkbox-content" style="display: none;">
            <label><input type="checkbox" name="options[]" value="Option 1" onclick="handleCheckboxChange(this)"> Option 1</label>
            <label><input type="checkbox" name="options[]" value="Option 2" onclick="handleCheckboxChange(this)"> Option 2</label>
            <label><input type="checkbox" name="options[]" value="Option 3" onclick="handleCheckboxChange(this)"> Option 3</label>
        </div>
    </div>
                        </td>
                    </tr>
                </table>
    
    <!--<div id="selectedOptions" style="margin-top: 20px;"></div>-->
            </div>
    </div>
</div>


        <div class="row design">
            

        <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <label>List: </label>
                    <select id="change1" onchange="call_func(this.value)">
                            <option value="5">Top 5 Sectors</option>
                            <option value="10">Top 10 Sectors</option>
                            <option value="20">Top 20 Sectors</option>
                            <option value="0">All</option>
                        </select>
                        

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart" ></canvas>
                    </div>
                </div>
            
            </div>

            <div class="col-5">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart2" ></canvas>
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

        // Display the selected options
        selectedOptionsDiv.innerHTML = 'Selected Options: ' + selectedOptions.join(', ');
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
   
</script>


    </body>
</html>
