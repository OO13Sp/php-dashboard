<?php
// Fetch total sales, gross income, and sales target
function getSalesData($conn) {
    $salesQuery = "SELECT total_sales, sales_target, gross_income FROM Sales ORDER BY created_at DESC LIMIT 1";
    $salesResult = $conn->query($salesQuery);
    return $salesResult->fetch_assoc();
}

function getSalesByMonth($conn) {
    $salesByMonthQuery = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, SUM(total_price) AS total_sales FROM Orders GROUP BY month ORDER BY month DESC";
    $salesByMonthResult = $conn->query($salesByMonthQuery);
    return $salesByMonthResult;
}
?>
