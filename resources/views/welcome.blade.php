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
    vertical-align: super;
}

.dropdown-checkbox-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 200px;
    max-height: 200px; /* Set maximum height */
    overflow-y: auto;  /* Enable vertical scrolling */
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

.checkbox_text{
    overflow: hidden;
    width: 150px;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-align: left;
}
.lbl{
    
  font-size: 14px;
  font-weight: bold;
  color: #007bff;
  margin-bottom: 5px;
  margin-left: 20px;
  vertical-align: super;

}

.range_container {
  display: flex;
  flex-direction: row;
  margin-left: 20px;
  margin-top: 60px;

}

.sliders_control {
  position: relative;
  min-height: 50px;
}

.form_control {
  position: relative;
  display: flex;
  justify-content: space-between;
  font-size: 24px;
  color: #635a5a;
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 24px;
  height: 24px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #C6C6C6;
  cursor: pointer;
}

input[type=range]::-moz-range-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 24px;
  height: 24px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #C6C6C6;
  cursor: pointer;  
}

input[type=range]::-webkit-slider-thumb:hover {
  background: #f7f7f7;
}

input[type=range]::-webkit-slider-thumb:active {
  box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
  -webkit-box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
}

input[type="number"] {
  color: #8a8383;
  width: 50px;
  height: 30px;
  font-size: 20px;
  border: none;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {  
   opacity: 1;
}

#mySlider{
  -webkit-appearance: none; 
  appearance: none;
  height: 2px;
  background-color: #C6C6C6;
  pointer-events: none;
  vertical-align: super;
  
}

.sli {
  -webkit-appearance: none; 
  appearance: none;
  height: 2px;
  position: absolute;
  background-color: #C6C6C6;
  pointer-events: none;
}

#fromSlider {
  height: 0;
  z-index: 1;
}
</style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">


    <div class="container" style="margin: auto auto;">

    <div class="row design">
            

            <div class="col-12">

            <div class="card">
                <div class="card-header">
                <table style="padding: 10px;">
                    <tr>
                        <td>
                            <label class="lbl">End Year</label>
                        
                            <div class="dropdown-checkbox">
    <button type="button" class="checkbox_text" onclick="toggleDropdown('dropdownContent', 'toggleDropdown_btn')" id="toggleDropdown_btn">Select</button>
    <div id="dropdownContent" class="dropdown-checkbox-content" style="display: none;">
        @foreach($end_year_arr as $end_year)
            <label>
                <input type="checkbox" name="year_options[]" value="{{ $end_year }}" onclick="handleCheckboxChange('dropdownContent', 'selectedOptions', 'toggleDropdown_btn')"> 
                {{ $end_year }}
            </label>
        @endforeach         
    </div>
    <input type="hidden" id="selectedOptions" name="selectedOptions" value="">
</div>
                        </td>
                        
                        <td>
                            <label class="lbl">Region</label>

                            <div class="dropdown-checkbox">
    <button type="button" class="checkbox_text" onclick="toggleDropdown('regionDropdownContent', 'toggleRegionDropdown_btn')" id="toggleRegionDropdown_btn">Select</button>
    <div id="regionDropdownContent" class="dropdown-checkbox-content" style="display: none;">
        @foreach($region as $region)
            <label>
                <input type="checkbox" name="region_options[]" value="{{ $region }}" onclick="handleCheckboxChange('regionDropdownContent', 'selectedRegionOptions', 'toggleRegionDropdown_btn')"> 
                {{ $region }}
            </label>
        @endforeach         
    </div>
    <input type="hidden" id="selectedRegionOptions" name="selectedRegionOptions" value="">
</div>
                        </td>
                        <td>
                            <label class="lbl">Relevance</label>
                        <input type="range" id="mySlider" min="0" max="7" step="1" value="0">
                        <label id="sliderValue">0</label>
                        </td>

                        <td>
                        <label class="lbl">Intensity</label>
                        </td>
                        <td>

                        
                        <div class="range_container">

    <div class="sliders_control">
    
        <input id="fromSlider" class="sli" type="range" value="{{ $min_intensity[0] }}" min="{{ $min_intensity[0] }}" max="{{ $max_intensity[0] }}"/>
        <input id="toSlider" class="sli" type="range" value="{{ $max_intensity[0] }}" min="{{ $min_intensity[0] }}" max="{{ $max_intensity[0] }}"/>
    </div>
    <div class="form_control">
        <div class="form_control_container">
            <div class="form_control_container__time" style="font-size: 15px;
    margin-top: 9px;">Min</div>
            <input class="form_control_container__time__input" type="number" id="fromInput" value="{{ $min_intensity[0] }}" min="{{ $min_intensity[0] }}" max="{{ $max_intensity[0] }}"/>
        </div>
        <div class="form_control_container">
            <div class="form_control_container__time" style="font-size: 15px;
    margin-top: 9px;">Max</div>
            <input class="form_control_container__time__input" type="number" id="toInput" value="{{ $max_intensity[0] }}" min="{{ $min_intensity[0] }}" max="{{ $max_intensity[0] }}"/>
        </div>
    </div>
