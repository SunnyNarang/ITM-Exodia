<?php

error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "c9";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$roll=$_POST["sender"];

$stmt1 = $conn->prepare('UPDATE login set activestatus="0" where roll=?');
$stmt1->bind_param('s', $roll);
$stmt1->execute();

?>