<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="CS312 color coordinate page page">
        <meta name="keywords" content="HTML">
        <meta name="author" content="Jacob Cole">
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

            <title>Color Coordinator</title>
    </head>
<body>
<h1>Color Coordinator</h1>

<nav>
		<a href="index.php">Home</a>
		<a style="color=#04622D" href="about.php">About</a>
		<a href="index.php">
			<img class = "logo" src="./images/ColordinateText.png" alt="header logo image" height=50px>
		</a>
		<a style="color=#AB0D12" href="color_coordinate.php">Color Coordinator</a>
	</nav>

<body>
    <form id="colorForm">
        <label for="numColors">Number of Colors:</label>
        <input type="number" id="numColors" name="numColors" min="1" max="10"><br><br>

        <label for="rowsCols">Number of Rows & Columns:</label>
        <input type="number" id="rowsCols" name="rowsCols" min="1" max="26"><br><br>

        <input type="submit" value="Generate Color Coordinate"><br><br>
    </form>

    <h3>Select Colors</h3>
    <div id="colorSelect"></div>

    <div id="errorMessage"></div><br><br>

    <h3>Color Coordinate</h3>
    <div id="colorCoordinate"></div>

    <script type="text/javascript" src="./scripts/table.js"></script>

    <button id='print-view'>Printable View</button>

    <script>
        document.addEventListener("DOMContentLoaded", function(){

            const colorMap = {
                "red": "#FF0000",
                "orange": "#FFA500",
                "yellow": "#FFFF00",
                "green": "#00FF00",
                "teal": "#008080",
                "blue": "#0000FF",
                "purple": "#800080",
                "grey": "#808080",
                "brown": "#A52A2A",
                "black": "#000000"
            };
            const print = document.getElementById('print-view');
            if(print){
                print.addEventListener('click', function() {
                    const dropdowns = document.querySelectorAll('select');
                    dropdowns.forEach(dropdown => {
                        const selectedColor = dropdown.value;
                        const colorHex = colorMap[selectedColor];
                        const dropdownContainer = document.createElement('span');
                        dropdownContainer.textContent = `${selectedColor} (${colorHex})`;
                        dropdown.parentNode.replaceChild(dropdownContainer, dropdown);
                    });

                    const colors = document.getElementById('color-table');
                    const grid = document.getElementById('color-grid');

                    const printPage = window.open('', '_blank');

                    const gridCells = grid.querySelectorAll('td');
                    gridCells.forEach(cell => {
                        cell.style.backgroundColor = '';
                    });

                    printPage.document.write(`
                    <html>
                        <head>
                            <title>Print Page</title>
                            <style>
                            body {
                                margin: 0;
                                padding: 0;
                                height: 100%;
                            }
                            header {
                                color: #000;
                                padding: 20px;
                                display: flex;
                                align-items: center;
                            }
                            table {
                                border-collapse: collapse;
                                margin-bottom: 20px;
                            }
                            td {
                                border: 1px solid black;
                                padding: 5px;
                                text-align: center;
                                background-color: white;
                            }
                            header h1{
                                margin: 0;
                                flex-grow: 1;
                            }
                            header img{
                                height: 50px;
                                margin-left: 20px;
                                filter: grayscale(100%);
                            }
                            #color-table{
                                width: 100%;
                                filter: grayscale(100%);
                            }
                            #color-table td{
                                height: 30px;
                                background-color: white;
                            }
                            #color-table td:first-child{
                                display: none;
                            }
                            #color-grid{
                                width: auto;
                                table-layout: fixed;
                            }
                            #color-grid td{
                                width: 150px;
                                height: 150px;
                                mid-width: 150px;
                                min-height: 150px;
                                background-color: white;
                                padding: 0;
                            }
                            #header{
                                text-align: center;
                                margin-bottom: 20px;
                            }
                            #header img{
                                width: 200px;
                            }
                            </style>
                        </head>
                        <body>
                        <header>
                        <h1>Colordinate</h1>
                        <img id='logo' src="./images/ColordinateLogo2.png" alt="Colordinate Logo">
                        </header>
                        ${colors.outerHTML}
                        ${grid.outerHTML}
                        </body>
                    `);
                    printPage.document.close();
                });
            }
        });
    </script>
</body>
<footer>
    <hr>
        <p> 2024 Team 5</p>
    <hr>
    <hr>
</footer>
</html>
