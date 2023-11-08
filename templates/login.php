<?php
include("../classes/reload.php");
require_once('../includes/db.inc.php');
$reload = new Reload($pdo, "users");
if (isset($_POST['login'])) {
    if ($_POST['email'] != "" || $_POST['password'] != "") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM `booking_users` WHERE `email`='$email'";
        $query = $pdo->prepare($sql);
        $query->execute();
        $booking_users = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            if (password_verify($password, $booking_users->password)) {
                echo "Riktig passord";
                session_start();
                $_SESSION['userID'] = $booking_users->userID;
                header('location: index.php');
            } else {
                echo "Feil passord";
            }
        } else {
            echo "Feil brukernavn eller passord";
            // header('location: login.php');
        }
    } else {
        echo "Please complete the required field!";
        // header('location: login.php');
    }
}

if (isset($_GET['reset'])) {
    echo "Kjører";
    $reload->reload($pdo);
}

?>

<form action="login.php" method="post">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Login" name="login">
</form>

<hr />

<form>
    <input type="submit" value="Reset" name="reset">
</form>




<!-- <h1>Login</h1>
<form action="login.php" method="post">
    Username: <input type="text" name="email"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
<?php
// require_once('../includes/db.inc.php');

// session_start();


// if (isset($_POST['email']) && isset($_POST['password'])) {

//     $email = $_POST['email'];
//     $password = $_POST['password'];


//     $sql = "SELECT * FROM booking_users WHERE email='$email'";
//     $query = $pdo->prepare($sql);

//     try {
//         $query->execute();
//     } catch (PDOException $e) {
//         echo "Error querying database: " . $e->getMessage() . "<br>"; // Aldri gjør dette i produksjon!
//     }

//     $booking_users = $query->fetchAll(PDO::FETCH_OBJ);

//     if (!empty($booking_users) && password_verify($password, $booking_users[0]->password)) {
//         echo "riktig passord";
//     } else {
//         echo "Feil passord";
//     }

// } else {
//     echo "Please fill out all fields";
// }

?> -->