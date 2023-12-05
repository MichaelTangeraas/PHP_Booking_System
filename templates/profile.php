<!-- Profile content -->
<?php
require_once('../classes/database.php');
require_once('../classes/inputvalidator.php');

// using the database.php class to get the user information from the database
$conn = new Database($pdo);
$user = $conn->selectUserFromDBUserId($_SESSION['userID']);

?>
<script>
    // Confirm delete user
    function confirmDelete() {
        var r = confirm("Er du sikker på at du vil slette denne brukeren?");
        if (r == true) {
            window.location.href = "delete_user.php";
        }
    }

    // Confirm reload table
    function confirmReloadTable() {
        var r = confirm("Er du sikker på at du vil tilbakestille alle bookinger?");
        if (r == true) {
            window.location.href = "reload_table.php";
        }
    }
</script>

<div class='margin'>
    <?php
    if ($user->role == 'la') {
        echo "<h1>LA Profile</h1>";
    } elseif ($user->role == 'student') {
        echo "<h1>Student Profile</h1>";
    }

    // Display messages if there are any
    if (isset($_SESSION['message'])) {
        echo "<b>" . $_SESSION['message'] . "</b>";
        unset($_SESSION['message']);
    }
    ?>

    <p>Fornavn: <?php echo $user->fname; ?></p>
    <p>Etternavn: <?php echo $user->lname; ?></p>
    <p>Email: <?php echo $user->email; ?></p>
    <p>Brukertype: <?php echo $user->role; ?></p>
</div>
<div class='margin'>
    <button onclick="window.location.href='edit_profile.php'">Oppdater profil info</button>
    <button onclick="window.location.href='edit_password.php'">Endre passord</button>
    <button onclick="confirmDelete()">Slett bruker</button>
</div>

<hr />
<?php
if ($user->role != 'la') {
    return;
}
?>
<div class='margin'>
    <?php
    if (isset($_POST['email']) && $_POST['role'] != 'choose') {

        $validator = new InputValidator();
        $inputError = false;

        if (isset($_POST['changeUserRole'])) {
            // Get the email from the form and clean the string
            if ($validator->emailValidation($_POST['email']) == false) {
                echo "Email er ikke gyldig! Bruk email med gyldig format.<br>";
                $inputError = true;
            } else if ($user->email == $_POST['email']) {
                echo "Du kan ikke endre din egen brukertype!<br>";
                $inputError = true;
            } else {
                $email = $validator->cleanString($_POST['email']);
            }
            $role = $_POST['role'];
            if (isset($email) && $role == 'student' || $role == 'la' && !$inputError) {
                $userEmail = $conn->selectUserFromDBEmail($email);
                if ($role == 'la') {
                    $conn->deleteAllStudentBookingsInDB($userEmail->userID);
                }else if ($role == 'student') {
                    $conn->deleteAllLABookingsInDB($userEmail->userID);
                }
                $conn->updateUserRoleInDB($email, $role);
            } else {
                echo "Noe gikk galt! Prøv på nytt.";
            }
        }
    } else {
        echo "Skriv inn brukernavn og velg brukertype";
    }

    if (isset($_POST['changeWeek'])) {
        $validator = new InputValidator();
        $inputError = false;
        $week = $validator->cleanString($_POST['weekNumber']);
        if ($week < 1 || $week > 52) {
            $ukemelding = "Ukenummeret må være mellom 1 og 52!<br>";
            $inputError = true;
        }
        if (!$inputError) {
            $conn->updateWeekInDB($week);
            $ukemelding = "Ukenummeret er oppdatert!";
        } else {
            $ukemelding = "Noe gikk galt! Prøv på nytt.";
        }
    } else {
        $ukemelding = "Velg et ukenummer mellom 1 og 52";
    }

    ?>

    <form method="post" action="">
        <input type="text" name="email" placeholder="Email" required title="Vennligst fyll inn en gyldig e-postadresse." oninvalid="this.setCustomValidity('Vennligst fyll inn en email.')" oninput="this.setCustomValidity('')">
        <select name="role" required title="Vennligst velg en brukertype." oninvalid="this.setCustomValidity('Vennligst velg en brukertype.')" oninput="this.setCustomValidity('')">
            <option value="choose" hidden selected>Velg brukertype</option>
            <option value="student">Student</option>
            <option value="la">Læringsassistent</option>
        </select>
        <input type="submit" name="changeUserRole" value="Bytt brukertype">
    </form>

    <form method="post" action="">
        <label for="weekNumber"><br><?= $ukemelding ?><br></label>
        <input type="number" name="weekNumber" placeholder="Uke" min="1" max="52" value="<?php $week = $conn->selectBookingFromDB('monday8');
                                                                                            echo $week->week ?>" required title="Vennligst velg et ukenummer mellom 1 og 52." oninvalid="this.setCustomValidity('Vennligst velg et ukenummer mellom 1 og 52.')" oninput="this.setCustomValidity('')">
        <input type="submit" name="changeWeek" value="Bytt til ny uke">
    </form>
    <form method="post" action="">
        <label for="weekNumber"><br>Tilbakestill alle bookinger (setter ukenummer til neste uke)<br></label>
    </form>
    <button onclick="confirmReloadTable()">Tilbakestill alle bookinger</button>
</div>