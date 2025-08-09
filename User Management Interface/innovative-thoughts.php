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

// Insert New Innovative Thought
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $thought_title = $_POST['thought_title'];
    $submitted_by = $_POST['submitted_by'];
    $submission_date = date('Y-m-d');

    $sql_insert = "INSERT INTO innovative_thoughts (thought_title, submitted_by, submission_date) 
                    VALUES ('$thought_title', '$submitted_by', '$submission_date')";

    if ($conn->query($sql_insert) === TRUE) {
        // Redirect to dashboard after submission
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch Innovative Thoughts
$sql_thoughts = "SELECT thought_title, submitted_by, submission_date FROM innovative_thoughts";
$result_thoughts = $conn->query($sql_thoughts);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovative Thoughts - CEW Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .box {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            background-color: #fff;
        }
        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .container {
            margin-top: 40px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table-bordered th, .table-bordered td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container">
        <h2 class="section-title text-center">Innovative Thoughts</h2>

        <!-- Add New Innovative Thought Form -->
        <div class="box">
            <h4>Add New Innovative Thought</h4>
            <form method="post" action="innovative-thoughts.php">
                <div class="mb-3">
                    <label for="thought_title" class="form-label">Thought Title</label>
                    <input type="text" class="form-control" id="thought_title" name="thought_title" required>
                </div>
                <div class="mb-3">
                    <label for="submitted_by" class="form-label">Submitted By</label>
                    <input type="text" class="form-control" id="submitted_by" name="submitted_by" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <!-- Display Submitted Innovative Thoughts -->
        <div class="box mt-4">
            <h4 class="mb-3">Submitted Innovative Thoughts</h4>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Thought Title</th>
                        <th>Submitted By</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_thoughts->num_rows > 0): ?>
                        <?php $index = 1; ?>
                        <?php while ($row = $result_thoughts->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $index++; ?></td>
                                <td><?php echo htmlspecialchars($row['thought_title']); ?></td>
                                <td><?php echo htmlspecialchars($row['submitted_by']); ?></td>
                                <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No innovative thoughts submitted yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
