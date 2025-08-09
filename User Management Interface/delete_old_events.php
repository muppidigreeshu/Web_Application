<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cew_network";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to delete past events
$sql = "DELETE FROM events WHERE event_date < CURDATE()";

if ($conn->query($sql) === TRUE) {
    echo "Old events deleted successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
