<?php
require_once('../includes/db.inc.php');
class Reload{
    public $q;

    public function __construct($pdo)
    {
        $sql = "DROP TABLE IF EXISTS weekdays;

        CREATE TABLE weekdays (
            primary_key INT AUTO_INCREMENT PRIMARY KEY,
            timeDate VARCHAR(255),
            bookingInfo VARCHAR(255) DEFAULT 'Ledig time'
        );
        
        INSERT INTO weekdays (timeDate) VALUES
        ('monday8'),('monday9'),('monday10'),('monday11'),('monday12'),('monday13'),('monday14'),('monday15'),('monday16'),('monday17'),
        ('tuesday8'),('tuesday9'),('tuesday10'),('tuesday11'),('tuesday12'),('tuesday13'),('tuesday14'),('tuesday15'),('tuesday16'),('tuesday17'),
        ('wednesday8'),('wednesday9'),('wednesday10'),('wednesday11'),('wednesday12'),('wednesday13'),('wednesday14'),('wednesday15'),('wednesday16'),('wednesday17'),
        ('thursday8'),('thursday9'),('thursday10'),('thursday11'),('thursday12'),('thursday13'),('thursday14'),('thursday15'),('thursday16'),('thursday17'),
        ('friday8'),('friday9'),('friday10'),('friday11'),('friday12'),('friday13'),('friday14'),('friday15'),('friday16'),('friday17');";

        $this->q = $pdo->prepare($sql);
    }
    
    public function reloadWeekdays()
    {
        try {
            $this->q->execute();
        } catch (PDOException $e) {
            echo "Error querying database: " . $e->getMessage() . "<br>"; // Aldri gjør dette i produksjon!
        }
    }
}
?>