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
<hr>
<nav>
	<a href="about.php">About</a>
	<a href="index.php">Home</a>
</nav>
<hr>
<body>
    <form id="colorForm">
        <label for="numColors">Number of Colors:</label>
        <input type="number" id="numColors" name="numColors" min="1" max="10"><br><br>
        
        <!-- Add more input fields as needed -->
        
        <input type="submit" value="Generate Color Coordinate">
    </form>
    <div id="colorSelect"></div>

    <div id="errorMessage"></div>

    <div id="colorCoordinate"></div>

    <script type="text/javascript" src="./scripts/table.js"></script>	
</body>
<footer>
	<hr>
	    <p> 2024 Team 5</p>
	<hr>
	<hr>
</footer>
</html>