</div>
                        </td>

                        <td>
                            <button class="btn btn-info " style="margin-left: 50px;color:white;" onclick="filter_data();">Filter</button>
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
    
    

function toggleDropdown(dropdownId) {
    const dropdownContent = document.getElementById(dropdownId);
    dropdownContent.style.display = dropdownContent.style.display === 'none' ? 'block' : 'none';
}


function handleCheckboxChange(dropdownClass, hiddenInputId, buttonId) {
    const selectedOptions = [];
    const checkboxes = document.querySelectorAll(`#${dropdownClass} input[type="checkbox"]:checked`);

    checkboxes.forEach((cb) => {
        selectedOptions.push(cb.value);
    });

    // Update hidden input field with selected values
    document.getElementById(hiddenInputId).value = selectedOptions.join(',');

    // Change the button text based on selected options
    const button = document.getElementById(buttonId);
    if (selectedOptions.length > 0) {
        button.innerHTML = selectedOptions.join(', ');
    } else {
        button.innerHTML = 'Select';
    }
}



window.onclick = function(event) {
    if (!event.target.closest('.dropdown-checkbox')) { 
        const dropdowns = document.getElementsByClassName("dropdown-checkbox-content");
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.style.display === 'block') {
                openDropdown.style.display = 'none';
            }
        }
    }
}



const slider = document.getElementById('mySlider');
const sliderValue = document.getElementById('sliderValue');

const allowedValues = [0, 4, 7, 6, 3, 5];

slider.addEventListener('input', () => {
    const currentValue = slider.value;
    const closestValue = allowedValues.reduce((closest, value) => {
        return Math.abs(value - currentValue) < Math.abs(closest - currentValue) ? value : closest;
    }, 0);

    slider.value = closestValue;
    sliderValue.textContent = closestValue;
});

function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    if (from > to) {
        fromSlider.value = to;
        fromInput.value = to;
    } else {
        fromSlider.value = from;
    }
}
    
function controlToInput(toSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    setToggleAccessible(toInput);
    if (from <= to) {
        toSlider.value = to;
        toInput.value = to;
    } else {
        toInput.value = from;
    }
}

function controlFromSlider(fromSlider, toSlider, fromInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  if (from > to) {
    fromSlider.value = to;
    fromInput.value = to;
  } else {
    fromInput.value = from;
  }
}

function controlToSlider(fromSlider, toSlider, toInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  setToggleAccessible(toSlider);
  if (from <= to) {
    toSlider.value = to;
    toInput.value = to;
  } else {
    toInput.value = from;
    toSlider.value = from;
  }
}

function getParsed(currentFrom, currentTo) {
  const from = parseInt(currentFrom.value, 10);
  const to = parseInt(currentTo.value, 10);
  return [from, to];
}

function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
    const rangeDistance = to.max-to.min;
    const fromPosition = from.value - to.min;
    const toPosition = to.value - to.min;
    controlSlider.style.background = `linear-gradient(
      to right,
      ${sliderColor} 0%,
      ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
      ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
      ${rangeColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} 100%)`;
}

function setToggleAccessible(currentTarget) {
  const toSlider = document.querySelector('#toSlider');
  if (Number(currentTarget.value) <= 0 ) {
    toSlider.style.zIndex = 2;
  } else {
    toSlider.style.zIndex = 0;
  }
}

const fromSlider = document.querySelector('#fromSlider');
const toSlider = document.querySelector('#toSlider');
const fromInput = document.querySelector('#fromInput');
const toInput = document.querySelector('#toInput');
fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
setToggleAccessible(toSlider);

fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
fromInput.oninput = () => controlFromInput(fromSlider, fromInput, toInput, toSlider);
toInput.oninput = () => controlToInput(toSlider, fromInput, toInput, toSlider);


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
