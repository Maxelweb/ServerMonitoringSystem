// Server Monitoring System - Real time update


/*  Converter from Datetime to timeSince
 *
 */

function makeTimeSince(timestamp) {

    var seconds = Math.floor((new Date() - timestamp) / 1000);

    var timeInterval = Math.floor(seconds / 86400);
    if (timeInterval > 1)
        return timeInterval + (timeInterval == 1 ? " day" : " days");
  
    timeInterval = Math.floor(seconds / 3600);
    if (timeInterval > 1)
        return timeInterval + (timeInterval == 1 ? " hour" : " hours");
  
    timeInterval = Math.floor(seconds / 60);
    if (timeInterval > 1) 
        return timeInterval + (timeInterval == 1 ? " minute" : " minutes");

    return Math.floor(seconds) + " seconds";
}

