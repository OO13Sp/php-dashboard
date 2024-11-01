<?php
// UserQueries.php
require_once __DIR__ . '/../dbclass.php';

class UserQueries extends DBclass {

    public function getTotalUsers() {
        $query = "SELECT COUNT(user_id) AS total_users FROM usersmain";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getNewUsers() {
        $query = "SELECT COUNT(user_id) AS new_users FROM usersmain WHERE signup_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
