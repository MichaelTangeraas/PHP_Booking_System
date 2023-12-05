<!-- HTML form for password updating -->

<?php
include_once('../includes/db.inc.php');
include_once('../classes/database.php');
include_once('../classes/inputvalidator.php');

// using the database.php class to get the user information from the database
$userDB = new Database($pdo);
$user = $userDB->selectUserFromDBUserId($_SESSION['userID']);


// Check if the 'update' button has been clicked
if (isset($_POST['update'])) {

    // Check if the password fields are not empty
    if ($_POST['oldpassword'] != "" || $_POST['newpassword'] != "" || $_POST['repetepassword'] != "") {

        if ($_POST['newpassword'] == $_POST['repetepassword']) {

            if (password_verify($_POST['oldpassword'], $user->password)) {
                $validator = new InputValidator();

                // Get the password from the form and clean the string
                if ($validator->passwordValidation($_POST['newpassword']) == false) {
                    echo "Passord er ikke gyldig! Passord må inneholde minst en stor bokstav, to tall, et spesialtegn, og være minst 9 tegn langt.<br>";
                } else {
                    // Hash the password using PHP's built-in password_hash function
                    $password = password_hash($validator->cleanString($_POST['newpassword']), PASSWORD_DEFAULT);
                    // using the database.php class to update the user information in the database
                    $userDB->updatePasswordInDB($password, $_SESSION['userID']);

                    // Redirect the user to index.php
                    header('location:profile.php');
                    $_SESSION['message'] = "Ditt passord er oppdatert";
                }
            } else {
                echo "Ditt gamle passord er feil. Prøv på nytt.";
            }
        } else {
            echo "Passordene er ikke like. Prøv på nytt.";
        }
    } else {
        // Print a message if the fields are empty and redirect the user to the registration page
        echo "Vennligst fyll ut alle skjemafelt!<br>";
        header('location:edit_password.php');
    }
}

?>
<div>
    <h1>Oppdatere Passord</h1>
    <p>Følg stegende under for å opppdatere ditt passord</p>
    <form action="" method="post">
        <label for="password">Gammelt Passord:</label><br>
        <input type="password" id="password" name="oldpassword" required title="Vennligst fyll inn ditt gamle passord." oninvalid="this.setCustomValidity('Vennligst fyll inn ditt gamle passord.')" oninput="this.setCustomValidity('')"><br>
        <label for="password">Nytt Passord:</label><br>
        <input type="password" id="password" name="newpassword" required title="Vennligst fyll inn et nytt passord." oninvalid="this.setCustomValidity('Vennligst fyll inn et nytt passord.')" oninput="this.setCustomValidity('')"><br>
        <label for="password">Repeter Nytt Passord:</label><br>
        <input type="password" id="password" name="repetepassword" required title="Vennligst repeter nytt passord." oninvalid="this.setCustomValidity('Vennligst repeter nytt passord.')" oninput="this.setCustomValidity('')"><br>
        <input type="submit" value="Lagre endringer" name="update">
        <input type="button" value="Gå tilbake" onclick="window.location.href='../public_html/profile.php'">
    </form>
</div>