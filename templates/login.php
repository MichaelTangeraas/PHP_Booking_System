<?php
include("../classes/database.php");
require_once('../includes/db.inc.php');

if (isset($_POST['reset'])) {
    $reload = new Database($pdo);
    $reload->reloadTables("booking_users");
    echo "Kjører";
}

?>

<div class="center">
    <h1>Log in</h1>
    <p>Log in to your account</p>
    <form action="login.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login" name="login">
    </form>
    <p>Don't have an account? <a href="sign_up.php">Sign up</a></p>

    <?php
    // Check if login form is submitted
    if (isset($_POST['login'])) {

        // Check if email or password field is not empty
        if ($_POST['email'] != "" || $_POST['password'] != "") {

            // Get email from form
            $email = $_POST['email'];

            // Get password from form
            $password = $_POST['password'];

            // SQL query to get user with the given email
            $sql = "SELECT * FROM `booking_users` WHERE `email`='$email'";

            // Prepare the SQL query
            $query = $pdo->prepare($sql);

            // Execute the SQL query
            $query->execute();

            // Fetch the user data
            $booking_users = $query->fetch(PDO::FETCH_OBJ);

            // Check if user exists
            if ($query->rowCount() > 0) {

                // Verify the password
                if (password_verify($password, $booking_users->password)) {

                    // Correct password
                    echo "Riktig passord";

                    // Start a new session
                    session_start();

                    // Store user ID in session
                    $_SESSION['userID'] = $booking_users->userID;

                    // Redirect to index.php
                    header('location: index.php');
                } else {

                    // Incorrect password
                    echo "Feil passord";
                }
            } else {

                // Incorrect username or password
                echo "Feil brukernavn eller passord";

                // Redirect to login.php
                // header('location: login.php');
            }
        } else {

            // Required field is empty
            echo "Please complete the required field!";

            // Redirect to login.php
            // header('location: login.php');
        }
    }

    if (isset($_POST['reset'])) {
        $reload = new Database($pdo);
        $reload->reloadTables("booking_users");
        echo "Kjører";
    }

    ?>
</div>

<form action="login.php" method="post">
    <input type="submit" value="Reset" name="reset">
</form>