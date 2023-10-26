<?php
require_once('../includes/db.inc.php');
class Update{
    public $q;

    public function __construct($pdo, $bookingInfo, $timeDate)
    {
        $sql = "UPDATE weekdays SET bookingInfo = :bookingInfo WHERE timeDate = :timeDate";
        $this->q = $pdo->prepare($sql);
        $this->q->bindParam(':bookingInfo' , $bookingInfo , PDO::PARAM_STR);
        $this->q->bindParam(':timeDate' , $timeDate , PDO::PARAM_STR);
    }
    
    public function updateToDB()
    {
        try {
            $this->q->execute();
        } catch (PDOException $e) {
            echo "Error querying database: " . $e->getMessage() . "<br>"; // Aldri gjør dette i produksjon!
        }
        //$this->q->debugDumpParams();
          
        /*if($q->rowCount() > 0) {
            echo $q->rowCount() . " record" . ($q->rowCount() != 1 ? "s were " : " was ") . "updated.";
        } elseif($q->rowCount() == 0) {
            echo "The record was not updated (no change).";
        } else {
            echo "The record was not updated.";
        }*/
    }
}
?>