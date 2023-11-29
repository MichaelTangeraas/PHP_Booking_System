<!-- Update password page -->

<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // Include the header, edit password content, and footer files
    include("../includes/header.inc.php");
    include("../templates/edit_password.php");
    include("../includes/footer.inc.php");
} else {
    // Redirect to the login page if the user is not logged in
    header('location:login.php');
}
?>