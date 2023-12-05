<!-- HTML form for user information updates -->

<?php
require_once('../classes/database.php');
require_once('../classes/inputvalidator.php');

// using the database.php class to get the user information from the database
$userDB = new Database($pdo);
$user = $userDB->selectUserFromDBUserId($_SESSION['userID']);


// Check if the 'update' button has been clicked
if (isset($_POST['update'])) {

    // Check if the fields are not empty
    if ($_POST['fname'] != "" || $_POST['lname'] != "" || $_POST['email'] != "") {
        $validator = new InputValidator();
        $inputError = false;

        // Get the first name from the form and clean the string
        if ($validator->nameValidator($_POST['fname']) == false) {
            echo "Fornavn er ikke gyldig! Fornavn kan kun inneholde bokstaver, og ha en lengde på minimum 2 karakterer og maksimum 35.<br>";
            $inputError = true;
        } else {
            $fname = $validator->cleanName($_POST['fname']);
        }

        // Get the last name from the form and clean the string
        if ($validator->nameValidator($_POST['lname']) == false) {
            echo "Etternavn er ikke gyldig! Etternavn kan kun inneholde bokstaver, og ha en lengde på minimum 2 karakterer og maksimum 35.<br>";
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
        // If there are no input errors, update the user information
        if (isset($fname) && isset($lname) && isset($email) && !$inputError) {
            // using the database.php class to update the user information in the database
            $result = $userDB->updateUserInDB($fname, $lname, $email, $_SESSION['userID']);
            // Check if the user was updated
            if ($result) {
                // Redirect the user to index.php
                $_SESSION['message'] = "Din bruker ble oppdatert";
                header('location:profile.php');
            } else {
                // Print a message if the email already exists in the database
                echo "En bruker med mailen " . $email . " finnes allerede <br>";
            }
        }
    } else {
        // Print a message if the fields are empty and redirect the user to the registration page
        echo "Vennligst fyll inn alle feltene!<br>";
        header('location:edit_profile.php');
    }
}

?>

<div class="margin">
    <h1>Oppdatere Profil</h1>
    <p>Legg til dine ønskede endringer</p>
    <form action="" method="post">
        <label for="fname">Fornavn:</label><br>
        <input type="fname" id="fname" name="fname" value="<?= $user->fname ?>" required title="Vennligst oppdater ditt fornavn." oninvalid="this.setCustomValidity('Vennligst fyll inn et fornavn.')" oninput="this.setCustomValidity('')"><br>
        <label for="lname">Etternavn:</label><br>
        <input type="lname" id="lname" name="lname" value="<?= $user->lname ?>" required title="Vennligst oppdater ditt etternavn." oninvalid="this.setCustomValidity('Vennligst fyll inn et etternavn')" oninput="this.setCustomValidity('')"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= $user->email ?>" required title="Vennligst oppdater din email." oninvalid="this.setCustomValidity('Vennligst fyll inn en email.')" oninput="this.setCustomValidity('')"><br>
        <input type="submit" value="Lagre endringer" name="update">
        <input type="button" value="Gå tilbake" onclick="window.location.href='../public_html/profile.php'">
    </form>
</div>