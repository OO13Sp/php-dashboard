<?php
// Include the database connection
include 'components/db.php'; // Ensure the path is correct

// Fetch the number of accounts created per month
$monthlyAccountsQuery = "SELECT DATE_FORMAT(signup_date, '%Y-%m') AS month, COUNT(*) AS count FROM usersmain GROUP BY month";
$monthlyAccountsResult = $conn->query($monthlyAccountsQuery);

// Fetch the number of orders made per month
$monthlyOrdersQuery = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, COUNT(*) AS count FROM Orders GROUP BY month ORDER BY month";
$monthlyOrdersResult = $conn->query($monthlyOrdersQuery);

// Fetch total sales for each month from the Sales table
$salesQuery = "SELECT reporting_period, SUM(total_sales) AS total_sales, SUM(gross_income) AS gross_income FROM Sales GROUP BY reporting_period";
$salesResult = $conn->query($salesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-color: #1E1E1E;">
<div class="container mt-5">
    <h2 class="text-white mb-4">Reports Dashboard</h2>

    <div class="row">
        <!-- Card for Monthly Accounts Created -->
        <div class="col-md-6">
            <div class="card bg-dark text-white mb-4">
                <div class="card-header">Accounts Created per Month</div>
                <div class="card-body">
                    <canvas id="accountsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Card for Monthly Orders Line Chart -->
        <div class="col-md-6">
            <div class="card bg-dark text-white mb-4">
                <div class="card-header">Orders Made per Month</div>
                <div class="card-body">
                    <canvas id="monthlyOrdersLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Sales Data -->
    <h3 class="text-white mt-5">Sales Data</h3>
    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>Reporting Period</th>
                <th>Total Sales</th>
                <th>Gross Income</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($salesResult->num_rows > 0): ?>
                <?php while ($row = $salesResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['reporting_period']); ?></td>
                        <td><?= htmlspecialchars($row['total_sales']); ?></td>
                        <td><?= htmlspecialchars($row['gross_income']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No sales data found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js Scripts -->
<script>
    // Bar Chart for Monthly Accounts Created
    const ctx = document.getElementById('accountsChart').getContext('2d');
    const accountsLabels = [];
    const accountsData = [];

    <?php if ($monthlyAccountsResult->num_rows > 0): ?>
        <?php while ($row = $monthlyAccountsResult->fetch_assoc()): ?>
            accountsLabels.push('<?= $row['month']; ?>');
            accountsData.push(<?= $row['count']; ?>);
        <?php endwhile; ?>
    <?php endif; ?>

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: accountsLabels,
            datasets: [{
                label: 'Accounts Created',
                data: accountsData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Line Chart for Monthly Orders Trend
    const monthlyOrdersCtx = document.getElementById('monthlyOrdersLineChart').getContext('2d');
    const monthlyOrdersLabels = [];
    const monthlyOrdersData = [];

    <?php if ($monthlyOrdersResult->num_rows > 0): ?>
        <?php while ($row = $monthlyOrdersResult->fetch_assoc()): ?>
            monthlyOrdersLabels.push('<?= $row['month']; ?>');
            monthlyOrdersData.push(<?= $row['count']; ?>);
        <?php endwhile; ?>
    <?php endif; ?>

    new Chart(monthlyOrdersCtx, {
        type: 'line',
        data: {
            labels: monthlyOrdersLabels,
            datasets: [{
                label: 'Orders Made',
                data: monthlyOrdersData,
                borderColor: 'rgba(255, 99, 132, 1)', // Line color
                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Fill color
                borderWidth: 2,
                fill: true // Fill area under the line
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Monthly Orders Trend'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Months'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Orders'
                    }
                }
            }
        }
    });

</script>
</body>
</html>
