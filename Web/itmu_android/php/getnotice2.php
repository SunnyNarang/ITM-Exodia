<?php
error_reporting(0);
include("conn.php");
    $roll=$_POST["roll"];


$stmt = $conn->prepare("SELECT message_title AS title, message AS body, TIMESTAMP AS n_date, byuser AS t_name
FROM itm_zone_notice
WHERE is_active =  'YES'
LIMIT 0 , 30");


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