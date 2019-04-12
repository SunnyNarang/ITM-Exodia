<?php
error_reporting(0);
include("conn.php");
$section=$_POST["section"];

$stmt = $conn->prepare("select vstu_rollno,vstu_name from section_wise_student 
where section=? and ncourse_id=(select ncourse_id  from define_section where nsec_id =?)");
$stmt->bind_param('ss',$section,$section);

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