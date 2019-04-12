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
$class_id = $_POST["class_id"];
$subject_id=$_POST["subject_id"];
$date = $_POST["date"];
$time = $_POST["time"];

$stmt = $conn->prepare("select attendance.roll,student.name,attendance.status from attendance inner join student on 
student.roll = attendance.roll where attendance.teacher_roll =? and attendance.class_id = ? and attendance.sub_id = ?
and attendance.att_date =? and attendance.time = ?");
$stmt->bind_param('sssss',$roll, $class_id,$subject_id,$date,$time);

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