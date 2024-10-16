<?php
// Fetch total orders
function getTotalOrders($conn) {
    $totalOrdersQuery = "SELECT COUNT(order_id) AS total_orders FROM Orders";
    $totalOrdersResult = $conn->query($totalOrdersQuery);
    return $totalOrdersResult->fetch_assoc();
}

// Fetch recent orders (last 7 days)
function getRecentOrders($conn) {
    $recentOrdersQuery = "SELECT COUNT(order_id) AS recent_orders FROM Orders WHERE order_date > DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $recentOrdersResult = $conn->query($recentOrdersQuery);
    return $recentOrdersResult->fetch_assoc();
}

// Fetch top-selling products
function getTopSellingProducts($conn) {
    $topSellingProductsQuery = "
        SELECT P.name, SUM(OI.quantity) AS total_sold 
        FROM Order_Items OI
        JOIN Products P ON OI.product_id = P.product_id
        GROUP BY OI.product_id
        ORDER BY total_sold DESC LIMIT 5";
    $topSellingProductsResult = $conn->query($topSellingProductsQuery);
    return $topSellingProductsResult;
}
?>
