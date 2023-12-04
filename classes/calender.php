<?php

/**
 * Class Calender
 * 
 * A class that contains functions for creating a calendar and booking tutor-guidance sessions.
 */
require_once('../includes/db.inc.php');
include_once('database.php');
require_once('inputvalidator.php');

class Calender
{
    public $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Truncate a string to a specified length and append "..." if it's longer.
     *
     * @param string $string The string to be truncated.
     * @param int $length The maximum length of the truncated string.
     * @return string The truncated string.
     */
    public function shortString($string, $length)
    {
        // Check if the length of the string is greater than the specified length
        if (strlen($string) > $length) {
            // If it is, truncate the string to the specified length and append "..."
            $string = substr($string, 0, $length) . "...";
        }
        // Return the truncated string
        return $string;
    }

    /**
     * Outputs the value of a booking based on the input fields if the submit button is pressed.
     * If no booking is set or the button has not been clicked, it outputs "Ledig".
     * 
     * @param string $timeDate The time and date of the booking.
     * @return void
     */
    public function newValue($timeDate)
    {
        // Create a new Database connection
        $conn = new Database($this->pdo);
        $validator = new InputValidator();

        // Check if a booking request has been made, the requested time matches the current time slot, and a user is logged in
        if (isset($_REQUEST['booking'])) {
            // Get the user's ID
            $userID = $_SESSION['userID'];
            $inputError = false;

            // Get the current booking for this time slot
            $weekday = $conn->selectBookingFromDB($timeDate);
            if (!isset($_POST['text']) || empty($_POST['text'])) {
                $_SESSION['temp_message'] = "Tittel for veiledning må fylles ut.<br>";
                $inputError = true;
            } elseif (strlen($_POST['text']) <= 5 || strlen($_POST['text']) >= 50) {
                $_SESSION['temp_message'] = "Tittel for veiledning må være 5 og 50 tegn langt.<br>";
                $inputError = true;
            }

            if (!isset($_POST['day'])) {
                $_SESSION['temp_message'] = "Velg en dag.<br>";
                $inputError = true;
            } elseif ($_POST['day'] == "day") {
                $_SESSION['temp_message'] = "Velg en dag.<br>";
                $inputError = true;
            }

            if (!isset($_POST['time'])) {
                $_SESSION['temp_message'] = "Velg en tid.<br>";
                $inputError = true;
            } elseif (!$_POST['time'] >= 8 && !$_POST['time'] <= 17) {
                $_SESSION['temp_message'] = "Velg en tid mellom 8 og 17.<br>";
                $inputError = true;
            }

            if (isset($_POST['textDesc']) && strlen($_POST['textDesc']) >= 200) {
                $_SESSION['temp_message'] = "Beskrivelse for veiledning kan ikke være mer enn 200 tegn langt.<br>";
                $inputError = true;
            }

            if ($timeDate == $_REQUEST['day'] . $_REQUEST['time'] && !$inputError) {
                // If the time slot is not booked or is booked by the current user, update the booking
                if ($weekday->userID == NULL || $weekday->userID == $userID) {
                    $_SESSION['temp_message'] = "Veiledningen er booket";
                    echo $conn->updateBookingToDB($validator->cleanString($_REQUEST['text']), $validator->cleanString($_POST['textDesc']), $timeDate, $userID);
                } else {
                    $_SESSION['temp_message'] = "Veiledningen er opptatt";
                }
            }
        } else {
            // If no booking request has been made, show the booking info for this time slot
            $weekday = $conn->selectBookingFromDB($timeDate);
            echo $this->shortString($weekday->bookingInfo, 15);

            // If the time slot is booked, show the user who booked it
            if ($weekday->userID != NULL) {

                $student = $conn->selectUserFromDBUserId($weekday->userID);
                echo "<br /> Student: " . str_replace(".", "", ($this->shortString($student->fname, 1))) . "." . str_replace(".", "", ($this->shortString($student->lname, 1))) . ". <br>";
            } else if ($weekday->la != NULL) {
                $la = $conn->selectUserFromDBUserId($weekday->la);
                echo "<br /> LA: " . str_replace(".", "", ($this->shortString($la->fname, 1))) . "." . str_replace(".", "", ($this->shortString($la->lname, 1))) . ". <br>";
            } else {
                echo "<br /> ";
            }
        }
    }

    /**
     * Creates the time section of the calendar.
     * The time starts at 8:00 and ends at 17:00.
     * 
     * @return void
     */
    public function createTime()
    {
        $time = 8;
        echo '<div class="large-grid-item">
        <div class="grid-container">';
        $i = -1;
        while ($i <= 8) {
            $i++;
            echo '<div class="grid-item">';
            echo $time++ . ":00";
            echo '<br> </div>';
        }
        echo '</div></div>';
    }

    /**
     * Creates a day section of the calendar.
     * Each day section is given an ID based on the combination of the name of the day,
     * and the time of the day. 
     * Uses the newValue function to check if the current value should change to the values submitted in the form.
     * 
     * @param string $day The day to create the section for.
     * @return void
     */
    public function createDay($day)
    {
        $time = 8;
        $timeDate = $day . $time;
        echo '<div class="large-grid-item">
        <div class="grid-container">';
        $i = -1;
        while ($i <= 8) {
            $i++;
            $timeDate = $day . $time++;
            echo '<div class="grid-item">';
            $this->newValue($timeDate);
            echo '</div>';
        }
        echo '</div></div>';
    }

    /**
     * Creates and outputs the dates for a given week.
     *
     * This function sets the timezone to CET, then outputs the week number. It then creates an array of weekdays,
     * sets the date to the first day of the given week, and creates a one day interval. It then loops over the weekdays,
     * outputting each day's name and date, and increments the date by the interval.
     *
     * @param int $week The week number to create dates for.
     * @return void
     */
    public function createDates()
    {
        $conn = new Database($this->pdo);
        $week = $conn->selectBookingFromDB('monday8');
        $week = $week->week;
        date_default_timezone_set('CET');
        echo '<div class="large-grid-item">Uke ' . $week . '</div>';
        $days = array("Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag");

        // Start date
        $date = new DateTime();
        $date->setISODate($date->format('Y'), $week); // Set to the first day of the week

        // One day interval
        $interval = new DateInterval('P1D');

        // Loop over the week
        for ($i = 0; $i < 5; $i++) {
            echo "<div class='large-grid-item'>" . $days[$i] . " " . $date->format('d.m') . "</div>";
            $date->add($interval);
        }
    }
}
