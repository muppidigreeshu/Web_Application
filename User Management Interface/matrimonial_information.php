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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_name = $_POST['employee_name'];
    $marital_status = $_POST['marital_status'];

    // Insert marital status information
    $sql = "INSERT INTO matrimonial_information (employee_name, marital_status)
            VALUES ('$employee_name', '$marital_status')";

    if ($conn->query($sql) === TRUE) {
        echo "Matrimonial information added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch matrimonial information
$sql = "SELECT employee_name, marital_status FROM matrimonial_information";
$result_matrimonial_info = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimonial Information</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container mt-5">
        <h2 class="text-center">Matrimonial Information</h2>

        <!-- Form to add marital status -->
        <div class="mb-4">
            <h3>Add Matrimonial Information</h3>
            <form action="matrimonial_information.php" method="POST">
                <div class="mb-3">
                    <label for="employee_name" class="form-label">Employee Name</label>
                    <input type="text" class="form-control" id="employee_name" name="employee_name" required>
                </div>
                <div class="mb-3">
                    <label for="marital_status" class="form-label">Marital Status</label>
                    <select class="form-control" id="marital_status" name="marital_status" required>
                        <option value="Married">Married</option>
                        <option value="Unmarried">Unmarried</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Add Information</button>
            </form>
        </div>

        <!-- Display matrimonial information -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Marital Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_matrimonial_info->num_rows > 0): ?>
                    <?php $index = 1; ?>
                    <?php while ($row = $result_matrimonial_info->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $index++; ?></td>
                            <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['marital_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No matrimonial information found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
