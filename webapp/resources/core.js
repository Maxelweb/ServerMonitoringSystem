// Server Monitoring System - Real time update


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
        if(timestamp > 0 && timestamp % 10 == 0)
        {
            timestamp = 0;
            console.log("Data update: ");
        }
}


$(document).ready(function() {

    var timehtml = $("#TimeSince");

    var inter = setInterval(
        function() { 
            timestamp++; 
            timehtml.text(makeTimeSince(currentTime, currentTime + timestamp));
            toggleAutoRefresh();
    }, 1000);

});


