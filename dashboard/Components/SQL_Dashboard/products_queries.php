<?php
// ProductQueries.php
require_once __DIR__ . '/../dbclass.php';

class ProductQueries extends DBclass {

    public function getTotalStock() {
        $query = "SELECT SUM(stock) as totalStock FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getTotalCategories() {
        $query = "SELECT COUNT(DISTINCT category) as totalCategories FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getStockByCategory() {
        $query = "SELECT category, SUM(stock) AS totalStock FROM products GROUP BY category";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getLowStockProducts() {
        $query = "SELECT name, stock FROM Products WHERE stock < 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
