<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    // User is already logged in and doesn't need access to login page, redriect to index.php
    header('location: index.php');
} else {
    // User is not logged in and needs access to login page
    include("../includes/header.inc.php");
    include("../templates/login.php");
    include("../includes/footer.inc.php");
}
