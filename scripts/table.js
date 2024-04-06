//pull variables from URL
document.addEventListener('DOMContentLoaded', function() {
    var url = new URLSearchParams(window.location.search);
    var numColors = parseInt(url.get('numColors'));
    var rowsCols = parseInt(url.get('rowsCols'));

    console.log('numColors:', numColors);
    console.log('rowsCols:', rowsCols);

    colorSelect(numColors);
    colorCoordinate(rowsCols);
});

function colorSelect(numColors){
    var colorTable = document.createElement('table');
    colorTable.setAttribute('border', '2');


    for(var i = 0; i < numColors; i++){
        var row = colorTable.insertRow(i);
        
        //left column
        var cellLeft = row.insertCell();
        cellLeft.style.width = '20%';
        cellLeft.textContent = (" " + (i+1) + " ");
        

        //right column
        var cellRight = row.insertCell(); 
        cellRight.style.width = '80%'
        var colorDrop = colorDropdown(i);
        cellRight.appendChild(colorDrop);
    }

    document.getElementById('colorSelect').appendChild(colorTable);
}

function colorDropdown(numColors){
    var colorDrop = document.createElement('select');
    colorDrop.id = 'color' + numColors;

    var colors = ['red', 'orange', 'yellow', 'green', 'teal', 'blue', 'purple', 'grey', 'brown', 'black'];

    //fills dropdown with color array
    for(var i = 0; i < colors.length; i++){
        var option = document.createElement('option');
        option.value = colors[i];
        option.text = colors[i];
        colorDrop.appendChild(option);
    }

    //sets each dropdown as a different option
    colorDrop.value = colors[numColors % colors.length];

    //sets previous value to current value
    colorDrop.dataset.previousValue = colorDrop.value;

    colorDrop.addEventListener('change', function(){

        var desiredColor = this.value;
        var colorDropdowns = document. querySelectorAll('select');
        var errorMessage = document.getElementById('errorMessage');
        var previousValue = this.dataset.previousValue;

        console.log('Desired Color:', desiredColor);
        console.log('Previous Value:', previousValue);

        //interate over dropdowns
        for(var j = 0; j < colorDropdowns.length; j++){

            //checks to see if current dropdown is equal to previous dropdown
            if (j != numColors && colorDropdowns[j].value === desiredColor) {
                this.value = previousValue || "please select a color";
                errorMessage.textContent = 'Same color cannot be selected';
                errorMessage.style.color = 'red';

                //clears error message after 2 seconds
                setTimeout(function(){
                errorMessage.textContent = '';
                }, 2000);
                break;
            }
        }

        this.dataset.previousValue = this.value; //sets previous value to current value
    });


    return colorDrop;
}

function colorCoordinate(rowsCols) {
    var colorGrid = document.createElement('table');
    colorGrid.setAttribute('border', '1');

    for(var i = 0; i < rowsCols + 1; i++){ // Rows created
        var row = colorGrid.insertRow(i);
        for(var j = 0; j < rowsCols + 1; j++){// Columns created
            var col = row.insertCell(j);
            col.style.width = '30px'; // cells set to a square
            col.style.height = '30px';

            if(i === 0 & j === 0){
                col.textContent = ''; // keep top left cell blank
            }else if (i === 0) {
                col.textContent = String.fromCharCode(65 + (j-1)); // Letter lables for columns
            } else if (j === 0) {
                col.textContent = i; //number letters for rows
            }else {
                col.addEventListener('click', function(){ //returns the cell coordinate when clicked
                    var rowIndex = this.parentNode.rowIndex;
                    var colIndex = this.cellIndex;
                    var coordinate = String.fromCharCode(65 + (colIndex -1)) + rowIndex;
                    alert('Cell coordinate is: ' + coordinate);
                });
            }
        }
        
    }

    document.getElementById('colorCoordinate').appendChild(colorGrid);
}
