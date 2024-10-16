<?php
// Fetch total users
function getTotalUsers($conn) {
    $totalUsersQuery = "SELECT COUNT(user_id) AS total_users FROM usersmain";
    $totalUsersResult = $conn->query($totalUsersQuery);
    return $totalUsersResult->fetch_assoc();
}

// Fetch new users in the last month
function getNewUsers($conn) {
    $newUsersQuery = "SELECT COUNT(user_id) AS new_users FROM usersmain WHERE signup_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    $newUsersResult = $conn->query($newUsersQuery);
    return $newUsersResult->fetch_assoc();
}
?>
