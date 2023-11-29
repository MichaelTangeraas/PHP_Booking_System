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

if (isset($_REQUEST['la'])) {
    //GJØR LA TILGJENGELIG
}

// Check if the delete button has been pressed. If it has, reset the booking and refresh the page.
if (isset($_POST['delete'])) {
    $timeDate = $_POST['timeDate']; // Get the timeDate value from the form
    $conn->resetBookingToDB($timeDate);
    header('Location: ../public_html/index.php');
}

// Check if a booking request has been made
if (isset($_SESSION['userID'])) {
    $user = $conn->selectUserFromDBUserId($_SESSION['userID']);
    echo ("<h4 style='margin-left: 50px;'>Velkommen: " . ucfirst($user->role) . " - " . $user->fname . " " . $user->lname . "</h4>");
} else {
    echo ("<h4 style='margin-left: 50px;'>Funket ikke</h4>");
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

<h2 style="margin-left: 50px;">Dine bookinger</h2>
<?php
// Get the bookings from the database
$bookings = $conn->selectUserBookingFromDB($_SESSION['userID']);
// Check if a booking request has been made
if (empty($bookings)) {
    echo "<p style='margin-left: 50px;'>Du har ingen bookinger.</p>";
} else {
?>
    <table style="margin-left: 50px;">
        <tr>
            <th class="th-test">Booking info</th>
            <th class="th-test">Tid og dato</th>
            <!-- <th>Manipuler</th> -->
        </tr>
        <?php
        // Display the bookings
        foreach ($bookings as $booking) {
            if ($booking->userID == $_SESSION['userID']) {
                echo "<tr>";
                echo "<td style='border: 1px solid black; padding: 8px;'>" . $booking->bookingInfo . "</td>";
                $timeDate = $booking->timeDate;
                $dayOfWeek = preg_replace('/[0-9]+/', '', $timeDate); // Remove all numbers
                $dayOfWeekNorwegian = $daysInNorwegian[$dayOfWeek]; // Convert the day to Norwegian
                $time = preg_replace('/\D/', '', $timeDate); // Remove all non-numbers

                $formattedTimeDate = $dayOfWeekNorwegian . " kl. " . $time;

                echo "<td style='border: 1px solid black; padding: 8px;'>" . $formattedTimeDate . "</td>";
                echo "<td><form method='post' action=''>";
                echo "<input type='hidden' name='timeDate' value='" . $booking->timeDate . "'>"; // Add the hidden input field
                echo "<input type='submit' name='delete' value='Avbestill'></form></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
<?php
}
?>


<!-- Booking form -->

<h1 style="margin-left: 50px;">Booking system</h1>
<p style="margin-left: 50px;">
    Fyll inn feltet under for å booke en ønsket veiledningstime.
    <br />
    For å endre eksisterende booking, overskriv den med ny informasjon.
</p>

<!-- A form for booking a tutor-guidance session -->
<form method="post" action="" id="bookingForm" style="margin-left: 50px;margin-top:15px;">
    <?php
    if ($user->role == "student") {
        echo '<input type="text" name="text" placeholder="Booking info">';
    }
    ?>
    <select name="day" form="bookingForm">
        <option value="day" hidden selected>Dag</option>
        <option value="monday">Mandag</option>
        <option value="tuesday">Tirsdag</option>
        <option value="wednesday">Onsdag</option>
        <option value="thursday">Torsdag</option>
        <option value="friday">Fredag</option>
    </select>
    <input type="number" name="time" min="8" max="17" placeholder="Tid">
    <?php
    if ($user->role == "student") {
        echo '<input type="submit" name="booking" value="Book veiledning">';
    } else {
        echo '<input type="submit" name="la" value="Gjør tilgjengelig">';
    }
    ?>
    <?php
    if (isset($_COOKIE['temp_message'])) {
        echo "<b>" . $_COOKIE['temp_message'] . "</b>";
        // Unset the flash message cookie
        setcookie('temp_message', '', time() - 3600, "/");
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