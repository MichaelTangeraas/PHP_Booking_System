<?php
require_once('../classes/database.php');

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // User is logged in and can now delete their user account
    $conn = new Database($pdo);
    $user = $conn->selectUserFromDBUserId($_SESSION['userID']);
    if ($user->role == 'la') {
        // If the user is a learning assistant, delete all bookings made by the user
        $conn->deleteAllLaBookingsInDB($_SESSION['userID']);
    } else {
        // If the user is a student, delete all bookings made by the user
        $conn->deleteAllStudentBookingsInDB($_SESSION['userID']);
    }
    // Delete the user from the database
    $conn->deleteUserFromDB($_SESSION['userID']);
    // Destroy the session and redirect to the login page
    header('location:logout.php');
} else {
    // User is not logged in and should not have access to this page. Redirect to login page
    header('location:login.php');
}
