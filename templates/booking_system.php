<!-- Booking System -->
<?php
include("../classes/calender.php");
$calender = new Calender();
?>

<!-- A form for booking a tutor-guidance session -->
<form method="post" action="" id="bookingForm" style="margin-left: 50px;margin-top:25px;">
    <input type="submit" name="booking" value="Book veiledning">
    <input type="text" name="text" placeholder="Booking info">
    <select name="day" form="bookingForm">
        <option value="" disabled selected>Dag</option>
        <option value="Mandag">Mandag</option>
        <option value="Tirsdag">Tirsdag</option>
        <option value="Onsdag">Onsdag</option>
        <option value="Torsdag">Torsdag</option>
        <option value="Fredag">Fredag</option>
    </select>
    <input type="number" name="time" min="8" max="17" placeholder="Tid">
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
    $calender->createDay("Mandag");
    $calender->createDay("Tirsdag");
    $calender->createDay("Onsdag");
    $calender->createDay("Torsdag");
    $calender->createDay("Fredag");
    ?>

</div>