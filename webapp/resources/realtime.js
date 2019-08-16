// Server Monitoring System - Realtime graph


/* Globals */

var refreshes = 0;
var itemsTemp = 0;
var itemsHumi = 0;
const maxData = 10;
var currentTime = Date.now();
var currentData = [];
var total = [];


/* Chart options */

const chartTempOptions =
    {
        responsive: true,
        maintainAspectRatio: true,
        tooltips: {
            callbacks: {
                label: (item) => ` ${item.yLabel}° C`,
            },
        },
        scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: 0.0,
                    suggestedMax: 45.0,
                },  
                gridLines: {
                     display: true,
                     color: '#CCC',
                     lineWidth: 1
                }    
            }], 
            xAxes: [{
                gridLines: {
                     display: true,
                     color: '#ededed',
                     lineWidth: 1
                }    
            }]           
        }
    };


const chartHumiOptions =
    {
        responsive: true,
        maintainAspectRatio: true,
        tooltips: {
            callbacks: {
                label: (item) => ` ${item.yLabel} %`,
            },
        },
        scales: {
            yAxes: [{
                ticks: {
                    min: 0.0,
                    max: 100.0,
                },  
                gridLines: {
                     display: true,
                     color: '#CCC',
                     lineWidth: 1
                }    
            }], 
            xAxes: [{
                gridLines: {
                     display: true,
                     color: '#ededed',
                     lineWidth: 1
                }    
            }]           
        }
    };



/* Functions */


function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

function removeData(chart) {
    chart.data.labels.shift();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.shift();
    });
    chart.update();
}


function updateData() {
    var Err = $("#Error");

    $.ajax({
        url: "refresh.php?s=realtime", 
        error: function () {
            if(Err.hasClass("hide"))
                Err.removeClass("hide");
            currentData = [];
        },
        success: function(result) {
            if(!Err.hasClass("hide")) 
                Err.addClass("hide");

            currentData = JSON.parse(result);
            if(total.length === 0)
                total = currentData;
            else
            {
                total.temperature += currentData.temperature;
                total.humidity += currentData.humidity;
            }
        }
    });
}

function addZero(i) {
  if (i < 10) 
    i = "0" + i;
  return i;
}


function updateAverage(){
    var avgT = $("#AvgTemp");
    var avgH = $("#AvgHumi");

    if(refreshes >= 3)
    {
        avgT.text((total.temperature/refreshes).toFixed(2));
        avgH.text((total.humidity/refreshes).toFixed(2));
    }
}

/* main body */

$(document).ready(function() {

    var tempChart = new Chart(
        document.getElementById('TempChart').getContext('2d'), 
        {
            type: 'line',

            data: {
                labels: [],
                datasets: [{
                    label: 'Temperature (° C)',
                    borderColor: '#eab71e',
                    pointBackgroundColor: '#ff9000',
                    backgroundColor: 'rgba(255, 244, 219, 0.5)',
                    data: []
                }]
            },

            options: chartTempOptions
        }
    );

    var humiChart = new Chart(
        document.getElementById('HumiChart').getContext('2d'), 
        {
            type: 'line',

            data: {
                labels: [],
                datasets: [{
                    label: 'Humidity (0 - 100)%',
                    borderColor: '#5ccee0',
                    pointBackgroundColor: '#1495e5',
                    backgroundColor: 'rgba(197, 229, 249, 0.5)',
                    data: []
                }]
            },

            options: chartHumiOptions
        }
    );

    var refresh = $("#AutoRefresh");
    

    var inter = setInterval(
        function() { 

            var timer = new Date();
            var ctime = addZero(timer.getHours()) + ":" 
                    + addZero(timer.getMinutes()) + ":" 
                    + addZero(timer.getSeconds());
            
            if(refresh.prop('checked'))
            {
                updateData();

                if(currentData.length !== 0)
                {

                    if(itemsTemp > maxData)
                    {
                        removeData(tempChart);
                        itemsTemp--;
                    }

                    addData(tempChart,ctime,currentData.temperature);
                    itemsTemp++;
                    
                    if(itemsHumi > maxData)
                    {
                        removeData(humiChart);
                        itemsHumi--;
                    }

                    addData(humiChart,ctime,currentData.humidity);
                    itemsHumi++;

                }

                refreshes++;
                updateAverage();
            }

    }, 1000);

});


