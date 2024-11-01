<?php
class User {
    private $conn;

    // Constructor to receive the MySQLi connection object
    public function __construct($db) {
        $this->conn = $db;
    }

    // Signup method
    public function signup($email, $name, $password) {
        // Check if the user already exists
        $checkUserQuery = "SELECT * FROM usersmain WHERE email = ? OR name = ?";
        $stmt = $this->conn->prepare($checkUserQuery);
        $stmt->bind_param("ss", $email, $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return "User with this email or username already exists!";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Insert new user into the database
            $sql = "INSERT INTO usersmain (email, name, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $email, $name, $hashedPassword);

            if ($stmt->execute()) {
                return "User registered successfully!";
            } else {
                return "Error: " . $this->conn->error;
            }
        }
    }

    // Login method
    public function login($name, $password) {
        // Check if the user exists
        $checkUserQuery = "SELECT * FROM usersmain WHERE name = ?";
        $stmt = $this->conn->prepare($checkUserQuery);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['password'])) {
                return true; // Login successful
            } else {
                return "Password is incorrect!";
            }
        } else {
            return "Username is incorrect!";
        }
    }
}
?>
