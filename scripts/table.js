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

var paintedCells = {};

function colorSelect(numColors){
    var colorTable = document.createElement('table');
    colorTable.setAttribute('border', '2');

    var selectedColorIndex = 0; // Default to the color in the first row

    for(var i = 0; i < numColors; i++){
        var row = colorTable.insertRow(i);

        var cellRadio = row.insertCell();
        cellRadio.style.width = '10%';
        var radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = 'colorRadio';
        radio.value = i;
        radio.checked = i === selectedColorIndex;
        cellRadio.appendChild(radio);

        var cellLabel = row.insertCell();
        cellLabel.style.width = '10%';
        cellLabel.textContent = (" " + (i+1) + " ");

        var cellRight = row.insertCell(); 
        cellRight.style.width = '30%'
        var colorDrop = colorDropdown(i);
        cellRight.appendChild(colorDrop);

        

        var cellPainted = row.insertCell();
        cellPainted.style.width = "50%";
        cellPainted.id = 'paintedCells' + i; // Set ID for easy access
        paintedCells[i] = []
    }

    document.getElementById('colorSelect').appendChild(colorTable);
}

function updatePaintedCellsList(colorIndex) {
    var paintedCellsList = paintedCells[colorIndex];
    paintedCellsList.sort();
    var cellPainted = document.getElementById('paintedCells' + colorIndex);
    cellPainted.innerHTML = '';

    paintedCellsList.forEach(function(coordinate) {
        var span = document.createElement('span');
        span.textContent = coordinate + ', ';
        cellPainted.appendChild(span);
    });

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
                return;
            }
        }

        updateColors(previousValue, desiredColor);
        this.dataset.previousValue = this.value; //sets previous value to current val
    });


    return colorDrop;
}

function updateColors(oldColor, newColor){
    var colorGridCells = document.querySelectorAll('#colorCoordinate td');
    for (var i = 0; i < colorGridCells.length; i++) {
        if (colorGridCells[i].style.backgroundColor === oldColor) {
            colorGridCells[i].style.backgroundColor = newColor;
        }
    }
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
            } else {
                col.addEventListener('click', function(){
                    var rowIndex = this.parentNode.rowIndex;
                    var colIndex = this.cellIndex;
                    var coordinate = String.fromCharCode(65 + (colIndex - 1)) + rowIndex;
                    var selectedColorIndex = parseInt(document.querySelector('input[name="colorRadio"]:checked').value);
                    var selectedColor = document.getElementById('color' + selectedColorIndex).value;

                    
                    if (this.style.backgroundColor){
                        return;
                    }

                    this.style.backgroundColor = selectedColor;

                    paintedCells[selectedColorIndex].push(coordinate);

                    updatePaintedCellsList(selectedColorIndex);
                    
                    
                });
            }
        }
    }

    document.getElementById('colorCoordinate').appendChild(colorGrid);
}
