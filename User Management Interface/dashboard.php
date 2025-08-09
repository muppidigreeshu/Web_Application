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

// Fetch Total Employees Registered
$sql_employees = "SELECT COUNT(*) AS total FROM employees";
$result_employees = $conn->query($sql_employees);
$totalEmployees = 0;
if ($result_employees->num_rows > 0) {
    $row = $result_employees->fetch_assoc();
    $totalEmployees = $row['total'];
}

// Fetch Employee Details
$sql_employee_details = "SELECT employee_name, email FROM employees";
$result_employee_details = $conn->query($sql_employee_details);


// Fetch Total Referrals
$sql_referrals = "SELECT COUNT(*) AS total FROM employee_referrals";
$result_referrals = $conn->query($sql_referrals);
$totalReferrals = 0;
if ($result_referrals->num_rows > 0) {
    $row = $result_referrals->fetch_assoc();
    $totalReferrals = $row['total'];
}

// Fetch Referral Details (name, email, details, and submission date)
$sql_referral_details = "SELECT name, email, referral_details, submission_date FROM employee_referrals";
$result_referral_details = $conn->query($sql_referral_details);

// Fetch Innovative Thoughts
$sql_thoughts = "SELECT thought_title, submitted_by, submission_date FROM innovative_thoughts ORDER BY submission_date DESC";
$result_thoughts = $conn->query($sql_thoughts);

// Fetch Upcoming Events
$sql_events = "SELECT event_name, event_date FROM events ORDER BY event_date ASC";
$result_events = $conn->query($sql_events);

// Fetch Company Growth Data
$sql_growth = "SELECT year, revenue FROM company_growth ORDER BY year ASC";
$result_growth = $conn->query($sql_growth);

$years = [];
$revenues = [];
if ($result_growth->num_rows > 0) {
    while ($row = $result_growth->fetch_assoc()) {
        $years[] = $row['year'];
        $revenues[] = $row['revenue'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEW Network - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .chart-container {
            position: relative;
            height: 400px; /* Fixed height */
            max-width: 100%; /* Responsive width */
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
        .empty-data {
            text-align: center;
            color: #888;
            font-size: 1.2rem;
            padding: 10px 0;
        }
    </style>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include "header.php"; ?>

    <div class="container">
        <h2 class="section-title text-center">Admin Dashboard</h2>

        <!-- First Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="box text-center">
                    <h4 class="mb-3">Total Employees Registered</h4>
                    <!-- Button to open employee modal -->
                    <button class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#employeeModal">
                        Count: <?php echo $totalEmployees; ?>
                    </button>
                </div>
                <div class="box text-center">
                    <h4 class="mb-3">Employee Referrals</h4>
                    <!-- Button to open referral modal -->
                    <button class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#referralModal">
                        Count: <?php echo $totalReferrals; ?>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box text-center">
                    <h4 class="mb-3">Upcoming Events</h4>
                    <a href="events.php" class="btn btn-primary mb-3">Add New Event</a>
                    <?php if ($result_events->num_rows > 0): ?>
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Event Name</th>
                                    <th>Event Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = 1; ?>
                                <?php while ($row = $result_events->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $index++; ?></td>
                                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                                        <td><?php echo date('F d, Y', strtotime(htmlspecialchars($row['event_date']))); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-data">No upcoming events scheduled yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Employee Modal -->
        <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeModalLabel">Registered Employees</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($result_employee_details->num_rows > 0): ?>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Employee Name</th>
                                        <th>Email ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php while ($row = $result_employee_details->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $index++; ?></td>
                                            <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="empty-data">No employees registered yet.</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral Modal -->
        <div class="modal fade" id="referralModal" tabindex="-1" aria-labelledby="referralModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="referralModalLabel">Employee Referrals</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($result_referral_details->num_rows > 0): ?>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Referral Details</th>
                                        <th>Submission Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 1; ?>
                                    <?php while ($row = $result_referral_details->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $index++; ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['referral_details']); ?></td>
                                            <td><?php echo date('F d, Y', strtotime($row['submission_date'])); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="empty-data">No referrals submitted yet.</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="box">
                    <h4 class="mb-3">Company Growth</h4>
                    <div class="chart-container">
                        <?php if (!empty($years) && !empty($revenues)): ?>
                            <canvas id="growthChart"></canvas>
                        <?php else: ?>
                            <div class="empty-data">No growth data available.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <h4 class="mb-3">Innovative Thoughts</h4>
                    <a href="innovative-thoughts.php" class="btn btn-primary mb-3">Add New Innovative Thought</a>
                    <?php if ($result_thoughts->num_rows > 0): ?>
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
                                <?php $index = 1; ?>
                                <?php while ($row = $result_thoughts->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $index++; ?></td>
                                        <td><?php echo htmlspecialchars($row['thought_title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['submitted_by']); ?></td>
                                        <td><?php echo date('F d, Y', strtotime($row['submission_date'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-data">No innovative thoughts submitted yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Growth chart
        var ctx = document.getElementById('growthChart').getContext('2d');
        var growthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($years); ?>,
                datasets: [{
                    label: 'Company Growth (Revenue)',
                    data: <?php echo json_encode($revenues); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Year'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Revenue'
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
