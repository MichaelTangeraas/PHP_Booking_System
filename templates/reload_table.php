<?php
require_once('../classes/database.php');

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    $conn = new Database($pdo);
    $user = $conn->selectUserFromDBUserId($_SESSION['userID']);
    // Check if the user is a LA
    if ($user->role == 'la') {
        // Reload the weekdays table
        $conn->reloadTables("weekdays");
        header('location:index.php');
    } else {
        // Redirect to the profile page if the user is not a LA
        header('location:profile.php');
    }
} else {
    // User is not logged in and should not have access to this page. Redirect to login page
    header('location:login.php');
}
