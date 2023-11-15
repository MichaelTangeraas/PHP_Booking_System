<?php
include_once('../includes/db.inc.php');

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
    public $pdo;

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
     * Method to update the weekdays table
     * 
     * This method updates the 'weekdays' table in the database. It sets the 'bookingInfo' column 
     * to the value of $bookingInfo where 'timeDate' equals $timeDate.
     * 
     * @param string $bookingInfo The new booking information.
     * @param string $timeDate The time and date of the booking.
     * 
     * @return void
     */
    public function updateToDB($bookingInfo, $timeDate)
    {
        // SQL query to update the bookingInfo column
        $sql = "UPDATE weekdays SET bookingInfo = :bookingInfo WHERE timeDate = :timeDate";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':bookingInfo', $bookingInfo, PDO::PARAM_STR);
        $query->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!";
        }
        $this->pdo = null;
    }

    /**
     * Method to reload tables
     * 
     * This method drops the specified table if it exists, then recreates it.
     * If the table is 'weekdays', it also inserts predefined values into the timeDate column.
     * If the table is 'booking_users', it creates the table with userID, email, and password columns.
     * 
     * @param string $table The name of the table to reload.
     * 
     * @return void
     */
    public function reloadTables($table)
    {
        // If the table is 'weekdays'
        if ($table == 'weekdays') {
            // SQL query to drop and recreate the weekdays table
            $sql = "DROP TABLE IF EXISTS weekdays;

            CREATE TABLE weekdays (
                primary_key INT AUTO_INCREMENT PRIMARY KEY,
                timeDate VARCHAR(255),
                bookingInfo VARCHAR(255) DEFAULT 'Ledig time'
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
                echo "Oi, her gikk det galt!";
            }
        } else if ($table == "booking_users") {
            // SQL query to drop and recreate the booking_users table
            $sql = "DROP TABLE IF EXISTS booking_users;
            
            CREATE TABLE booking_users (
                userID INT AUTO_INCREMENT PRIMARY KEY,
                email varchar(255) NOT NULL,
                password varchar(255) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

            // Execute the query and handle any exceptions
            try {
                $query = $this->pdo->prepare($sql);
                $query->execute();
            } catch (PDOException $e) {
                echo "Oi, her gikk det galt!";
            }
        }
        $this->pdo = null;
    }

    /**
     * Method to select from the weekdays table
     * 
     * This method selects all records from the weekdays table where timeDate equals the input.
     * It then fetches all the results as objects and prints the bookingInfo for each result.
     * If no results are found, it prints a message indicating that the query resulted in an empty result set.
     * 
     * @param string $timeDate The time and date to select.
     * 
     * @return void
     */
    function selectFromDB($timeDate)
    {
        // SQL query to select all records where timeDate equals the input
        $sql = "SELECT * FROM weekdays WHERE timeDate = :timeDate";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);

        // Execute the query and handle any exceptions
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Error querying database: " . $e->getMessage() . "<br>";
        }

        // Fetch all the results as objects
        $weekdays = $query->fetchAll(PDO::FETCH_OBJ);

        // If the query returned results, print the bookingInfo for each result
        if ($query->rowCount() > 0) {
            foreach ($weekdays as $w) {
                echo $w->bookingInfo;
            }
        } else {
            // If the query did not return any results, print a message
            echo "The query resulted in an empty result set.";
        }
        $this->pdo = null;
    }

    function insertToDB($fname, $lname, $email, $password)
    {
        try {
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

            // Execute the statement
            $query->execute();
        } catch (PDOException $e) {
            // Print the error message if the insertion fails
            echo $e->getMessage();
        }
        $this->pdo = null;
    }

    function deleteFromDB($userID)
    {
        // Prepare an SQL DELETE statement
        $sql = "DELETE FROM `booking_users` WHERE userID = :userID";
        // Set the PDO error mode to exception
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_STR);

        // Execute the statement
        $query->execute();
        $this->pdo = null;
    }

    // function for fetching user info from database
    function fetchUserFromDB($userID)
    {
        // Prepare an SQL SELECT statement
        $sql = "SELECT * FROM `booking_users` WHERE userID = :userID";
        // Set the PDO error mode to exception
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepare the statement
        $query = $this->pdo->prepare($sql);

        // Protect against SQL injections
        $query->bindParam(':userID', $userID, PDO::PARAM_STR);

        // Execute the statement
        $query->execute();

        // Fetch the result as an object
        $user = $query->fetch(PDO::FETCH_OBJ);

        // Return the result
        return $user;
    }


    function changeUserRoleInDB($email, $role){
        $sql = "UPDATE booking_users SET role = :role WHERE email = :email;";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':role', $role, PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "En bruker med denne emailen finnes ikke";
            exit();
        }
        echo "Brukeren med email " . $email . " har nå rollen " . $role;
    }

    function updateUserInDB($fname, $lname, $email, $userID)
    {
        $sql = "UPDATE booking_users SET fname = :fname, lname = :lname, email = :email WHERE userID = $userID;";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "En bruker med emailen ".$email." finnes allerede";
            exit();
        }
        echo "Brukeren med email " . $email . " har blitt oppdatert";
    }

    function updatePasswordInDB($password, $userID){
        $sql = "UPDATE booking_users SET password = :password WHERE userID = $userID;";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo "Oi, her gikk det galt!";
            exit();
        }
        echo "Passordet har blitt oppdatert";
    }
}
