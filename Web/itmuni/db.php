<?php
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itmuni";
    $dbport = 3306;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $dbport);
if (!$conn){header('Location: 404.php');};
?>