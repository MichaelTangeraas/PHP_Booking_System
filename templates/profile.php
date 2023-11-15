<?php

include_once('../includes/db.inc.php');
include_once('../classes/database.php');

// using the database.php class to get the user information from the database
$userDB = new Database($pdo);
$user = $userDB->fetchUserFromDB($_SESSION['userID']);

?>

<script>
    function confirmDelete() {
        var r = confirm("Er du sikker på at du vil slette denne brukeren?");
        if (r == true) {
            window.location.href = "delete_user.php";
        }
    }
</script>

<div class="profile-view">
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
    exit();
}
if (isset($_POST['email']) && $_POST['role'] != 'choose') {
    if (isset($_POST['changeUserRole'])) {
        $email = $_POST['email'];
        $role = $_POST['role'];
        $userDB->changeUserRoleInDB($email, $role);
    }
} else {
    echo "Skriv inn brukernavn og velg brukertype";
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