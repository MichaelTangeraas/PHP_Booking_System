<!-- Booking System -->
<?php
include("../classes/calender.php");
include("../classes/reload.php");
$calender = new Calender($pdo);
$reload = new Reload($pdo);
?>

<!-- A form for booking a tutor-guidance session -->
<form method="post" action="" id="bookingForm" style="margin-left: 50px;margin-top:25px;">
    <input type="submit" name="booking" value="Book veiledning">
    <input type="text" name="text" placeholder="Booking info">
    <select name="day" form="bookingForm">
        <option value="day" hidden selected>Dag</option>
        <option value="monday">Mandag</option>
        <option value="tuesday">Tirsdag</option>
        <option value="wednesday">Onsdag</option>
        <option value="thursday">Torsdag</option>
        <option value="friday">Fredag</option>
    </select>
    <input type="number" name="time" min="8" max="17" placeholder="Tid">
    <input type="submit" name="reset" value="Tilbakestill">
</form>


<!-- A grid for displaying the calendar -->
<div class="main-grid-container" style="border: 10px">
    <div class="large-grid-item">Uke 42</div>
    <div class="large-grid-item">Mandag 16.10</div>
    <div class="large-grid-item">Tirsdag 17.10</div>
    <div class="large-grid-item">Onsdag 18.10</div>
    <div class="large-grid-item">Torsdag 19.10</div>
    <div class="large-grid-item">Fredag 20.10</div>

    <?php
    // Create the time and day sections of the calendar using functions from CalenderFunctions class
    $calender->createTime();
    $calender->createDay("monday");
    $calender->createDay("tuesday");
    $calender->createDay("wednesday");
    $calender->createDay("thursday");
    $calender->createDay("friday");

    if (isset($_REQUEST['reset'])) {
        $reload->reloadWeekdays($pdo);
    }
    ?>

</div>