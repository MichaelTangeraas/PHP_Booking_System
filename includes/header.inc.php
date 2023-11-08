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
            <?php if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
                echo ("<li><a href='index.php'>Home</a></li>");
            }

            if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
                echo ("<li><a href='profile.php'>Profile</a></li>");
            } else {
                echo ("<li><a href='sign_up.php'>Sign Up</a></li>");
            }

            if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
                echo ("<li><a href='../templates/logout.php'>Log out</a></li>");
            } else {
                echo ("<li><a href='login.php'>Log in</a></li>");
            }

            ?>
        </ul>
    </div>