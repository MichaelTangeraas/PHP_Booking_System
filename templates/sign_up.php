<?php
// Start a new session
// session_start();

// Include the database connection file
require_once('../includes/db.inc.php');

// Check if the 'register' button has been clicked
if (isset($_POST['register'])) {

    // Check if the email and password fields are not empty
    if ($_POST['email'] != "" || $_POST['password'] != "") {
        try {
            // Get the email from the form
            $email = $_POST['email'];

            // Hash the password using PHP's built-in password_hash function
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare an SQL INSERT statement
            $sql = "INSERT INTO `booking_users` (email, password) VALUES ('$email', '$password')";

            // Prepare the statement
            $query = $pdo->prepare($sql);

            // Execute the statement
            $query->execute();
        } catch (PDOException $e) {
            // Print the error message if the insertion fails
            echo $e->getMessage();
        }

        // Set a session message indicating success
        $_SESSION['message'] = array("text" => "User successfully created.", "alert" => "info");

        // Close the database connection
        $pdo = null;

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
    <h1>Sign up</h1>
    <p>Create your account</p>
    <form action="sign_up.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Sign Up" name="register">
    </form>
    <p>Already have an account? <a href="login.php">Log in</a></p>
</div>