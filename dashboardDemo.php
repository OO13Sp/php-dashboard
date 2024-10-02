<?php
include 'db.php'; // Include your database connection

// Handle delete request
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Update query to use userID instead of id
    $deleteQuery = "DELETE FROM users WHERE userID = ?";
    $stmtDelete = $conn->prepare($deleteQuery);
    $stmtDelete->bind_param("i", $deleteId);
    $stmtDelete->execute();
    $stmtDelete->close();

    echo "<script>alert('User deleted successfully!');</script>";
    header("Location: dashboard.php"); // Redirect to dashboard after deletion
}

// Handle edit request
if (isset($_POST['edit_id'])) {
    $editId = $_POST['edit_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // For simplicity, no hashing

    // Update query to use userID instead of id
    $updateQuery = "UPDATE users SET username = ?, email = ?, password = ? WHERE userID = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("sssi", $username, $email, $password, $editId);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    echo "<script>alert('User updated successfully!');</script>";
    header("Location: dashboard.php"); // Redirect after update
}

// Fetch all users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4">User Dashboard</h1>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each user and display their details
                if ($result->num_rows > 0) {
                    while ($user = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $user['userID'] . "</td>";
                        echo "<td>" . $user['username'] . "</td>";
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action='' class='d-inline'>";
                        echo "<input type='hidden' name='edit_id' value='" . $user['userID'] . "'>";
                        echo "<input type='text' name='username' value='" . $user['username'] . "' required>";
                        echo "<input type='email' name='email' value='" . $user['email'] . "' required>";
                        echo "<input type='password' name='password' placeholder='New Password' required>";
                        echo "<button type='submit' class='btn btn-warning btn-sm'>Save</button>";
                        echo "</form> ";
                        echo "<a href='?delete_id=" . $user['userID'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No users found</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
