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
   var Mex = $("#MessageHardware");

    $.ajax({
        url: "refresh.php?s=wakeup&id="+hw, 
        error: function () 
        {
            if(Err.hasClass("hide")) 
                Err.removeClass("hide");
            
            Mex.addClass("hide");
        },
        success: function(result) 
        {
            if(result == "1")
                Mex.html("<i class='fas fa-share-square'></i> Magic packet sent to <strong>" +hw + "</strong>");
            else 
                Mex.html("<i class='fas fa-exclamation-circle'></i> Unable to send magic packet to <strong>" +hw + "</strong>");
            

            Mex.removeClass("hide");

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

function compareIPAddresses(a, b) {
    const numA = Number(
      a.split('.')
        .map((num, idx) => num * Math.pow(2, (3 - idx) * 8))
        .reduce((a, v) => ((a += v), a), 0)
    );
    const numB = Number(
      b.split('.')
        .map((num, idx) => num * Math.pow(2, (3 - idx) * 8))
        .reduce((a, v) => ((a += v), a), 0)
    );
    return numA > numB;
}

function sortTable(n) {
    var isIpCase = 1; // only column with ip
    var table, rows, switching, i, x, y, xi, yi, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("hardwareTable");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            xi = x.innerText || x.textContent;
            yi = y.innerText || y.textContent;
            if (dir == "asc") {
                if ((isIpCase == n && compareIPAddresses(xi, yi)) || (isIpCase != n && xi > yi)) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if ((isIpCase == n && compareIPAddresses(yi, xi)) || (isIpCase != n && xi < yi)) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}


$(document).ready(function() {
    
    sortTable(1);
    var inter = setInterval(function () {
        updateAllDevices();
    }, 3000);
});
