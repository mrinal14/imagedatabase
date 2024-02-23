<?php
// upload.php

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

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Upload text and image
    $text = $_POST["text"];
    $image = $_FILES["image"]["name"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Move uploaded file to specified directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert data into database
        $sql = "INSERT INTO admin_users (text, image) VALUES ('$text', '$image')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Delete post
if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $sql = "DELETE FROM admin_users WHERE id = $post_id";
    if ($conn->query($sql) === TRUE) {
        echo "Post deleted successfully";
    } else {
        echo "Error deleting post: " . $conn->error;
    }
}

// Retrieve posts from database
$sql = "SELECT * FROM  admin_users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Page</title>
</head>
<body>
    <h2>Upload a New Post</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        Text: <input type="text" name="text"><br>
        Image: <input type="file" name="image"><br>
        <input type="submit" value="Upload">
    </form>

    <h2>Delete a Post</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <select name="post_id">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['text'] . "</option>";
            }
        }
        ?>
    </select>
    <input type="submit" name="delete_post" value="Delete">
</form>

<?php
// Delete post
if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $sql = "DELETE FROM  admin_users WHERE id = $post_id";
    if ($conn->query($sql) === TRUE) {
        echo "Post deleted successfully";
        // Refresh the page after deleting the post
        echo '<meta http-equiv="refresh" content="0">';
    } else {
        echo "Error deleting post: " . $conn->error;
    }
}
?>
   </select>
        <input type="submit" name="delete_post" value="Delete">
    </form>
</body>
</html>

<?php
$conn->close();
?>
