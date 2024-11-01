<?php
// DBclass.php - Database connection class
class DBclass {
    protected $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = ""; // default password for XAMPP
        $dbname = "crud";

        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>
