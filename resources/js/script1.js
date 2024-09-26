import $ from 'jquery';
window.$ = window.jQuery = $;


import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

window.call_func = function(listval) {
    
    const apiUrl = `/api/get_data?listval=`+listval;

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
        
console.log(Object.values(data.label));    
console.log(myChart.data.label)  
       myChart.data.labels = Object.values(data.label);
        myChart.data.datasets[0].data = Object.values(data.label_data);
        myChart.update();
        //console.log(myChart.data.datasets[0].data);
        // Handle the response data
    })
    .catch(error => {
        console.error('Error:', error);
    });



}

       // myButton();
        // You can add more functionality here
   
        console.log( Object.values(label));

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar', // Specify the type of chart
                data: {
                    labels: Object.values(label),
                    datasets: [{
                        label: 'Topics per Sector',
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
                        label: 'Avg Intensity Over Time',
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
        
        

        