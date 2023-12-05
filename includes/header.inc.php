<!-- Website header -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>PHP Booking System</title>
</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="index.php">PHP Booking System</a>
        </div>
        <ul class="navbar">
            <?php
            // If the user is logged in, show the home button
            if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
                echo ("<li><a href='index.php'>Hjem</a></li>");
            }
            // If the user is logged in, show the profile button, or else show the sign up button
            if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
                echo ("<li><a href='profile.php'>Din profil</a></li>");
            } else {
                echo ("<li><a href='sign_up.php'>Registrering</a></li>");
            }
            // If the user is logged in, show the log out button, or else show the log in button
            if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
                echo ("<li><a href='../public_html/logout.php'>Logg ut</a></li>");
            } else {
                echo ("<li><a href='login.php'>Logg inn</a></li>");
            }
            ?>
        </ul>
    </div>