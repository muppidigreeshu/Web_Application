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

// Handle the form submission for adding a new discussion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic = $_POST['topic'];
    $description = $_POST['description'];
    $posted_by = $_POST['posted_by']; // Assuming the user submits their name or user ID
    $date_posted = date('Y-m-d H:i:s'); // Current date and time

    // Insert the new discussion into the database
    $sql = "INSERT INTO technical_discussions (topic, description, posted_by, date_posted)
            VALUES ('$topic', '$description', '$posted_by', '$date_posted')";

    if ($conn->query($sql) === TRUE) {
        echo "New discussion added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all technical discussions
$sql = "SELECT topic, description, posted_by, date_posted FROM technical_discussions";
$result_discussions = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Discussions</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container mt-5">
        <h2 class="text-center">Technical Discussions</h2>
        <a href="add-discussion.php" class="btn btn-primary mb-3">Add New Discussion</a>

        <!-- Form to add a new discussion -->
        <div class="mb-4">
            <h3>Add New Discussion</h3>
            <form action="technical-discussions.php" method="POST">
                <div class="mb-3">
                    <label for="topic" class="form-label">Topic</label>
                    <input type="text" class="form-control" id="topic" name="topic" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="posted_by" class="form-label">Posted By</label>
                    <input type="text" class="form-control" id="posted_by" name="posted_by" required>
                </div>
                <button type="submit" class="btn btn-success">Add Discussion</button>
            </form>
        </div>

        <!-- Display the technical discussions -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Topic</th>
                    <th>Description</th>
                    <th>Posted By</th>
                    <th>Post Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_discussions->num_rows > 0): ?>
                    <?php $index = 1; ?>
                    <?php while ($row = $result_discussions->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $index++; ?></td>
                            <td><?php echo htmlspecialchars($row['topic']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['posted_by']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_posted']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No technical discussions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                    