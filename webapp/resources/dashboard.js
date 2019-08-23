// Server Monitoring System - Dashboard


/* Globals */

var timestamp = 0;
var currentTime = Date.now();


/*  Converter for time since last update */

function makeTimeSince(oldtime, newtime) {

    var seconds = newtime - oldtime < 0 ? 0 : newtime-oldtime;

    var timeInterval = Math.floor(seconds / 86400);
    if (timeInterval >= 1)
        return timeInterval + (timeInterval == 1 ? " day" : " days");
  
    timeInterval = Math.floor(seconds / 3600);
    if (timeInterval >= 1)
        return timeInterval + (timeInterval == 1 ? " hour" : " hours");
  
    timeInterval = Math.floor(seconds / 60);
    if (timeInterval >= 1) 
        return timeInterval + (timeInterval == 1 ? " minute" : " minutes");

    return Math.floor(seconds) + (seconds == 1 ? " second" : " seconds");
}

function toggleAutoRefresh() {

    var checkbox = $("#AutoRefresh");
    
    if(checkbox.prop('checked'))
        if(timestamp >= 0 && timestamp % 10 == 0)
        {
            timestamp = 0;
            updateSensorsMonitor();
            updateHardwareMonitor();
        }
}

function updateSensorsMonitor() {
    var Err = $("#ErrorSensors");

    $.ajax({
        url: "refresh.php?s=dashboard-sensors", 
        error: function () {
            if(Err.hasClass("hide"))
                Err.removeClass("hide");
        },
        success: function(result) {
            if(!Err.hasClass("hide")) 
                Err.addClass("hide");
            $("#SensorsContainer").html(result);
        }
    });
}

function updateHardwareMonitor() {
    var Err = $("#ErrorHardware");

    $.ajax({
        url: "refresh.php?s=dashboard-hardware", 
        error: function () 
        {
            if(Err.hasClass("hide")) 
                Err.removeClass("hide");
        },
        success: function(result) 
        {
            if(!Err.hasClass("hide")) 
                Err.addClass("hide");
            $("#HardwareContainer").html(result);
        }
    });
}


$(document).ready(function() {

    toggleAutoRefresh();

    var timehtml = $("#TimeSince");

    var inter = setInterval(
        function() { 
            timestamp++; 
            timehtml.text(makeTimeSince(currentTime, currentTime + timestamp));
            toggleAutoRefresh();
    }, 1000);

});


