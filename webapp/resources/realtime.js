// Server Monitoring System - Realtime graph


/* Globals */

var timestamp = 0;
var items = 0;
var currentTime = Date.now();

var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {

    type: 'line',

    data: {
        labels: [],
        datasets: [{
            label: 'Temperature',
            borderColor: '#4C7D7C',
            pointBackgroundColor: 'green',
            data: []
        }]
    },

    options: {
        scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: -5,
                    suggestedMax: 45
                }
            }]
        },
        
    }
});



function updateTemp(timer) {
    var Err = $("#Error");
    $.ajax({
        url: "refresh.php?s=realtime", 
        error: function () {
            if(Err.hasClass("hide"))
                Err.removeClass("hide");
        },
        success: function(result) {
            if(!Err.hasClass("hide")) 
                Err.addClass("hide");
            
            addData(chart,timer,result);
        }
    });
}


function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    items++;
    chart.update();
}

function removeData(chart) {
    chart.data.labels.shift();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.shift();
    });
    items--;
    chart.update();
}


$(document).ready(function() {

    var refresh = $("#AutoRefresh");


    var inter = setInterval(
        function() { 

            timestamp++;

            var timer = new Date();
            ctime = timer.getHours() + ":" + timer.getMinutes() + ":" + timer.getSeconds();
            
            if(refresh.prop('checked'))
            {
                if(items > 10)
                    removeData(chart);

                updateTemp(ctime);
            }

    }, 1000);

});


