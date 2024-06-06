<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','ExamenDB');

class Database
{
    public $con;


    function __construct()
    //deze functie zorgt voor de conectie tussen de database en de code
    {
        $this->con = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        if ($this->con) {
            echo "Connection succesfull";
        } else {
            echo "Connection Not succesfull";
        }
    }

    function Create($Name, $GltfPath)
    //deze functie zorgt voor ervoor dat je iets in de tabel 3dModels kan toevoegen en maakt gebruik van een insert statement
    {
        $sql = "INSERT INTO 3dModels (Name, GltfPath) VALUES (:Name, :GltfPath)";
        $stmt = $this->con->prepare($sql);
        try {
            // Use an associative array with keys that match the placeholders, including the colon
            $stmt->execute([':Name' => $Name, ':GltfPath' => $GltfPath]);
            echo "IT WORKS";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    function GetModels()
    //deze functie zorgt ervoor dat je dingen uit de tabel 3dModels kan lezen met een select functie
    {
        $sql = "SELECT * FROM 3dModels";
        $stmt = $this->con->query($sql);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo $row["name"];
        }
    }
}
?>