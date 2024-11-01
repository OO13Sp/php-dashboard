<?php
// SalesQueries.php
require_once __DIR__ . '/../dbclass.php';

class SalesQueries extends DBclass {

    public function getSalesData() {
        $query = "SELECT total_sales, sales_target, gross_income FROM Sales ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getSalesByMonth() {
        $query = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, SUM(total_price) AS total_sales FROM Orders GROUP BY month ORDER BY month DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
