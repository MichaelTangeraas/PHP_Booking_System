<?php
/**
 * Class Calender
 * 
 * A class that contains functions for creating a calendar and booking tutor-guidance sessions.
 */
require_once('../includes/db.inc.php');
include('select.php');
include('update.php');
class Calender
{
    public $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Outputs the value of a booking based on the input fields if the submit button is pressed,
     * or "Ledig" if no booking is set or the button has not been clicked.
     * 
     * @param string $timeDate The time and date of the booking.
     * @return void
     */
    public function newValue($timeDate)
    {
        if (isset($_REQUEST['booking']) && $timeDate == $_REQUEST['day'] . $_REQUEST['time']) {
            echo $_REQUEST['text'];
            $update = new Update($this->pdo,$_REQUEST['text'],$timeDate);
            echo $update->updateToDB();
        } else {
            $select = new Select($this->pdo,$timeDate);
            echo $select->selectFromDB();
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
            echo '</div>';
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
}
