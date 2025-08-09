<?php
// property_rentals.php

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "your_database_name"; // Change this to your DB name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $property_name = $_POST['property_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $rent_price = $_POST['rent_price'] ?? '';

    if (!empty($property_name) && !empty($address) && !empty($rent_price)) {
        $stmt = $conn->prepare("INSERT INTO properties (property_name, address, rent_price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $property_name, $address, $rent_price);

        if ($stmt->execute()) {
            $message = "✅ Property added successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "⚠ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Property Rentals</title>
</head>
<body>
    <h1>Add Property</h1>

    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="property_rentals.php">
        <label>Property Name:</label><br>
        <input type="text" name="property_name" required><br><br>

        <label>Address:</label><br>
        <textarea name="address" required></textarea><br><br>

        <label>Rent Price:</label><br>
        <input type="number" step="0.01" name="rent_price" required><br><br>

        <button type="submit">Add Property</button>
    </form>
</body>
</html>
