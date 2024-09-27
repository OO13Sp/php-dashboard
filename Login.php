<?php
include 'db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // No hashing (consider using hashing for security in production)

    // Check if the username exists
    $checkUserQuery = "SELECT * FROM users WHERE username = ?";
    $stmtCheck = $conn->prepare($checkUserQuery);
    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Directly compare the plain text password
        if ($password === $user['password']) {
            // Passwords match, redirect to the dashboard
            header("Location: /phpcrash/dashboard.php");
            exit(); // Ensure script halts after redirection
        } else {
            // Passwords don't match
            echo "<script>alert('Invalid username or password!');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('Invalid username or password!');</script>";
    }

    // Close the check statement
    $stmtCheck->close();

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white d-flex justify-content-center align-items-center vh-100">
<video autoplay muted loop class="position-fixed w-100 h-100" style="z-index: -1; object-fit: cover;">
    <source src="background.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 bg-light text-dark col-md-4 shadow">
            <h2 class="text-center mb-4">Login</h2>

            <!-- Login Form -->
            <form action="" method="POST"> <!-- Make the action point to the same page -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
