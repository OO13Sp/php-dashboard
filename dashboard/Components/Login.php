<?php
include 'db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Check if the username exists
    $checkUserQuery = "SELECT * FROM usersmain WHERE name = ?";
    $stmtCheck = $conn->prepare($checkUserQuery);
    $stmtCheck->bind_param("s", $name);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        // Username exists, fetch user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, redirect to dashboard
            header("Location: /phpcrash/dashboard/dashboard.php");
            exit(); // Ensure script halts after redirection
        } else {
            // Password is incorrect
            $error = "Password is incorrect!";
        }
    } else {
        // Username is incorrect
        $error = "Username is incorrect!";
    }

    // Close the statement
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

    <!-- Background video -->
    <video autoplay muted loop class="position-fixed w-100 h-100" style="z-index: -1; object-fit: cover;">
        <source src="background.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 bg-light text-dark col-md-4 shadow">
            <h2 class="text-center mb-4">Login</h2>

            <!-- Display error message if any -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="" method="POST"> <!-- Make the action point to the same page -->
                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" name="name" id="name" class="form-control" required>
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
