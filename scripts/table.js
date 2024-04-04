//pull variables from URL
document.addEventListener('DOMContentLoaded', function() {
    var url = new URLSearchParams(window.location.search);
    var numColors = parseInt(url.get('numColors'));

    colorSelect(numColors);
});

function colorSelect(numColors){
    var colorTable = document.createElement('table');
    colorTable.setAttribute('border', '2');


    for(var i = 0; i < numColors; i++){
        var row = colorTable.insertRow(i);
        
        //left column
        var cellLeft = row.insertCell();
        cellLeft.textContent = "Color " + (i + 1) + ":";

        //right column
        var cellRight = row.insertCell();
        cellRight.textContent = "color selected";   
    }

    document.getElementById('colorSelect').appendChild(colorTable);
}