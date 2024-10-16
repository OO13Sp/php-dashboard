 
<?php
// Database connection
include 'db.php';

 
// Include SQL query files from the SQL folder
// Use absolute paths because it wasnt working without the DIR
include __DIR__ . '/SQL_Dashboard/sales_queries.php';
include __DIR__ . '/SQL_Dashboard/products_queries.php';
include __DIR__ . '/SQL_Dashboard/users_queries.php';
include __DIR__ . '/SQL_Dashboard/orders_queries.php';



// Fetch sales data
$salesData = getSalesData($conn);
$totalSales = $salesData['total_sales'];
$salesTarget = $salesData['sales_target'];
$grossIncome = $salesData['gross_income'];
$salesPercentage = ($totalSales / $salesTarget) * 100;

// Fetch total stock and categories
$totalStock = getTotalStock($conn)['totalStock'];
$totalCategories = getTotalCategories($conn)['totalCategories'];
$stockByCategoryResult = getStockByCategory($conn);

// Fetch user data
$totalUsers = getTotalUsers($conn)['total_users'];
$newUsers = getNewUsers($conn)['new_users'];

// Fetch order data
$totalOrders = getTotalOrders($conn)['total_orders'];
$recentOrders = getRecentOrders($conn)['recent_orders'];
$topSellingProductsResult = getTopSellingProducts($conn);

// Fetch monthly sales data
$salesByMonthResult = getSalesByMonth($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .progress-container {
            width: 300px;
            height: 300px;
            position: relative;
            margin: 0 auto;
            borderRadius: 10;
        }

        .progress-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
            borderRadius: 10;
        }
    </style>
</head>
<body>
    <section class="container">
        <!-- First row: one large box on the left, two stacked boxes on the right -->
        <div class="row">
            <!-- Large box on the left with circular progress bar -->
            <div class="col-md-6">
                <div class="card text-white mb-3" style="height: 100%; background-color:#565656;">
                    <div class="card-body">
                        <h5 class="card-title">Sales Target Progress</h5>
                        <p class="card-text">Total Sales For Q1 2024: <?php echo $totalSales; ?> / Target: <?php echo $salesTarget; ?></p>
                        <p class="card-text">Gross Income: <?php echo $grossIncome; ?></p>
                        <div class="progress-container">
                            <canvas id="goalProgress"></canvas>
                            <div class="progress-value" id="progressValue"><?php echo round($salesPercentage); ?>%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two small boxes on the right -->
            <div class="col-md-6">
                <div class="row">
                    <!-- First box on the right displaying total stock -->
                    <div class="col-12 mb-3">
                        <div class="card   text-white" style="height: 100%; background-color: #565656;">
                            <div class="card-body">
                                <h5 class="card-title">Total Stock</h5>
                                <p class="card-text">Total Stock: <?php echo $totalStock; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card   text-white" style="height: 100%; background-color: #565656;">
                            <div class="card-body">
                                <h5 class="card-title"> Devliery Status</h5>
                                <p class="card-text"> Orders On Delivery: <?php echo $totalOrders; ?></p>
                                <p class="card-text"> Pending Delivery: 0</p>
                            </div>
                        </div>
                    </div>
                    <!-- Second box on the right displaying stock per category -->
                    <div class="col-12">
                        <div class="card   text-white" style="height: 100%; background-color: #565656;">
                            <div class="card-body">
                                <h5 class="card-title">Stock by Category</h5>
                                <p class="card-text">Total Categories: <?php echo $totalCategories; ?></p>
                                <ul class="card-text">
                                    <?php
                                    // Display the categories and the corresponding total stock
                                    while ($row = $stockByCategoryResult->fetch_assoc()) {
                                        echo "<li>" . $row['category'] . ": " . $row['totalStock'] . " items in stock</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Second row: User stats, order stats, and top-selling products -->
        <div class="row mt-3">
            <!-- Total Users and New Users -->
            <div class="col-md-4">
                <div class="card   text-white" style="height: 100%; background-color: #565656;">
                    <div class="card-body">
                        <h5 class="card-title">User Statistics</h5>
                        <p class="card-text">Total Users: <?php echo $totalUsers; ?></p>
                        <p class="card-text">New Users (Last Month): <?php echo $newUsers; ?></p>
                    </div>
                </div>
            </div>
            <!-- Total and Recent Orders -->
            <div class="col-md-4">
                <div class="card   text-white" style="height: 100%; background-color: #565656;">
                    <div class="card-body">
                        <h5 class="card-title">Order Overview</h5>
                        <p class="card-text">Total Orders: <?php echo $totalOrders; ?></p>
                        <p class="card-text">Recent Orders (Last 7 Days): <?php echo $recentOrders; ?></p>
                    </div>
                </div>
            </div>
            <!-- Top-Selling Products -->
            <div class="col-md-4">
                <div class="card   text-white" style="height: 100%; background-color: #565656;">
                    <div class="card-body">
                        <h5 class="card-title">Top-Selling Products</h5>
                        <ul class="card-text">
                            <?php
                            // Display the top-selling products
                            while ($row = $topSellingProductsResult->fetch_assoc()) {
                                echo "<li>" . $row['name'] . ": " . $row['total_sold'] . " sold</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

       
      
    </section>

    <script>
        // Circular progress chart for sales target progress
        const ctx = document.getElementById('goalProgress').getContext('2d');
        const goalProgress = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [<?php echo round($salesPercentage); ?>, <?php echo 100 - round($salesPercentage); ?>],
                    backgroundColor: ['#4caf50', '#c0c0c0'],
                    borderWidth: 0,
                    borderRadius: 10
                }]
            },
            options: {
                cutout: '75%',
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Sales trends chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesData = {
            labels: [
                <?php
                while ($row = $salesByMonthResult->fetch_assoc()) {
                    echo "'" . $row['month'] . "', ";
                }
                ?>
            ],
            datasets: [{
                label: 'Monthly Sales',
                data: [
                    <?php
                    $salesByMonthResult->data_seek(0);
                    while ($row = $salesByMonthResult->fetch_assoc()) {
                        echo $row['total_sales'] . ", ";
                    }
                    ?>
                ],
                backgroundColor: '#4caf50',
                borderColor: '#4caf50',
                fill: false
            }]
        };
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: salesData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
