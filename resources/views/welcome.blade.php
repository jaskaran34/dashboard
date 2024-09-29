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

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="container" style="margin: auto auto;">

    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">
                <span class="close" data-modal="modal1">&times;</span>
                </div>
                <div class="card-body">

                </div>
            </div>
            
        </div>
    </div>

    <div class="row design">
            

            <div class="col-12">

            <div class="card" id="filter_card">
                <div class="card-header">
                <table>
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
                            <button class="btn btn-success " style="margin-left: 50px;color:white;
            width: 200px; /* Custom width */
            height: 35px; /* Custom height */
            line-height: 35px; /* Match height to align text vertically */
            padding: 0; /* Remove default padding */
            text-align: center;" onclick="filter_data();">Filter</button>
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
                    <h5>Sectors Analysis</h5>    
                
                    </div>
                    <div class="card-body>">
                        <div style="margin-bottom: 1%;
    float: right;
    margin-top: 1%;
    margin-right: 1%;
    color: blue;
    font-weight: 600;">
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
                    <canvas id="myChart" ></canvas>
                    </div>
                </div>
            
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                    <h5>Pestle Analysis</h5>
                    </div>
                    <div class="card-body>">
                    <div style="margin-bottom: 7%;
    float: right;
    margin-top: 1%;
    margin-right: 1%;
    color: white;
    font-weight: 600;"><h1>hellp</h1></div>
                    <canvas id="myChart2" ></canvas>
                    </div>
                </div>
            
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Swot Analysis</h5>

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart_pie" ></canvas>
                    </div>
                </div>
            
            </div>


        </div>
        <div class="row design">

        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <h5>Impact Analysis among sectors</h5>
                </div>
                <div class="card-body">
                    <canvas id="bar_stacked"></canvas>
                </div>
            </div>
        </div>

        <div class="col-4">
                <div class="card">
                    <div class="card-header">
                    <h5>Impact,relevance and topic count</h5>
                    </div>
                    <div class="card-body>">
                    <canvas id="myChart_stacked" ></canvas>
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


function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        // Function to close modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        // Get all buttons and attach event listeners
        

        document.querySelectorAll('.close').forEach(function(element) {
            element.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal');
                closeModal(modalId);
            });
        });

        // Close modal if user clicks outside of modal content
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }


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

    window.sector_bar_stacked = @json($sector_bar_stacked);
    window.low = @json($low);
    window.medium = @json($medium);
    window.high = @json($high);
   
    
</script>


    </body>
</html>
