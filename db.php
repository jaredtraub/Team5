<?php
    $servername = "faure:3306";
    $username = "jccole30";
    $password = "833607846";
    $dbname = "jccole30";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("connection failed" . $conn->connect_error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS colors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(255) UNIQUE NOT NULL,
        hex VARCHAR(10) UNIQUE NOT NULL
    )";

$colorMap = [
    "red" => "#FF0000",
    "orange" => "#FFA500",
    "yellow" => "#FFFF00",
    "green" => "#00FF00",
    "teal" => "#008080",
    "blue" => "#0000FF",
    "purple" => "#800080",
    "grey" => "#808080",
    "brown" => "#A52A2A",
    "black" => "#000000"
];

foreach ($colorMap as $name => $hex) {
    $insert_query = "INSERT INTO colors (Name, hex) VALUES ('$name', '$hex')";
    if ($conn->query($insert_query) === TRUE) {
        echo "Color '$name' added successfully.<br>";
    } else {
        echo "Error adding color '$name': " . $conn->error . "<br>";
    }
}

?>