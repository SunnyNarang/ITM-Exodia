<?php
//error_reporting(0);

include("conn.php");

$section = $_POST['section'];


$stmt = $conn->prepare("SELECT conf_subcode as code,stu_reg_id as data FROM `attendance_conf_faculty` WHERE sectionid = ?");
$stmt->bind_param('i', $section);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 
    
}
else
	{echo "0";}
$stmt2 = $conn->prepare("SELECT distinct conf_subcode as code FROM `attendance_conf_faculty` WHERE sectionid = ?");
$stmt2->bind_param('i', $section);
$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows > 0) {
 while($r2=$result2->fetch_assoc())
 {
  $res2[] = $r2;
 }
 
    
}
else
	{echo "0";}
	
echo json_encode($res)."``%f%``".json_encode($res2);


?>