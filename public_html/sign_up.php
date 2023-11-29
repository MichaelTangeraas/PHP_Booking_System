<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // User is already logged in and doesn't need access to sign up page
    header('location: index.php');
} else {
    // User is not logged in and needs access to sign up page
    include("../includes/header.inc.php");
    include("../templates/sign_up.php");
    include("../includes/footer.inc.php");
}
