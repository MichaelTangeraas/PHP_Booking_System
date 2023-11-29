<?php
// Include the database connection file
require_once('../includes/db.inc.php');
include_once('../classes/database.php');
require_once('../classes/inputvalidator.php');

// Check if the 'register' button has been clicked
if (isset($_POST['register'])) {

    // Check if the email and password fields are not empty
    if ($_POST['fname'] != "" || $_POST['lname'] != "" || $_POST['email'] != "" || $_POST['password'] != "") {
        $validator = new InputValidator();
        $inputError = false;

        // Get the first name from the form and clean the string
        if ($validator->nameValidator($_POST['fname']) == false) {
            echo "Fornavn er ikke gyldig!<br>";
            $inputError = true;
        } else {
            $fname = $validator->cleanName($_POST['fname']);
        }

        // Get the last name from the form and clean the string
        if ($validator->nameValidator($_POST['lname']) == false) {
            echo "Etternavn er ikke gyldig!<br>";
            $inputError = true;
        } else {
            $lname = $validator->cleanName($_POST['lname']);
        }

        // Get the email from the form and clean the string
        if ($validator->emailValidation($_POST['email']) == false) {
            echo "Email er ikke gyldig! Bruk email med gyldig format.<br>";
            $inputError = true;
        } else {
            $email = $validator->cleanString($_POST['email']);
        }

        // Get the password from the form and clean the string
        if ($validator->passwordValidation($_POST['password']) == false) {
            echo "Passord er ikke gyldig! Passord må inneholde minst en stor bokstav, to tall, et spesialtegn, og være minst 9 tegn langt.<br>";
            $inputError = true;
        } else {
            // Hash the password using PHP's built-in password_hash function
            $password = password_hash($validator->cleanString($_POST['password']), PASSWORD_DEFAULT);
        }

        if (isset($fname) && isset($lname) && isset($email) && isset($password) && !$inputError) {
            $insert = new Database($pdo);
            $insert->insertToDB($fname, $lname, $email, $password);

            // Set a flash message cookie
            setcookie('temp_message', 'Brukeren ble opprettet!', time() + 3600, "/");
            //Redirect the user to login.php
            header('location:login.php');
        }
    } else {
        // Print a message if the fields are empty and redirect the user to the registration page
        echo "Vennligst fyll ut alle skjemafelt!<br>";
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