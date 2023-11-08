<!-- Index/booking page -->

<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // Include the header, booking system template, and footer files
    include("../includes/header.inc.php");
    echo "<h1>Profile page</h1>";
    include("../includes/footer.inc.php");
} else {
    header('location:login.php');
}
?>