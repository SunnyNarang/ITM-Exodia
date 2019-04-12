<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);

    $roll=$_POST["roll"];


$stmt = $conn->prepare('SELECT  notice.title as title, notice.body as body, 
notice.notice_date as n_date, teacher.name as t_name FROM notice 
inner join teacher on teacher.roll=notice.t_id where notice.type= 2 or notice.type= 3  Order by notice.notice_date DESC LIMIT 0 , 20');


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