function prettyPrint() {
    var ugly = document.getElementById('editConfig').value;
    var obj = JSON.parse(ugly);
    var pretty = JSON.stringify(obj, undefined, 4);
    document.getElementById('editConfig').value = pretty;
}

function updateJsonStatus(response) {
    document.getElementById("saveRaw").disabled = (!response);
    document.getElementById("jsonValid").innerHTML = ((response) ? "<span class='good'>Json is VALID</span>" : "<span class='bad'>Json is INVALID</span>");
}

function isValidJson(json) {
    try {
        JSON.parse(json);
        return true;
    } catch (e) {
        return false;
    }
}

$(document).ready(function() {

    prettyPrint();

});

