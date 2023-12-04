<!-- Booking System -->
<?php
include("../classes/calender.php");
include_once("../classes/database.php");
require_once("../classes/inputValidator.php");

// Initialize the database connection and the calender
$calender = new Calender($pdo);
$conn = new Database($pdo);
$validator = new inputValidator();

if (isset($_POST['booking'])) {
    $inputError = false;
    $_SESSION['temp_message'] = "Tittel for veiledning må fylles ut.<br>";

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
    } elseif ($_POST['time'] < 8 || $_POST['time'] > 17) {
        $_SESSION['temp_message'] = "Velg en tid mellom 8 og 17.<br>";
        $inputError = true;
    }

    if (strlen($_POST['textDesc']) >= 200) {
        $_SESSION['temp_message'] = "Beskrivelse for veiledning kan ikke være mer enn 200 tegn langt.<br>";
        $inputError = true;
    }

    if (!$inputError) {
        $timeDate = $_POST['day'] . $_POST['time']; // Get the day and time from the form
        $weekday = $conn->selectBookingFromDB($timeDate);
        $userID = $_SESSION['userID'];
        // If the time slot is not booked or is booked by the current user, update the booking
        if ($weekday->userID == NULL || $weekday->userID == $userID) {
            $_SESSION['temp_message'] = "Veiledningen er booket";
            $conn->updateBookingToDB($validator->cleanString($_POST['text']), $validator->cleanString($_POST['textDesc']), $timeDate, $userID);
        } else {
            $_SESSION['temp_message'] = "Veiledningen er opptatt";
        }
    }
}


// Check if a booking request has been made. Refresh the page if it has.
if (isset($_REQUEST['booking'])) {
    //header('Location: ../public_html/index.php');
    //echo $_SESSION['temp_message'];
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

<h1 class="margin">Dine bookinger</h1>
<?php
// Get the user's bookings
$userBookings = $conn->selectUserBookingFromDB($_SESSION['userID']);
if (empty($userBookings) && empty($laBookings)) {
    echo "<p class='margin'>Du har ingen bookinger.</p>";
} else {
?>
    <table class="margin">
        <tr>
            <th class="th-item">Booking info</th>
            <th class="th-item">Tid og dato</th>
            <th class="th-item">Beskrivelse</th>
            <th class="th-item">LA</th>
        </tr>
    <?php
    // Display the bookings
    foreach ($userBookings as $booking) {
        if ($booking->userID == $_SESSION['userID']) {
            echo "<tr>";
            echo "<td style='border: 1px solid black; padding: 8px;'>" . $booking->bookingInfo . "</td>";
            $timeDate = $booking->timeDate;
            $dayOfWeek = preg_replace('/[0-9]+/', '', $timeDate); // Remove all numbers
            $dayOfWeekNorwegian = $daysInNorwegian[$dayOfWeek]; // Convert the day to Norwegian
            $time = preg_replace('/\D/', '', $timeDate); // Remove all non-numbers

            $formattedTimeDate = $dayOfWeekNorwegian . " kl. " . $time;

            echo "<td style='border: 1px solid black; padding: 8px;'>" . $formattedTimeDate . "</td>";
            echo "<td style='border: 1px solid black; padding: 8px;'>" . $booking->bookingDescription . "</td>";
            $la = $conn->selectUserFromDBUserId($booking->la);
            if ($la == NULL) {
                echo "<td style='border: 1px solid black; padding: 8px;'>Ingen LA</td>";
            } else {
                echo "<td style='border: 1px solid black; padding: 8px;'>" . $la->fname . " " . $la->lname . "</td>";
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
        Fyll inn feltet under for å booke en ønsket veiledningstime.
        <br />
        <b>Tittel, dag og tidspunkt er påkrevd.</b> Beskrivelse er valgfritt.
        <br />
        For å endre eksisterende booking, overskriv den med ny informasjon.
    </p>

    <!-- A form for booking a tutor-guidance session -->
    <form method="post" action="" id="bookingForm" class="margin" style="margin-top:15px;">
        <input type="text" name="text" placeholder="Tittel for veiledning" required minlength="5" maxlength="50" title="Vennligst fyll inn en tittel mellom 5 og 50 tegn." oninvalid="this.setCustomValidity('Vennligst fyll inn en tittel mellom 5 og 50 tegn.')" oninput="this.setCustomValidity('')">
        <select name="day" form="bookingForm" title="Vennligst velg en dag.">
            <option value="day" hidden selected>Dag</option>
            <option value="monday">Mandag</option>
            <option value="tuesday">Tirsdag</option>
            <option value="wednesday">Onsdag</option>
            <option value="thursday">Torsdag</option>
            <option value="friday">Fredag</option>
        </select>
        <input type="number" name="time" min="8" max="17" placeholder="Tid" required title="Vennligst fyll inn et tidspunkt mellom 8 og 17." oninvalid="this.setCustomValidity('Vennligst fyll inn et tidspunkt mellom 8 og 17.')" oninput="this.setCustomValidity('')">
        <input type="submit" name="booking" value="Book veiledning">
        <br>
        <textarea name="textDesc" rows="4" cols="39" placeholder="Beskrivelse for veiledning" maxlength="200" title="Vennligst fyll inn en beskrivelse innen 200 tegn."></textarea>
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