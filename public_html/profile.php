<!-- Index/booking page -->

<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // Include the header, profile content and footer files
    include("../includes/header.inc.php");
    include("../templates/profile.php");
    include("../includes/footer.inc.php");
} else {
    // Redirect to the login page if the user is not logged in
    header('location:login.php');
}
?>