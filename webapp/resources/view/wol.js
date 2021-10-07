function updateDevice(deviceName) {
    var Err = $("#ErrorHardware");

    $.ajax({
        url: "refresh.php?s=hardware&id=" + deviceName, 
        error: function () 
        {
            if(Err.hasClass("hide")) 
                Err.removeClass("hide");
        },
        success: function(result) 
        {
            if(!Err.hasClass("hide")) 
                Err.addClass("hide");
            $("#" + deviceName).html(result);
        }
    });
}


function wakeUp(hw)
{
   var Err = $("#ErrorHardware");

    $.ajax({
        url: "refresh.php?s=wakeup&id="+hw, 
        error: function () 
        {
            if(Err.hasClass("hide")) 
                Err.removeClass("hide");
        },
        success: function(result) 
        {
            if(!Err.hasClass("hide")) 
                Err.addClass("hide");
        }
    }); 
}

function updateAllDevices() {
    $(".itemDevice").each(function() {              
        // console.log($(this).attr('id'));  
        updateDevice($(this).attr('id'));
    });
}

$(document).ready(function() {

    var inter = setInterval(updateAllDevices(), 3000);

});
