<!-- Index/booking page -->

<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // Include the header, booking system template, and footer files
    include("../includes/header.inc.php");
    include("../templates/edit_password.php");
    include("../includes/footer.inc.php");
} else {
    header('location:login.php');
}
?>