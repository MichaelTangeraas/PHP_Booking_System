<!-- Index/booking page -->

<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {

    include_once('../classes/database.php');

    $conn = new Database($pdo);
    $user = $conn->selectUserFromDBUserId($_SESSION['userID']);
    $conn->closeDB($conn);

    // Include the header
    include("../includes/header.inc.php");
    // Check what type of content should be displayed based on user role
    if ($user->role == "la") {
        // Include the booking system for LA's
        include("../templates/la_booking_system.php");
    } else {
        // Include the booking system for students
        include("../templates/booking_system.php");
    }
    // Include the footer
    include("../includes/footer.inc.php");
} else {
    // If the user is not logged in, redirect to the login page
    header('location:login.php');
}
?>