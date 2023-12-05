<?php
require_once('../includes/db.inc.php');

/**
 * Class Database
 * 
 * This class provides methods for interacting with a database using PDO.
 */
class Database
{
    /**
     * @var PDO $pdo An instance of the PDO object.
     */
    private $pdo;

    /**
     * Constructor method
     * 
     * Initializes the PDO object.
     * 
     * @param PDO $pdo The PDO object.
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Inserts a new user into the database.
     *
     * This function takes a first name, last name, email, and password as input and inserts a new user into the `booking_users` table in the database.
     * It prepares a SQL INSERT statement, binds the parameters to protect against SQL injections, and executes the statement.
     * 
     * @param string $fname The first name of the user.
     * @param string $lname The last name of the user.
     * @param string $email The email address of the user.
     * @param string $password The password of the user.
     *
     * @return bool Returns true if the insertion was successful, false otherwise.
     */
    public function insertUserToDB($fname, $lname, $email, $password)
    {

        // Prepare an SQL INSERT statement
        $sql = "INSERT INTO `booking_users` (fname, lname, email, password) VALUES (:fname, :lname, :email, :password)";
        // Set the PDO error mode to exception
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);

        try {
            // Execute the statement
            $query->execute();
            // Set the return value to true
            $inserted = true;
        } catch (PDOException $e) {
            // Set the return value to false
            $inserted = false;
        }
        // Return the result
        return $inserted;
    }


    /**
     * Updates the 'la' field in the 'weekdays' table for a specific 'timeDate'.
     *
     * This function prepares a SQL UPDATE statement to set the 'la' field to the input 'laName' where 'timeDate' equals the input 'timeDate'.
     * It binds the input parameters to the SQL query, executes the query, and handles any exceptions.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     * If the update is successful, a success message is stored in the session.
     *
     * @param string $timeDate The date and time for which the 'la' field should be updated.
     * @param string $laName The new value for the 'la' field.
     *
     * @return void
     */
    public function setAvailableLAinDB($timeDate, $laName)
    {
        // Prepare an SQL UPDATE statement
        $sql = "UPDATE weekdays SET la = :laName WHERE timeDate = :timeDate";
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);
        $query->bindParam(':laName', $laName, PDO::PARAM_STR);

        // Execute the statement
        try {
            // Execute the statement
            $query->execute();
        } catch (PDOException $e) {
            // Print an error message if the update fails
            echo "Oi, her gikk det galt!";
            exit();
        }
        $_SESSION['temp_message'] = "Tilgjengelighet er registrert";
    }


    /**
     * Method to select from the weekdays table
     * 
     * This method selects all records from the weekdays table where 'timeDate' equals the input.
     * It then fetches the result as an object and returns it.
     * 
     * @param string $timeDate The time and date to select.
     * 
     * @return object Returns an object containing the booking information.
     */
    public function selectBookingFromDB($timeDate)
    {
        // SQL query to select all records where timeDate equals the input
        $sql = "SELECT * FROM weekdays WHERE timeDate = :timeDate";
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }

        // Fetch the result as an object
        $weekdays = $query->fetch(PDO::FETCH_OBJ);
        // Return the result
        return $weekdays;
    }


    /**
     * Selects all bookings made by a specific student from the weekdays table.
     *
     * This function prepares a SQL query to select all records from the weekdays table where 'userID' equals the input.
     * It binds the input parameter to the SQL query, executes the query, and handles any exceptions.
     * It then fetches all the results as an array of objects and returns it.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param int $userID The ID of the user whose bookings to select.
     * 
     * @return array Returns an array of objects containing the booking information for the specified user.
     */
    public function selectStudentBookingFromDB($userID)
    {
        // SQL query to select all records where timeDate equals the input
        $sql = "SELECT * FROM weekdays WHERE userID = :userID";
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }

        // Fetch all the results as an array of objects
        $weekdays = $query->fetchAll(PDO::FETCH_OBJ);

        // Return the result
        return $weekdays;
    }


    /**
     * Selects all records from the 'weekdays' table where 'la' equals the provided 'userID'.
     *
     * This function prepares a SQL query to select all records from the weekdays table where 'la' equals the input.
     * It binds the input parameter to the SQL query, executes the query, and handles any exceptions.
     * It then fetches all the results as an array of objects and returns it.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param int $userID The user ID to match against the 'la' field.
     * 
     * @return array An array of objects representing the matching records.
     */
    public function selectLaBookingFromDB($userID)
    {
        // SQL query to select all records where timeDate equals the input
        $sql = "SELECT * FROM weekdays WHERE la = :userID";
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }

        // Fetch all the results as an array of objects
        $weekdays = $query->fetchAll(PDO::FETCH_OBJ);

        // Return the result
        return $weekdays;
    }


    /**
     * Select a user's information from the database based on UserID.
     *
     * This function takes a user ID as input and fetches the corresponding user's information from the `booking_users` table in the database.
     *
     * @param string $userID The ID of the user to be fetched.
     *
     * @return object Returns an object containing the user's information.
     */
    public function selectUserFromDBUserId($userID)
    {
        // Prepare an SQL SELECT statement
        $sql = "SELECT * FROM `booking_users` WHERE userID = :userID";
        // Set the PDO error mode to exception
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_STR);

        // Execute the statement and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }

        // Fetch the result as an object
        $user = $query->fetch(PDO::FETCH_OBJ);

        // Return the result
        return $user;
    }


    /**
     * Retrieves a user from the database using their email.
     *
     * This function prepares a SQL query to select a user from the `booking_users` table where the `email` equals the input.
     * It binds the input parameter to the SQL query, executes the query, and handles any exceptions.
     * It then fetches the result as an object and returns it.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param string $email The email of the user to retrieve.
     * @return object|null The user object if found, null otherwise.
     */
    public function selectUserFromDBEmail($email)
    {
        // SQL query to get user with the given email
        $sql = "SELECT * FROM `booking_users` WHERE `email`= :email";

        // Prepare the SQL query
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            // Execute the SQL query
            $query->execute();
        } catch (PDOException $e) {
            // Print an error message if the query fails
            echo "Feil email eller passord";
            exit();
        }

        // Fetch the user data
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }


    /**
     * Method to update the weekdays table
     * 
     * This method updates the 'weekdays' table in the database. It sets the 'bookingInfo', 'bookingDescription' and 'userID' columns 
     * to the values of $bookingInfo, $bookingDescription and $userID respectively, where 'timeDate' equals $timeDate and the 'userID' is either NULL or equals $userID.
     * If the $bookingDescription is empty, it is set to "Ingen beskrivelse".
     * The method prepares a SQL query, binds the parameters, and executes the query.
     * If an exception occurs during the query execution, it is caught and an error message is displayed.
     * 
     * @param string $bookingInfo The new booking information.
     * @param string $bookingDescription The new booking description. If empty, it is set to "Ingen beskrivelse".
     * @param string $timeDate The time and date of the booking.
     * @param int $userID The ID of the user making the booking.
     * 
     * @return void
     */
    public function updateBookingInDB($bookingInfo, $bookingDescription, $timeDate, $userID)
    {
        // If the booking description is empty, set it to "Ingen beskrivelse"
        if ($bookingDescription == "") {
            $bookingDescription = "Ingen beskrivelse";
        }

        // SQL query to update the bookingInfo column
        $sql = "UPDATE weekdays SET bookingInfo = :bookingInfo, bookingDescription = :bookingDescription, userID = :userID WHERE timeDate = :timeDate AND (userID IS NULL OR userID = :userID)";
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':bookingInfo', $bookingInfo, PDO::PARAM_STR);
        $query->bindParam(':bookingDescription', $bookingDescription, PDO::PARAM_STR);
        $query->bindParam(':userID', $userID, PDO::PARAM_INT);
        $query->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            // We could use this to log the error to a file, but it has to be configured first with XAMPP and php.ini
            // error_log($e->getMessage());
            echo "Oi, her gikk det galt!<br>";
        }
    }


    /**
     * Updates the 'week' field in the 'weekdays' table with the provided 'week' value.
     *
     * This method updates the 'week' field in the 'weekdays' table in the database with the provided 'week' value.
     * It prepares a SQL query, binds the parameters to protect against SQL injections, and executes the query.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param int $week The week number to be updated in the 'week' field.
     *
     * @return void
     */
    public function updateWeekInDB($week)
    {
        $sql = "UPDATE weekdays SET week = :week";
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':week', $week, PDO::PARAM_INT);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }
    }


    /**
     * Changes a user's role in the database.
     *
     * This function takes an email and a role as input and updates the corresponding user's role in the `booking_users` table in the database.
     * If the user does not exist, it displays an error message.
     * If the role update is successful, it displays a success message.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param string $email The email of the user whose role is to be changed.
     * @param string $role The new role for the user.
     *
     * @return void
     */
    public function updateUserRoleInDB($email, $role)
    {
        if ($this->selectUserFromDBEmail($email) == NULL) {
            echo "Brukeren med email " . $email . " finnes ikke";
        } else {
            // Prepare an SQL UPDATE statement
            $sql = "UPDATE booking_users SET role = :role WHERE email = :email;";
            // Prepare the statement
            $query = $this->pdo->prepare($sql);

            // Protect against SQL injections
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':role', $role, PDO::PARAM_STR);

            // Execute the statement and handle any exceptions
            try {
                // Execute the statement
                $query->execute();
            } catch (PDOException $e) {
                // Print an error message if the update fails
                echo "Oi, her gikk det galt!";
                exit();
            }
            // Print a success message
            echo "Brukeren med email " . $email . " har nå rollen " . $role;
        }
    }


    /**
     * Updates a user's information in the database.
     *
     * This function takes a first name, last name, email, and user ID as input and updates the corresponding user's information in the `booking_users` table in the database.
     *
     * @param string $fname The new first name of the user.
     * @param string $lname The new last name of the user.
     * @param string $email The new email address of the user.
     * @param string $userID The ID of the user to be updated.
     *
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function updateUserInDB($fname, $lname, $email, $userID)
    {
        // Prepare an SQL UPDATE statement
        $sql = "UPDATE booking_users SET fname = :fname, lname = :lname, email = :email WHERE userID = $userID;";
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            // Execute the statement
            $query->execute();
            $updated = true;
        } catch (PDOException $e) {
            $updated = false;
        }
        return $updated;
    }


    /**
     * Updates a user's password in the database.
     *
     * This function takes a password and a user ID as input and updates the corresponding user's password in the `booking_users` table in the database.
     *
     * @param string $password The new password of the user.
     * @param string $userID The ID of the user whose password is to be updated.
     *
     * @return void
     */
    public function updatePasswordInDB($password, $userID)
    {
        // Prepare an SQL UPDATE statement
        $sql = "UPDATE booking_users SET password = :password WHERE userID = $userID;";
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':password', $password, PDO::PARAM_STR);

        try {
            // Execute the statement
            $query->execute();
        } catch (PDOException $e) {
            // Print an error message if the update fails
            echo "Oi, her gikk det galt!";
            exit();
        }
        // Print a success message
        echo "Passordet har blitt oppdatert";
    }


    /**
     * Resets a booking to its default state in the database, without resetting the LA.
     *
     * This method updates the 'weekdays' table in the database, setting the 'bookingInfo' column to 'Ledig time',
     * the 'bookingDescription' column to 'Ingen beskrivelse', and the 'userID' column to NULL, 
     * for the row where 'timeDate' equals $timeDate.
     * It prepares a SQL query, binds the parameters to protect against SQL injections, and executes the query.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param string $timeDate The time and date of the booking to reset.
     * @return void
     */
    public function resetStudentBookingInDB($timeDate)
    {
        // SQL query to update/reset the bookingInfo, bookingDescription columns
        $sql = "UPDATE weekdays SET bookingInfo = 'Ledig time', bookingDescription = 'Ingen beskrivelse', userID = NULL WHERE timeDate = :timeDate";
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }
    }

    /**
     * Resets the LA column in a booking for the specified timeDate.
     *
     * This method updates the 'weekdays' table in the database, setting the 'la' column to NULL.
     * It prepares a SQL query, binds the parameters to protect against SQL injections, and executes the query.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param string $timeDate The time and date of the booking to reset.
     * @return void
     */
    public function resetLaBookingInDB($timeDate)
    {
        // SQL query to update/reset the LA column
        $sql = "UPDATE weekdays SET la = NULL WHERE timeDate = :timeDate";
        $query = $this->pdo->prepare($sql);
        // Protect against SQL injections
        $query->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }
    }




    /**
     * Deletes a user from the database.
     *
     * This function takes a user ID as input and deletes the corresponding user from the `booking_users` table in the database.
     * It prepares a SQL DELETE statement, binds the parameters to protect against SQL injections, and executes the statement.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param string $userID The ID of the user to be deleted.
     *
     * @return void
     */
    public function deleteUserFromDB($userID)
    {
        // Prepare an SQL DELETE statement
        $sql = "DELETE FROM `booking_users` WHERE userID = :userID";
        // Set the PDO error mode to exception
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_STR);

        // Execute the statement and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!<br>";
        }
    }


    /**
     * Deletes the user bookings in the 'weekdays' table for a specific 'userID'.
     *
     * This function prepares a SQL UPDATE statement to set the 'bookingInfo', 'bookingDescription', and 'userID' fields to their default values where 'userID' equals the input.
     * It binds the input parameter to the SQL query, executes the query, and handles any exceptions.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param int $userID The user ID for which the bookings should be deleted.
     *
     * @return void
     */
    public function deleteAllStudentBookingsInDB($userID)
    {
        // Prepare an SQL UPDATE statement
        $sql = "UPDATE weekdays SET bookingInfo = 'Ledig time', bookingDescription = 'Ingen beskrivelse', userID = NULL WHERE userID = :userID";
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_INT);

        // Execute the statement
        try {
            // Execute the statement
            $query->execute();
        } catch (PDOException $e) {
            // Print an error message if the update fails
            echo "Oi, her gikk det galt!";
        }
    }


    /**
     * Deletes the 'la' bookings in the 'weekdays' table for a specific 'userID'.
     *
     * This function prepares a SQL UPDATE statement to set the 'la' field to NULL where 'la' equals the input.
     * It binds the input parameter to the SQL query, executes the query, and handles any exceptions.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     *
     * @param int $userID The user ID for which the 'la' bookings should be deleted.
     *
     * @return void
     */
    public function deleteAllLaBookingsInDB($userID)
    {
        // Prepare an SQL UPDATE statement
        $sql = "UPDATE weekdays SET la = NULL WHERE la = :userID";
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_INT);

        // Execute the statement
        try {
            // Execute the statement
            $query->execute();
        } catch (PDOException $e) {
            // Print an error message if the update fails
            echo "Oi, her gikk det galt!";
        }
    }


    /**
     * Reloads the specified table.
     * 
     * This method drops the specified table if it exists, then recreates it.
     * If the table is 'weekdays', it creates the table with 'primary_key', 'week', 'timeDate', 'bookingInfo', 'bookingDescription', 'userID', and 'la' columns. 
     * It then inserts the default values into the table.
     * 
     * If the table is 'booking_users', it creates the table with 'userID', 'fname', 'lname', 'email', 'password', and 'role' columns.
     * Role is set to 'student' by default. This table is not used in the current version of the application, but is can be useful for future development.
     * Therefore, this part of the code is commented out.
     * If an exception occurs during the query execution, it is caught and a custom error message is displayed.
     * 
     * @param string $table The name of the table to reload.
     * 
     * @return void
     */
    public function reloadTables($table)
    {
        // If the table is 'weekdays'
        if ($table == 'weekdays') {
            $week = date("W") + 1; // Get the current week number of the next week
            // SQL query to drop and recreate the weekdays table
            $sql = "DROP TABLE IF EXISTS weekdays;

            CREATE TABLE weekdays (
                primary_key INT AUTO_INCREMENT PRIMARY KEY,
                week int(2) DEFAULT '$week',
                timeDate VARCHAR(255),
                bookingInfo VARCHAR(255) DEFAULT 'Ledig time',
                bookingDescription VARCHAR(255) DEFAULT 'Ingen beskrivelse',
                userID INT(11) DEFAULT NULL,
                la VARCHAR(255) DEFAULT NULL,
                CONSTRAINT `fk_userID` FOREIGN KEY (`userID`) REFERENCES `booking_users` (`userID`)
            );
        
            INSERT INTO weekdays (timeDate) VALUES
            ('monday8'),('monday9'),('monday10'),('monday11'),('monday12'),('monday13'),('monday14'),('monday15'),('monday16'),('monday17'),
            ('tuesday8'),('tuesday9'),('tuesday10'),('tuesday11'),('tuesday12'),('tuesday13'),('tuesday14'),('tuesday15'),('tuesday16'),('tuesday17'),
            ('wednesday8'),('wednesday9'),('wednesday10'),('wednesday11'),('wednesday12'),('wednesday13'),('wednesday14'),('wednesday15'),('wednesday16'),('wednesday17'),
            ('thursday8'),('thursday9'),('thursday10'),('thursday11'),('thursday12'),('thursday13'),('thursday14'),('thursday15'),('thursday16'),('thursday17'),
            ('friday8'),('friday9'),('friday10'),('friday11'),('friday12'),('friday13'),('friday14'),('friday15'),('friday16'),('friday17');";

            // Execute the query and handle any exceptions
            try {
                $query = $this->pdo->prepare($sql);
                $query->execute();
            } catch (PDOException $e) {
                echo "Oi, her gikk det galt!<br>";
            }
        }/* else if ($table == "booking_users") {
            // SQL query to drop and recreate the booking_users table
            $sql = "DROP TABLE IF EXISTS booking_users;
            
            CREATE TABLE booking_users (
                `userID` int(11) AUTO_INCREMENT PRIMARY KEY,
                `fname` varchar(255) NOT NULL,
                `lname` varchar(255) NOT NULL,
                `email` varchar(255) UNIQUE NOT NULL,
                `password` varchar(255) NOT NULL,
                `role` enum('la','student') NOT NULL DEFAULT 'student'
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

            // Execute the query and handle any exceptions
            try {
                $query = $this->pdo->prepare($sql);
                $query->execute();
            } catch (PDOException $e) {
                echo "Oi, her gikk det galt!<br>";
            }
        }*/
    }

    /**
     * Closes the database connection and unsets the provided object.
     *
     * @param mixed $object The object to be unset.
     *
     * @return void
     */
    public function closeDB($object)
    {
        $this->pdo = null;
        unset($object);
    }

    ## FORSLAG TIL HVORDAN VI KAN LUKKE DB CONNECTION ##
    #start av fil#
    /*
    $close = false;
    $conn = new Database($pdo);
    if ("something"){
        $close = false;
        //do something related to DB
        $close = true;
    }
    if ("something else"){
        $close = false;
        //do something else related to DB
        $close = true;
    }

    // Checked after all DB related code has possibly or actually been executed
    if ($close) {
        $conn->closeDB($conn);
    }
    */
    #slutt av fil#
}
