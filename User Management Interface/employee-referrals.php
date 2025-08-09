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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the submitted form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $referral_details = $_POST['referral_details'];

    // Insert the new referral into the database
    $sql = "INSERT INTO employee_referrals (name, email, referral_details) 
            VALUES ('$name', '$email', '$referral_details')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the dashboard after successful submission
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Fetch Total Referrals
$sql_referrals = "SELECT COUNT(*) AS total FROM employee_referrals";
$result_referrals = $conn->query($sql_referrals);
$totalReferrals = 0;
if ($result_referrals->num_rows > 0) {
    $row = $result_referrals->fetch_assoc();
    $totalReferrals = $row['total'];
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Referral</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "header.php"; ?>
    
    <div class="container mt-5">
        <h2>Add New Employee Referral</h2>
        <form method="POST" action="employee-referrals.php">
            <div class="mb-3">
                <label for="name" class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Employee Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="referral_details" class="form-label">Referral Details</label>
                <textarea class="form-control" id="referral_details" name="referral_details" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Referral</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
