<?php
// Database connection
require_once __DIR__ . '/./dbclass.php'; // Ensure your database connection file is included

// Include your class files for queries
require_once __DIR__ . '/SQL_Dashboard/orders_queries.php';
require_once __DIR__ . '/SQL_Dashboard/products_queries.php';
require_once __DIR__ . '/SQL_Dashboard/sales_queries.php';
require_once __DIR__ . '/SQL_Dashboard/users_queries.php';

// Create instances of your query classes (no need to pass $conn)
$sales = new SalesQueries();
$products = new ProductQueries();
$users = new UserQueries();
$orders = new OrderQueries();

// Fetch sales data
$salesData = $sales->getSalesData();
$totalSales = $salesData['total_sales'];
$salesTarget = $salesData['sales_target'];
$grossIncome = $salesData['gross_income'];
$salesPercentage = ($salesTarget > 0) ? ($totalSales / $salesTarget) * 100 : 0;

// Fetch total stock and categories
$totalStock = $products->getTotalStock()['totalStock'];
$totalCategories = $products->getTotalCategories()['totalCategories'];
$stockByCategoryResult = $products->getStockByCategory();

// Fetch user data
$totalUsers = $users->getTotalUsers()['total_users'];
$newUsers = $users->getNewUsers()['new_users'];

// Fetch order data
$totalOrders = $orders->getTotalOrders()['total_orders'];
$recentOrders = $orders->getRecentOrders()['recent_orders'];
// Fetch the top-selling products from the OrderQueries instance
$topSellingProductsResult = $orders->getTopSellingProducts();


// Fetch monthly sales data
$salesByMonthResult = $sales->getSalesByMonth();
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
            border-radius: 10px;
        }

        .progress-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <section class="container">
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
                    <div class="col-12 mb-3">
                        <div class="card text-white" style="height: 100%; background-color: #565656;">
                            <div class="card-body">
                                <h5 class="card-title">Total Stock</h5>
                                <p class="card-text">Total Stock: <?php echo $totalStock; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card text-white" style="height: 100%; background-color: #565656;">
                            <div class="card-body">
                                <h5 class="card-title">Delivery Status</h5>
                                <p class="card-text">Orders On Delivery: <?php echo $totalOrders; ?></p>
                                <p class="card-text">Pending Delivery: 0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card text-white" style="height: 100%; background-color: #565656;">
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

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card text-white" style="height: 100%; background-color: #565656;">
                    <div class="card-body">
                        <h5 class="card-title">User Statistics</h5>
                        <p class="card-text">Total Users: <?php echo $totalUsers; ?></p>
                        <p class="card-text">New Users (Last Month): <?php echo $newUsers; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white" style="height: 100%; background-color: #565656;">
                    <div class="card-body">
                        <h5 class="card-title">Order Overview</h5>
                        <p class="card-text">Total Orders: <?php echo $totalOrders; ?></p>
                        <p class="card-text">Recent Orders (Last 7 Days): <?php echo $recentOrders; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white" style="height: 100%; background-color: #565656;">
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
                // Reset the pointer to fetch month data
                $salesByMonthResult->data_seek(0);
                while ($row = $salesByMonthResult->fetch_assoc()) {
                    echo "'" . $row['month'] . "', ";
                }
                ?>
            ],
            datasets: [{
                label: 'Monthly Sales',
                data: [
                    <?php
                    $salesByMonthResult->data_seek(0); // Reset pointer to fetch data
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
