<?php
include_once('../includes/db.inc.php');
include_once('../classes/database.php');

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // User is logged in and can now delete their user account
    $conn = new Database($pdo);
    $conn->deleteUserBookingsInDB($_SESSION['userID']);
    $conn->deleteFromDB($_SESSION['userID']);
    header('location:logout.php');
} else {
    // User is not logged in and should not have access to this page. Redirect to login page
    header('location:login.php');
}
