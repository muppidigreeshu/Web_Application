<?php include('header.php'); ?>

<div class="container mt-5 pt-5">
    <h1 class="text-center">Company Growth Overview</h1>
    <canvas id="growthChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example data for Company Growth
    const years = ['2018', '2019', '2020', '2021', '2022'];
    const revenues = [500, 600, 800, 1200, 1500]; // Replace with actual data

    const ctx = document.getElementById('growthChart').getContext('2d');
    const growthChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: years,
            datasets: [{
                label: 'Company Revenue (in millions)',
                data: revenues,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        }
    });
</script>
<link rel="stylesheet" href="assets/styles.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
