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

    <button onclick="duplicatePage()">Printable View</button>

    <script>
        function duplicatePage() {
            // Get the current URL of the page
            var currentUrl = window.location.href;
    
            // Open a new tab with the same URL
            var newTab = window.open(currentUrl, '_blank');

            // Once the new tab is loaded, apply grayscale filter
            newTab.onload = function() {
                newTab.document.documentElement.style.filter = 'grayscale(100%)';

                 // Disable links
                var links = newTab.document.getElementsByTagName('a');
                for (var i = 0; i < links.length; i++) {
                    links[i].href = 'javascript:void(0)';
                    links[i].onclick = null;
                }

                // Replace dropdowns with plain text
                var dropdowns = newTab.document.getElementsByTagName('select');
                for (var i = 0; i < dropdowns.length; i++) {
                    var selectedOption = dropdowns[i].options[dropdowns[i].selectedIndex].text;
                    var plainText = newTab.document.createTextNode(selectedOption);
                    dropdowns[i].parentNode.replaceChild(plainText, dropdowns[i]);
                }

                // Disable form submission
                var forms = newTab.document.getElementsByTagName('form');
                for (var i = 0; i < forms.length; i++) {
                    forms[i].onsubmit = function() { return false; };
                }

                // Disable buttons
                var buttons = newTab.document.getElementsByTagName('button');
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].onclick = null;
                    buttons[i].disabled = true;
                }

                // Replace dropdowns with plain text
                var dropdowns = newTab.document.querySelectorAll('select, input[type="number"]');
                for (var i = 0; i < dropdowns.length; i++) {
                    var selectedOption;
                    if (dropdowns[i].tagName === 'SELECT') {
                        selectedOption = dropdowns[i].options[dropdowns[i].selectedIndex].text;
                    } else if (dropdowns[i].tagName === 'INPUT') {
                        selectedOption = dropdowns[i].value;
                    }
                    var plainText = newTab.document.createTextNode(selectedOption);
                    dropdowns[i].parentNode.replaceChild(plainText, dropdowns[i]);
                }
            };
        }
    </script>
</body>
<footer>
    <hr>
        <p> 2024 Team 5</p>
    <hr>
    <hr>
</footer>
</html>
