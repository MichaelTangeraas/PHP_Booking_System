<?php
require_once('../includes/db.inc.php');
class Select
{
    public $q;

    public function __construct($pdo, $timeDate)
    {
        $sql = "SELECT * FROM weekdays WHERE timeDate = :timeDate";
        $this->q = $pdo->prepare($sql);
        $this->q->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);
    }

    function selectFromDB()
    {
        try {
            $this->q->execute();
        } catch (PDOException $e) {
            echo "Error querying database: " . $e->getMessage() . "<br>"; // Aldri gjør dette i produksjon!
        }
        //Only for debugging
        //$q->debugDumpParams();

        $weekdays = $this->q->fetchAll(PDO::FETCH_OBJ); // Bruk FETCH_ASSOC for å returnere en matrise istedenfor
        //$user = $q->fetchAll(PDO::FETCH_OBJ);

        if ($this->q->rowCount() > 0) {
            foreach ($weekdays as $m) {
                //echo $m->primary_key. " // ";
                //echo $m->timeDate. " // ";
                echo $m->bookingInfo;
            }
        } else {
            echo "The query resulted in an empty result set.";
        }

        /*$sql = "SELECT u.firstname, u.lastname, u.zip, c.city 
        FROM users AS u 
        LEFT JOIN cities AS c ON (u.zip = c.zip) 
        WHERE u.zip > :zip";
    $q = $pdo->prepare($sql);
    $q->bindParam(':zip', $zip, PDO::PARAM_INT);
    $zip = 4500;*/
    }
}
?>