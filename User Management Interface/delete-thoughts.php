<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cew_network";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete all records from the innovative_thoughts table
$sql_delete = "DELETE FROM innovative-thoughts";

if ($conn->query($sql_delete) === TRUE) {
    echo "All thoughts have been deleted.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
