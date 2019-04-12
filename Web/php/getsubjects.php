<?php

error_reporting(0);
 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$class_id=$_POST["class_id"];

$stmt = $conn->prepare('SELECT * FROM subject where class_id = ?');
$stmt->bind_param('s', $class_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 
	echo json_encode($res);
}
else
	{echo "0";}

mysql_close($con);



?>