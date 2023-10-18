<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <title>Hovedside</title>
    <style>
        .main-grid-container {
            display: grid;
            grid-template-columns: 100px auto auto auto auto auto;
            margin: 50px;
        }

        .large-grid-item {
            border: 1px solid;
            font-size: 20px;
            text-align: center;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto;
        }

        .grid-item {
            border-bottom: 1px solid;
            padding: 10px;
            font-size: 15px;
            text-align: center;
        }

        .calenderValue {
            border: 0;
            outline: 0;
        }

        .calenderValue:focus {
            outline: none !important;
        }
    </style>
</head>

<body>
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
   
    <?php
    function newValue($timeDate)
    {
        if (isset($_REQUEST['booking']) && $timeDate == $_REQUEST['day'].$_REQUEST['time']) {
            echo $_REQUEST['text'];
        } else {
            echo "Ledig";
        }
    }

    function createTime(){
        $time = 8;
        echo '<div class="large-grid-item">
        <div class="grid-container">';
        $i = -1;
        while ($i <=8){
            $i++;
            echo '<div class="grid-item">';
            echo $time++.":00";
            echo '</div>';
        }
        echo '</div></div>';
    }

    function createDay($day){
        $time = 8;
        $timeDate = $day.$time;
        echo '<div class="large-grid-item">
        <div class="grid-container">';
        $i = -1;
        while ($i <=8){
            $i++;
            $timeDate = $day.$time++;
            echo '<div class="grid-item">';
        newValue($timeDate);
        echo '</div>';
        }
        echo '</div></div>';
    }
    ?>

        <div class="main-grid-container" style="border: 10px">
            <div class="large-grid-item">Uke 42</div>
            <div class="large-grid-item">Mandag 16.10</div>
            <div class="large-grid-item">Tirsdag 17.10</div>
            <div class="large-grid-item">Onsdag 18.10</div>
            <div class="large-grid-item">Torsdag 19.10</div>
            <div class="large-grid-item">Fredag 20.10</div>

            <?php
            createTime();
            createDay("Mandag");
            createDay("Tirsdag");
            createDay("Onsdag");
            createDay("Torsdag");
            createDay("Fredag");
            ?>
            
            
        </div>
</body>

</html>