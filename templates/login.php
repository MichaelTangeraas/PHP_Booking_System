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
    <h1>Logg inn</h1>
    <p>Logg inn på kontoen din</p>
    <form action="login.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Passord:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Logg inn" name="login">
    </form>
    <p>Har du ikke en konto? <a href="sign_up.php">Opprett en bruker</a></p>

    <?php
    // Check if login form is submitted
    if (isset($_POST['login'])) {

        // Check if email or password field is not empty
        if ($_POST['email'] != "" || $_POST['password'] != "") {

            // Get email from form
            $email = $_POST['email'];

            // Get password from form
            $password = $_POST['password'];

            $pdo = new Database($pdo);

            $user = $pdo->selectUserFromDBEmail($email);

            // Check if user exists
            if ($user != null) {

                // Verify the password
                if (password_verify($password, $user->password)) {

                    // Correct password
                    echo "Riktig passord";

                    // Start a new session
                    session_start();

                    // Store user ID in session
                    $_SESSION['userID'] = $user->userID;

                    // Redirect to index.php
                    header('location: index.php');
                } else {

                    // Incorrect password
                    echo "Feil email eller passord";
                }
            } else {

                // Incorrect username or password
                echo "Feil email eller passord";

                // Redirect to login.php
                // header('location: login.php');
            }
        } else {

            // Required field is empty
            echo "Vennligst fyll ut alle skjemafelt!<br>";

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