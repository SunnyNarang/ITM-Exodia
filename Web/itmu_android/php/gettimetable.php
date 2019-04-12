<?php
error_reporting(0);
include("conn.php");
$class_id=$_POST["class_id"];

$batch=$_POST["batch"];


$stmt = $conn->prepare('select routine.day,routine.start_time,routine.end_time,subject.name,subject.code
from routine
join subject
on subject.id = routine.sub_id
where routine.class_id=? And (routine.batch=? || routine.batch="0")
order by routine.start_time');
$stmt->bind_param('ss', $class_id,$batch);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 
	echo json_encode($res);//hahahaha....i'm watching u :p
}
else
	{echo "0";}

mysql_close($con);


?>