<?php

include_once('../includes/db.inc.php');
include_once('../classes/database.php');
include_once('../classes/inputvalidator.php');

// using the database.php class to get the user information from the database
$userDB = new Database($pdo);
$user = $userDB->selectUserFromDBUserId($_SESSION['userID']);

?>
<script>
    function confirmDelete() {
        var r = confirm("Er du sikker på at du vil slette denne brukeren?");
        if (r == true) {
            window.location.href = "delete_user.php";
        }
    }
</script>

<div>
    <?php
    if ($user->role == 'la') {
        echo "<h1>LA Profile</h1>";
    } elseif ($user->role == 'student') {
        echo "<h1>Student Profile</h1>";
    }

    if (isset($_SESSION['message'])) {
        echo "<b>" . $_SESSION['message'] . "</b>";
        unset($_SESSION['message']);
    }
    ?>

    <p>First Name: <?php echo $user->fname; ?></p>
    <p>Last Name: <?php echo $user->lname; ?></p>
    <p>Email: <?php echo $user->email; ?></p>
    <p>Role: <?php echo $user->role; ?></p>
</div>

<button onclick="window.location.href='edit_profile.php'">Oppdater profil info</button>
<button onclick="window.location.href='edit_password.php'">Endre passord</button>
<button onclick="confirmDelete()">Slett bruker</button>

<hr />

<?php
if ($user->role != 'la') {
    return;
}
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
            $userDB->changeUserRoleInDB($email, $role);
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
        $userDB->updateWeekInDB($week);
        $ukemelding = "Ukenummeret er oppdatert!";
    } else {
        $ukemelding = "Noe gikk galt! Prøv på nytt.";
    }
}else{
    $ukemelding = "Velg et ukenummer mellom 1 og 52";
}
if (isset($_REQUEST['reset'])) {
    $userDB->reloadTables("weekdays");
}
?>

<form method="post" action="">
    <input type="text" name="email" placeholder="Email" required>
    <select name="role">
        <option value="choose" hidden selected>Velg brukertype</option>
        <option value="student">Student</option>
        <option value="la">Læringsassistent</option>
    </select>
    <input type="submit" name="changeUserRole" value="Bytt brukertype">
</form>

<form method="post" action="">
    <label for="weekNumber"><br><?= $ukemelding ?><br></label>
    <input type="number" name="weekNumber" placeholder="Uke" min="1" max="52"  value="<?php $week = $userDB->selectBookingFromDB('monday8'); echo $week->week?>" required>
    <input type="submit" name="changeWeek" value="Bytt til ny uke">
</form>
<form method="post" action="">
    <label for="weekNumber"><br>Tilbakestill alle bookinger (setter ukenummer til neste uke)<br></label>
    <input type="submit" name="reset" value="Tilbakestill">
</form>