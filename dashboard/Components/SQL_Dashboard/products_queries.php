<?php
// Fetch total number of products
function getTotalStock($conn) {
    $totalProductsQuery = "SELECT SUM(stock) as totalStock FROM products";
    $totalProductsResult = $conn->query($totalProductsQuery);
    return $totalProductsResult->fetch_assoc();
}

// Fetch the number of distinct categories
function getTotalCategories($conn) {
    $totalCategoriesQuery = "SELECT COUNT(DISTINCT category) as totalCategories FROM products";
    $totalCategoriesResult = $conn->query($totalCategoriesQuery);
    return $totalCategoriesResult->fetch_assoc();
}

// Fetch total stock per category
function getStockByCategory($conn) {
    $stockByCategoryQuery = "SELECT category, SUM(stock) AS totalStock FROM products GROUP BY category";
    $stockByCategoryResult = $conn->query($stockByCategoryQuery);
    return $stockByCategoryResult;
}

// Fetch low stock products
function getLowStockProducts($conn) {
    $lowStockQuery = "SELECT name, stock FROM Products WHERE stock < 10";
    $lowStockResult = $conn->query($lowStockQuery);
    return $lowStockResult;
}
?>
