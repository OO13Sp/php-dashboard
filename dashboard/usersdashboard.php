<?php
// Include the database connection
include 'components/db.php'; // Ensure the path is correct

// Handle Edit and Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit_user'])) {
        // Handle Edit User
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Update user data
        $updateQuery = "UPDATE usersmain SET name = ?, email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ssi', $name, $email, $user_id);
        $stmt->execute();

        header('Location: usersdashboard.php');
        exit();
    } elseif (isset($_POST['delete_user'])) {
        // Handle Delete User
        $user_id = $_POST['user_id'];

        $deleteQuery = "DELETE FROM usersmain WHERE user_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        header('Location: usersdashboard.php');
        exit();
    }
}

// Fetch users from the database
$query = "SELECT user_id, name, email, signup_date FROM usersmain"; // Updated column name
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-white mb-4">User Management</h2>
    
    <!-- User table -->
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th> <!-- Updated column header -->
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td> <!-- Updated column name -->
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= $row['signup_date']; ?></td>
                        <td>
                            <!-- Edit Form -->
                            <form action="usersdashboard.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="user_id" value="<?= $row['user_id']; ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($row['name']); ?>" required> <!-- Updated column name -->
                                <input type="email" name="email" value="<?= htmlspecialchars($row['email']); ?>" required>
                                <button type="submit" name="edit_user" class="btn btn-warning btn-sm">Edit</button>
                            </form>
                            
                            <!-- Delete Form -->
                            <form action="usersdashboard.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="user_id" value="<?= $row['user_id']; ?>">
                                <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
