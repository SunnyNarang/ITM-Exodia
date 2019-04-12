<?php

error_reporting(0);

include("conn.php");
$roll=$_POST["sender"];

$stmt1 = $conn->prepare('UPDATE login set activestatus="0" where roll=?');
$stmt1->bind_param('s', $roll);
$stmt1->execute();

?>