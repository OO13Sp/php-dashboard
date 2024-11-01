<?php
// OrderQueries.php
require_once __DIR__ . '/../dbclass.php';

class OrderQueries extends DBclass {

    public function getTotalOrders() {
        $query = "SELECT COUNT(order_id) AS total_orders FROM Orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getRecentOrders() {
        $query = "SELECT COUNT(order_id) AS recent_orders FROM Orders WHERE order_date > DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getTopSellingProducts() {
        $query = "
            SELECT P.name, SUM(OI.quantity) AS total_sold 
            FROM Order_Items OI
            JOIN Products P ON OI.product_id = P.product_id
            GROUP BY OI.product_id
            ORDER BY total_sold DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
