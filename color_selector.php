<!DOCTYPE html>
<html lang="en_US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Selection</title>
</head>
<body>
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_color"])) {
        $name = $_POST["name"];
        $hex = $_POST["hex"]; 

        
        $check_query = "SELECT * FROM colors WHERE Name = ? OR hex = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $name, $hex);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Color with the same name or hex value already exists.";
        } else {
           
            $insert_query = "INSERT INTO colors (Name, hex) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ss", $name, $hex);
            if ($stmt->execute()) {
                echo "Color added successfully.";
            } else {
                echo "Error adding color.";
            }
            header("Location: color_selector.php"); 
            exit();
        }
    } elseif (isset($_POST["edit_color"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $hex = $_POST["hex"]; 
        
        $check_query = "SELECT * FROM colors WHERE (Name = ? OR hex = ?) AND id != ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ssi", $name, $hex, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "Color with the same name or hex value already exists.";
        } else {
            $update_query = "UPDATE colors SET Name = ?, hex = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssi", $name, $hex, $id);
            if ($stmt->execute()) {
                echo "Color updated successfully.";
            } else {
                echo "Error updating color.";
            }
            header("Location: color_selector.php"); 
            exit();
        }
    } elseif (isset($_POST["delete_color"])) {
        $count_query = "SELECT COUNT(*) AS count FROM colors";
        $result = $conn->query($count_query);
        $row = $result->fetch_assoc();
        $color_count = $row['count'];

        if ($color_count > 2) {
            $name = $_POST["name"];
            $hex = $_POST["hex"]; 

            $delete_query = "DELETE FROM colors WHERE Name = ? AND hex = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("ss", $name, $hex);
            if ($stmt->execute()) {
                echo "Color deleted successfully.";
                header("Location: color_selector.php"); 
                exit();
            } else {
                echo "Error deleting color: " . $stmt->error;
            }
        } else {
            echo "Cannot delete the last two colors.";
        }
    }
}
?>

<head>
 <meta charset="UTF-8">
        <meta name="description" content="CS312 color select page page">
        <meta name="keywords" content="HTML">
        <meta name="author" content="Jacob Cole">
        <link rel="stylesheet" href="style.css">
        <title>Color Selector</title>
    </head>
<body>

<h1>Color Selection</h1>
<style>
        .form-box {
            border: 4px solid black;
            border-radius: 2px;
            padding: auto;
            margin-bottom: 10px;
        }
    </style>

<nav>
    <a href="index.php">Home</a>
    <a style="color=#04622D" href="about.php">About</a>
    <a href="index.php">
        <img class = "logo" src="./images/ColordinateText.png" alt="header logo image" height=50px>
    </a>
    <a style="color=#AB0D12" href="color_coordinate.php">Color Coordinator</a>
    <a style="color=#04622D" href="color_selector.php">Color Selector</a>
</nav>

<div class="form-box">
<h2>Add New Color</h2>
<form action="color_selector.php" method="post">
    <label for="add_name">Name:</label>
    <input type="text" id="add_name" name="name" required><br>
    <label for="add_hex">Hex Value:</label>
    <input type="text" id="add_hex" name="hex" required><br> 
    <input type="submit" name="add_color" value="Add Color">
</form>
</div>

<div class="form-box">
<h2>Edit Color</h2>
<form action="color_selector.php" method="post">
    <label for="edit_color">Select Color to Edit:</label>
    <select id="edit_color" name="id">
        <?php
        $edit_query = "SELECT DISTINCT id, Name FROM colors";
        $stmt = $conn->prepare($edit_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['Name'] . "</option>";
        }
        ?>
    </select><br>
    <label for="edit_name">New Name:</label>
    <input type="text" id="edit_name" name="name" required><br>
    <label for="edit_hex">New Hex Value:</label>
    <input type="text" id="edit_hex" name="hex" required><br> 
    <input type="submit" name="edit_color" value="Edit Color">
</form>
</div>

<div class="form-box">
<h2>Delete Color</h2>
<form action="color_selector.php" method="post">
    <label for="delete_color">Select Color to Delete:</label>
    <select id="delete_color" name="id">
    <?php
        $delete_query = "SELECT DISTINCT id, Name FROM colors"; 
        $stmt = $conn->prepare($delete_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['Name'] . "</option>";
        }
        ?>
    </select><br>
    <input type="checkbox" id="confirm_delete" name="confirm_delete" required>
    <label for="confirm_delete">Confirm Deletion</label><br>
    <input type="submit" name="delete_color" value="Delete Color">
</form>
    </div>

<?php
$conn->close();
?>
</body>
<footer>
    <hr>
        <p> 2024 Team 5</p>
    <hr>
    <hr>
</footer>
</html>
