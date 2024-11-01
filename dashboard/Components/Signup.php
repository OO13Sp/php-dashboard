<?php
include 'db.php'; // Include the database connection
include 'User.php'; // Include the User class

// Create a User object
$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Call the signup method from the User class
    $signupResult = $user->signup($email, $name, $password);

    if ($signupResult === "User registered successfully!") {
        // Signup successful, redirect to login page
        header("Location: login.php");
        exit();
    } else {
        // Show error message
        $error = $signupResult;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white d-flex justify-content-center align-items-center vh-100">

    <!-- Background video -->
    <video autoplay muted loop class="position-fixed w-100 h-100" style="z-index: -1; object-fit: cover;">
        <source src="background.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Signup Form -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 bg-light text-dark col-md-4 shadow">
            <h2 class="text-center mb-4">Sign Up</h2>

            <!-- Display error message if any -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Signup Form -->
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                <p class="text-center mt-3">Already have an account? <a href="login
