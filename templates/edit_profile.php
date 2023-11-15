<!-- HTML form for user registration -->

<?php

include_once('../includes/db.inc.php');
include_once('../classes/database.php');
include_once('../classes/inputvalidator.php');

// using the database.php class to get the user information from the database
$userDB = new Database($pdo);
$user = $userDB->selectUserFromDBUserId($_SESSION['userID']);


// Check if the 'update' button has been clicked
if (isset($_POST['update'])) {

    // Check if the email and password fields are not empty
    if ($_POST['fname'] != "" || $_POST['lname'] != "" || $_POST['email'] != "") {
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

        if (isset($fname) && isset($lname) && isset($email) && !$inputError) {
            // using the database.php class to update the user information in the database
            $userDB->updateUserInDB($fname, $lname, $email, $_SESSION['userID']);
            // Redirect the user to index.php
            header('location:profile.php');
            $_SESSION['message'] = "Din bruker ble oppdatert";
        }

    } else {
        // Print a message if the fields are empty and redirect the user to the registration page
        echo "Please fill up the required field!";
        header('location:edit_profile.php');
    }
}

?>

<div>
    <h1>Oppdatere Profil</h1>
    <p>Legg til dine ønskede endringer</p>
    <form action="" method="post">
        <label for="fname">Fornavn:</label><br>
        <input type="fname" id="fname" name="fname" value="<?= $user->fname ?>" required oninvalid="this.setCustomValidity('Vennligst fyll inn et fornavn.')" oninput="this.setCustomValidity('')"><br>
        <label for="lname">Etternavn:</label><br>
        <input type="lname" id="lname" name="lname" value="<?= $user->lname ?>" required oninvalid="this.setCustomValidity('Vennligst fyll inn et etternavn')" oninput="this.setCustomValidity('')"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= $user->email ?>" required oninvalid="this.setCustomValidity('Vennligst fyll inn en email.')" oninput="this.setCustomValidity('')"><br>
        <input type="submit" value="Lagre endringer" name="update">
        <input type="button" value="Gå tilbake" onclick="history.back()">
    </form>
</div>