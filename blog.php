<?php
// blog.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "admin_panel";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve admin_users from database
$sql = "SELECT * FROM admin_users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <style>
        .post-container {
            width: 700px;
            margin: 0 auto;
        }
        .post {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .post h2 {
            margin-top: 0;
        }
        .post img {
            max-width: 100%;
            max-height: 400px;
        }
    </style>
</head>
<body>
    <div class="post-container">
        <h1>Welcome to Our Blog</h1>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h2>" . $row['text'] . "</h2>";
                echo "<img src='uploads/" . $row['image'] . "' alt=''>";
                echo "</div>";
            }
        } else {
            echo "<p>No admin_users available</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
