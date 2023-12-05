<!-- Booking System -->
<?php
include("../classes/calender.php");
include_once("../classes/database.php");
$calender = new Calender($pdo);
$conn = new Database($pdo);

// Check if a booking request has been made. Refresh the page if it has.
if (isset($_REQUEST['booking'])) {
    header('Location: ../public_html/index.php');
}

// Check if the delete button has been pressed. If it has, reset the booking and refresh the page.
if (isset($_POST['delete'])) {
    $timeDate = $_POST['timeDate']; // Get the timeDate value from the form
    $conn->resetBookingToDB($timeDate);
    header('Location: ../public_html/index.php');
}

// Display the welcome message and user information
if (isset($_SESSION['userID'])) {
    $user = $conn->selectUserFromDBUserId($_SESSION['userID']);
    echo ("<h4 class='margin'>Velkommen: " . ucfirst($user->role) . " - " . $user->fname . " " . $user->lname . "</h4>");
} else {
    echo ("<h4 class='margin'>Woops, her er noe galt!</h4>");
}

if (isset($_REQUEST['la'])) {
    $inputError = false;
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
    } elseif ($_POST['time'] < 8 || $_POST['time'] > 17) {
        $_SESSION['temp_message'] = "Velg en tid mellom 8 og 17.<br>";
        $inputError = true;
    }

    if (!$inputError){
        $conn->setAvailableLAinDB($_POST['day'] . $_POST['time'], $user->userID);
    }
}

// An array for converting the days to Norwegian
$daysInNorwegian = [
    "monday" => "Mandag",
    "tuesday" => "Tirsdag",
    "wednesday" => "Onsdag",
    "thursday" => "Torsdag",
    "friday" => "Fredag"
];

?>

<!-- Overview of current user bookings -->
<?php
echo "<h2 class='margin'>Dine kommende veiledningstimer</h2>";
// Get the la's bookings
$laBookings = $conn->selectLaBookingFromDB($_SESSION['userID']);

if (empty($laBookings)) {
    echo "<p class='margin'>Du har ingen bookinger.</p>";
} else {
?>
    <table class="margin">
        <tr>
            <th class="th-item">Booking info</th>
            <th class="th-item">Tid og dato</th>
            <th class="th-item">Beskrivelse</th>
            <th class="th-item">Student</th>
        </tr>
    <?php
}
if ($user->role == "la") {
    foreach ($laBookings as $booking) {
        if ($booking->la == $_SESSION['userID']) {
            echo "<tr>";
            echo "<td style='border: 1px solid black; padding: 8px;'>" . $booking->bookingInfo . "</td>";
            $timeDate = $booking->timeDate;
            $dayOfWeek = preg_replace('/[0-9]+/', '', $timeDate); // Remove all numbers
            $dayOfWeekNorwegian = $daysInNorwegian[$dayOfWeek]; // Convert the day to Norwegian
            $time = preg_replace('/\D/', '', $timeDate); // Remove all non-numbers

            $formattedTimeDate = $dayOfWeekNorwegian . " kl. " . $time;

            echo "<td style='border: 1px solid black; padding: 8px;'>" . $formattedTimeDate . "</td>";
            echo "<td style='border: 1px solid black; padding: 8px;'>" . $booking->bookingDescription . "</td>";
            $student = $conn->selectUserFromDBUserId($booking->userID);
            if ($student == NULL) {
                echo "<td style='border: 1px solid black; padding: 8px;'>Ingen booking</td>";
            } else {
                echo "<td style='border: 1px solid black; padding: 8px;'>" . $student->fname . " " . $student->lname . "</td>";
            }
            echo "<td><form method='post' action=''>";
            echo "<input type='hidden' name='timeDate' value='" . $booking->timeDate . "'>"; // Add the hidden input field
            echo "<input type='submit' name='delete' value='Avbestill'></form></td>";
            echo "</tr>";
        }
    }
}
    ?>
    </table>


    <!-- Booking form -->

    <h1 class="margin">Booking system</h1>
    <p class="margin">
        Fyll inn feltene under for å gjøre deg selv som tilgjengelig hjelpelærer ved bestemt tidspunkt.
        <br />
        Du kan overskrive andre hjelpelærere sine tilgjengelige tidspunkt.
    </p>

    <!-- A form for booking a tutor-guidance session -->
    <form method="post" action="" id="bookingForm" class="margin" style="margin-top:15px;">
        <select name="day" form="bookingForm" title="Vennligst velg en dag.">
            <option value="day" hidden selected>Dag</option>
            <option value="monday">Mandag</option>
            <option value="tuesday">Tirsdag</option>
            <option value="wednesday">Onsdag</option>
            <option value="thursday">Torsdag</option>
            <option value="friday">Fredag</option>
        </select>
        <input type="number" name="time" min="8" max="17" placeholder="Tid" required title="Vennligst fyll inn et tidspunkt mellom 8 og 17." oninvalid="this.setCustomValidity('Vennligst fyll inn et tidspunkt mellom 8 og 17.')" oninput="this.setCustomValidity('')">
        <input type="submit" name="la" value="Gjør tilgjengelig">
        <?php
        if (isset($_SESSION['temp_message'])) {
            echo "<b>" . $_SESSION['temp_message'] . "</b>";
            $_SESSION['temp_message'] = "";
            unset($_SESSION['temp_message']);
        }
        ?>
    </form>

    <!-- A grid for displaying the calendar -->
    <div class="main-grid-container" style="border: 10px; width: 85%; height: auto;">
        <?php
        // Create the time and day sections of the calendar using functions from CalenderFunctions class
        $calender->createDates();
        $calender->createTime();
        $calender->createDay("monday");
        $calender->createDay("tuesday");
        $calender->createDay("wednesday");
        $calender->createDay("thursday");
        $calender->createDay("friday");

        if (isset($_REQUEST['reset'])) {
            $conn->reloadTables("weekdays");
        }
        ?>
        <form method="post" action="">
            <input type="submit" name="reset" value="Tilbakestill">
        </form>
    </div>