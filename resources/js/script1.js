import $ from 'jquery';
window.$ = window.jQuery = $;


import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);


window.update_chart=function(apiUrl,chart_code){
    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {

        if(chart_code=='1'){
         // console.log(data);
        myChart.data.labels = Object.values(data.label);
        myChart.data.datasets[0].data = Object.values(data.label_data);
        myChart.update();

        }

        if(chart_code=='2'){
            //console.log(data);
            myChart2.data.labels = Object.values(data.label);
            myChart2.data.datasets[0].data = Object.values(data.label_data);
            myChart2.update();
    
            }

            if(chart_code=='3'){
                console.log(data);
                myChart_pie.data.labels = Object.values(data.label);
                myChart_pie.data.datasets[0].data = Object.values(data.label_data);
                myChart_pie.update();
        
                }
                if(chart_code=='4'){
                    console.log(data);



                    myChart_bar_stacked.data.labels = Object.values(data.sector_bar_stacked);
                    myChart_bar_stacked.data.datasets[0].data = Object.values(data.low);
                    myChart_bar_stacked.data.datasets[1].data = Object.values(data.medium);
                    myChart_bar_stacked.data.datasets[2].data = Object.values(data.high);
                    myChart_bar_stacked.update();
            
                    }
                    if(chart_code=='5'){
                        console.log(data);


                        myChart_stacked.data.labels = Object.values(data.label_stacked);
                        myChart_stacked.data.datasets[0].data = Object.values(data.label_data_stacked_impact);
                        myChart_stacked.data.datasets[1].data = Object.values(data.label_data_stacked_intensity);
                        myChart_stacked.data.datasets[2].data = Object.values(data.label_data_stacked_topic_count);
                        myChart_stacked.update();
                
                        }

                
        // Handle the response data
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

window.filter_data= function(){

    let selOptions= document.getElementById('selectedOptions').value ?? '';
    let selectedRegionOptions= document.getElementById('selectedRegionOptions').value ?? '';
    let relevance= document.getElementById('mySlider').value.trim() ?? '';
    let min_intensity=document.getElementById('fromInput').value
    let max_intensity=document.getElementById('toInput').value
   
    
    let flag='OV';
    
    //chart1 
    let listval_mychart=document.getElementById('change1').value;
    let filter_impact=document.getElementById('filter_impact').value;

    const apiUrl_bar = `/api/filter_data_bar?end_year=`+selOptions + '&relevance=' + relevance 
    + '&min_intensity=' + min_intensity
    + '&max_intensity=' + max_intensity
    + '&region=' + selectedRegionOptions + '&listval_mychart=' + listval_mychart + '&flag=' + flag + 
    '&impact=' + filter_impact ;
    
    //console.log(apiUrl_bar);
    update_chart(apiUrl_bar,'1');

    
    //chart2
    //let listval_linechart='5';
    const apiUrl_line = `/api/filter_data_line?end_year=`+selOptions + '&relevance=' + relevance 
    + '&min_intensity=' + min_intensity
    + '&max_intensity=' + max_intensity
     + '&region=' + selectedRegionOptions  + '&flag=' + flag;

    //console.log(apiUrl_line);
    update_chart(apiUrl_line,'2');


    const apiUrl_pie = `/api/filter_data_pie?end_year=`+selOptions + '&relevance=' + relevance 
    + '&min_intensity=' + min_intensity
    + '&max_intensity=' + max_intensity
     + '&region=' + selectedRegionOptions  + '&flag=' + flag;

    //console.log(apiUrl_pie);
    update_chart(apiUrl_pie,'3');

    const apiUrl_bar_stacked = `/api/filter_data_bar_stacked?end_year=`+selOptions + '&relevance=' + relevance 
    + '&min_intensity=' + min_intensity
    + '&max_intensity=' + max_intensity
     + '&region=' + selectedRegionOptions  + '&flag=' + flag;

    //console.log(apiUrl_bar_stacked);
    update_chart(apiUrl_bar_stacked,'4');

    const apiUrl_radar = `/api/filter_data_radar?end_year=`+selOptions + '&relevance=' + relevance 
    + '&min_intensity=' + min_intensity
    + '&max_intensity=' + max_intensity
     + '&region=' + selectedRegionOptions  + '&flag=' + flag;

    console.log(apiUrl_radar);
    update_chart(apiUrl_radar,'5');




}



window.call_func = function() {

    let selOptions= document.getElementById('selectedOptions').value ?? '';
    let flag='OV';
    let selectedRegionOptions= document.getElementById('selectedRegionOptions').value ?? '';
    let min_intensity=document.getElementById('fromInput').value
    let max_intensity=document.getElementById('toInput').value

    let listval_mychart=document.getElementById('change1').value;
    let filter_impact=document.getElementById('filter_impact').value;


    let apiUrl = `/api/filter_data_bar?end_year=`+selOptions + '&region=' + selectedRegionOptions 
    + '&min_intensity=' + min_intensity
    + '&max_intensity=' + max_intensity
    + '&listval_mychart=' + listval_mychart + '&flag=' + flag + '&impact=' + filter_impact;
   // console.log(apiUrl);
    update_chart(apiUrl,'1');


}

       // myButton();
        // You can add more functionality here
   

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar', // Specify the type of chart
                data: {
                    labels: Object.values(label),
                    datasets: [{
                        label: 'Records per Sector',
                        data: Object.values(label_data),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false,
                                min: 0, // Set a minimum value for the y-axis
                                max: 200, // Set a maximum value for the y-axis
                                ticks: {
                                    display: true // Hide the y-axis ticks
                                
                            //
                                }
                        }
                    }
                }
            });

            ctx.canvas.addEventListener('click', function(event) {
                const activePoints = myChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, false);
                
                if (activePoints.length > 0) {
                    const firstPoint = activePoints[0];
                    const label = myChart.data.labels[firstPoint.index];
                    const value = myChart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                    
                    // Call your function here, passing the label and value
                    onBarClick(label, value);
                }
            });
        
            // Function to call on bar click
            function onBarClick(label, value) {
                //alert(`You clicked on ${label} with a value of ${value}`);

                listval=document.getElementById('change1').value;
                const apiUrl = `/api/get_data_topic?label=`+label + '&listval=' + listval;

    // Make the API request
    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        
console.log(data);    exit; 
       myChart.data.labels = Object.values(data.label);
        myChart.data.datasets[0].data = Object.values(data.label_data);
        myChart.update();
        //console.log(myChart.data.datasets[0].data);
        // Handle the response data
    })
    .catch(error => {
        console.error('Error:', error);
    });


                // Add your logic here
            }



            
            const ctx2 = document.getElementById('myChart2').getContext('2d');
            const myChart2 = new Chart(ctx2, {
                type: 'line', // Specify the type of chart
                data: {
                    labels: Object.values(label_line),
                    datasets: [{
                        label: 'Records per Pestle',
                        data: Object.values(label_data_line),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            //console.log(label_data_radar);


            
//$label_data_stacked_intensity[]

const ctx_stacked = document.getElementById('myChart_stacked').getContext('2d');
const myChart_stacked = new Chart(ctx_stacked, {
    type: 'radar', // Change chart type to 'radar'
    data: {
        labels: Object.values(label_stacked), // Categories or sectors for radar chart
        datasets: [{
            label: 'Average Impact',
            data: Object.values(label_data_stacked_impact),
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Light red fill
            borderColor: 'rgba(255, 99, 132, 1)', // Red border
            borderWidth: 2,
            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
        }, {
            label: 'Average Likelihood',
            data: Object.values(label_data_stacked_intensity),
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Light blue fill
            borderColor: 'rgba(54, 162, 235, 1)', // Blue border
            borderWidth: 2,
            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
        }, {
            label: 'No. of Topics',
            data: Object.values(label_data_stacked_topic_count),
            backgroundColor: 'rgba(128, 128, 128, 0.2)', // Light gray fill
            borderColor: 'rgba(128, 128, 128, 1)', // Gray border
            borderWidth: 2,
            pointBackgroundColor: 'rgba(128, 128, 128, 1)',
        }]
    },
    options: {
        responsive: true,
        scales: {
            r: {
                angleLines: {
                    display: true // Show angle lines between points
                },
                suggestedMin: -10, // Set minimum value for the radar axis
                suggestedMax: 20,  // Set maximum value for the radar axis
                ticks: {
                    display: true, // Show the radial ticks
                    beginAtZero: false
                }
            }
        }
    }
});


const ctx_bar_stacked = document.getElementById('bar_stacked').getContext('2d');
const myChart_bar_stacked = new Chart(ctx_bar_stacked, {
    type: 'bar', // Specify the type of chart 
    data: {
        labels: Object.values(sector_bar_stacked),
        datasets: [{
            label: 'Low',
            data: Object.values(low),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2,
            stack: 'stack1' // Assign the same stack key to both datasets
        }, {
            label: 'Medium',
            data: Object.values(medium),
            backgroundColor: [
                'rgba(255, 255, 0, 0.2)', // Yellow
                'rgba(0, 255, 0, 0.2)', // Green
                'rgba(0, 0, 255, 0.2)', // Blue
                'rgba(255, 0, 0, 0.2)', // Red
                'rgba(255, 128, 0, 0.2)', // Orange
                'rgba(128, 0, 128, 0.2)' // Purple
            ],
            borderColor: [
                'rgba(255, 255, 0, 1)', // Yellow
                'rgba(0, 255, 0, 1)', // Green
                'rgba(0, 0, 255, 1)', // Blue
                'rgba(255, 0, 0, 1)', // Red
                'rgba(255, 128, 0, 1)', // Orange
                'rgba(128, 0, 128, 1)' // Purple
            ],
            borderWidth: 2,
            stack: 'stack1' // Assign the same stack key to both datasets
        }, {
            label: 'High',
            data: Object.values(high),
            backgroundColor: [
                'rgba(128, 128, 128, 0.2)', // Gray
                'rgba(204, 204, 204, 0.2)', // Light Gray
                'rgba(153, 153, 153, 0.2)', // Dark Gray
                'rgba(230, 230, 230, 0.2)', // Lighter Gray
                'rgba(102, 102, 102, 0.2)', // Darker Gray
                'rgba(178, 178, 178, 0.2)' // Even Darker Gray
            ],
            borderColor: [
                'rgba(128, 128, 128, 1)', // Gray
                'rgba(204, 204, 204, 1)', // Light Gray
                'rgba(153, 153, 153, 1)', // Dark Gray
                'rgba(230, 230, 230, 1)', // Lighter Gray
                'rgba(102, 102, 102, 1)', // Darker Gray
                'rgba(178, 178, 178, 1)' // Even Darker Gray
            ],
            borderWidth: 1,
            stack: 'stack1' // Assign the same stack key to both datasets
        }]
    },
    options: {
        scales: {
            y: {
                //beginAtZero: true
                beginAtZero: false,
                min: -10, // Set a minimum value for the y-axis
                max: 40, // Set a maximum value for the y-axis
                ticks: {
                    display: true // Hide the y-axis ticks
                }
            }
        }
    }
});




            const ctx_pie = document.getElementById('myChart_pie').getContext('2d');
            const myChart_pie = new Chart(ctx_pie, {
                type: 'doughnut', // Specify the type of chart
                data: {
                    labels: Object.values(label_pie),
                    datasets: [{
                        label: 'SWOT Analysis',
                        data: Object.values(label_data_pie),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        
            

        