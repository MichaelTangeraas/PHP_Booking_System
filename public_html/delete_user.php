

<?php
include_once('../includes/db.inc.php');
include_once('../classes/database.php');

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    $pdo = new Database($pdo);
    $pdo->deleteFromDB($_SESSION['userID']);
    header('location:logout.php');
} else {
    header('location:login.php');
}
