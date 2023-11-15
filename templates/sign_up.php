<?php
// Start a new session
// session_start();

// Include the database connection file
require_once('../includes/db.inc.php');
include_once('../classes/database.php');

// Check if the 'register' button has been clicked
if (isset($_POST['register'])) {

    // Check if the email and password fields are not empty
    if ($_POST['fname'] != "" || $_POST['lname'] != "" || $_POST['email'] != "" || $_POST['password'] != "") {

        // Get the first name from the form
        $fname = $_POST['fname'];

        // Get the last name from the form
        $lname = $_POST['lname'];

        // Get the email from the form
        $email = $_POST['email'];

        // Hash the password using PHP's built-in password_hash function
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $insert = new Database($pdo);
        $insert->insertToDB($fname, $lname, $email, $password);

        // Redirect the user to index.php
        header('location:index.php');
    } else {
        // Print a message if the fields are empty and redirect the user to the registration page
        echo "Please fill up the required field!";
        header('location:sign_up.php');
    }
}
?>

<!-- HTML form for user registration -->
<div class="center">
    <h1>Registrering</h1>
    <p>Opprett din bruker her</p>
    <form action="sign_up.php" method="post">
        <label for="fname">Fornavn:</label><br>
        <input type="fname" id="fname" name="fname" required oninvalid="this.setCustomValidity('Vennligst fyll inn et fornavn.')" oninput="this.setCustomValidity('')"><br>
        <label for="lname">Etternavn:</label><br>
        <input type="lname" id="lname" name="lname" required oninvalid="this.setCustomValidity('Vennligst fyll inn et etternavn')" oninput="this.setCustomValidity('')"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required oninvalid="this.setCustomValidity('Vennligst fyll inn en email.')" oninput="this.setCustomValidity('')"><br>
        <label for="password">Passord:</label><br>
        <input type="password" id="password" name="password" required oninvalid="this.setCustomValidity('Vennligst fyll inn et passord.')" oninput="this.setCustomValidity('')"><br>
        <input type="submit" value="Registrer" name="register">
    </form>
    <p>Har du allerede en bruker? <a href="login.php">Logg inn</a></p>
</div>