<?php
require_once('database.php');
require_once('inputvalidator.php');

/**
 * Class Calender
 * 
 * A class that contains functions for creating a calendar and booking tutor-guidance sessions.
 */
class Calender
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
        // Assign the passed PDO instance to the $pdo property
        $this->pdo = $pdo;
    }

    /**
     * Truncate a string to a specified length and append "..." if it's longer.
     *
     * @param string $string The string to be truncated.
     * @param int $length The maximum length of the truncated string.
     * @return string The truncated string.
     */
    private function shortString($string, $length)
    {
        // Check if the length of the string is greater than the specified length
        if (mb_strlen($string, 'UTF-8') > $length) {
            // If it is, truncate the string to the specified length and append "..."
            $string = mb_substr($string, 0, $length, 'UTF-8') . "...";
        }
        // Return the truncated string
        return $string;
    }

    /**
     * Outputs the booking info for a given time slot based on value in the database.
     * Also outputs the name of the teaching assistant or student who booked the time slot.
     * The name of the teaching assistant will shown instead of the students name if a teaching assistant has "booked" the time slot.
     * 
     * @param string $timeDate The time and date of the booking.
     * @return void
     */
    public function getBooking($timeDate)
    {
        // Create a new Database connection
        $conn = new Database($this->pdo);
        // Select the booking for the given timeDate
        $weekday = $conn->selectBookingFromDB($timeDate);
        // Echo the title of the booking, truncated to 15 characters
        echo $this->shortString($weekday->bookingInfo, 15);

        // If there is a teaching assistant booked for the time slot, echo the teaching assistant's name
        if ($weekday->la != NULL) {
            $la = $conn->selectUserFromDBUserId($weekday->la);
            echo "<br /> LA: " . str_replace(".", "", ($this->shortString($la->fname, 1))) . "." . str_replace(".", "", ($this->shortString($la->lname, 1))) . ". <br>";
        } elseif ($weekday->userID != NULL) {
            // If there is a student booked for the time slot, echo the student's name
            $student = $conn->selectUserFromDBUserId($weekday->userID);
            echo "<br /> Student: " . str_replace(".", "", ($this->shortString($student->fname, 1))) . "." . str_replace(".", "", ($this->shortString($student->lname, 1))) . ". <br>";
        } else {
            echo "<br /> ";
        }
    }

    /**
     * This method generates the time section of the calendar.
     * It starts at 8:00 and ends at 17:00.
     * The time is displayed in a grid layout.
     * Each hour is displayed in a separate grid item.
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
     * Uses the getBooking function to check if the current value should change to the values submitted in the form.
     * The day section starts at 8:00 and ends at 17:00, with each hour represented as a separate grid item.
     * 
     * @param string $day The day to create the section for. This should be a string representing the day of the week.
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
            $this->getBooking($timeDate);
            echo '</div>';
        }
        echo '</div></div>';
    }

    /**
     * Creates and outputs the dates for a given week.
     *
     * This function fetches the week number from the database using the 'monday8' key.
     * It sets the timezone to CET, then outputs the week number. It then creates an array of weekdays,
     * sets the date to the first day of the fetched week, and creates a one day interval. It then loops over the weekdays,
     * outputting each day's name and date, and increments the date by the interval.
     * 
     * Essentially, this function creates the header of the calendar.
     *
     * @return void
     */
    public function createDates()
    {
        $conn = new Database($this->pdo);
        $bookingObject = $conn->selectBookingFromDB('monday8');
        $week = $bookingObject->week;
        date_default_timezone_set('CET');
        echo '<div class="large-grid-item">Uke ' . $week . '</div>';
        $days = ["Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag"];

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
