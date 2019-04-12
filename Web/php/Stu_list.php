<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);
 $course=$_POST["course"];
 $sem=$_POST["sem"];
 $branch=$_POST["branch"];
 $class=$_POST["class"];

$stmt = $conn->prepare("SELECT login.image,student.batch,student.name,student.roll from student inner join class on student.class_id=class.id inner join login on login.roll = student.roll where class.course=? and class.sem=? and class.branch=? and class.name=?");
$stmt->bind_param('siss', $course,$sem,$branch,$class);
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