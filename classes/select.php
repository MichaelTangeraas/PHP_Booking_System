<?php
require_once('../includes/db.inc.php');

$sql = "SELECT *
        FROM monday
        WHERE timeDate = :timeDate";
$q = $pdo->prepare($sql);
$q->bindParam(':timeDate', $timeDate, PDO::PARAM_STR);

$timeDate = "monday16";

try {
    $q->execute();
} catch (PDOException $e) {
    echo "Error querying database: " . $e->getMessage() . "<br>"; // Aldri gjør dette i produksjon!
}
//Only for debugging
//$q->debugDumpParams();

$monday = $q->fetchAll(PDO::FETCH_OBJ); // Bruk FETCH_ASSOC for å returnere en matrise istedenfor
//$user = $q->fetchAll(PDO::FETCH_OBJ);

if($q->rowCount() > 0) {
    foreach($monday as $m) {
        echo $m->primary_key. " // ";
        echo $m->timeDate. " // ";
        echo $m->text. " // ";
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

?>