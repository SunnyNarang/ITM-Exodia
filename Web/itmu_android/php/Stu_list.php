<?php
error_reporting(0);

include("conn.php");
 $courseType= $_POST["CourseType"];
 $branchType= $_POST["BranchType"];
 $sec= $_POST["Section"];

$stmt = $conn->prepare("SELECT def.nsec_id as 'secid',def.vsec_name as 'section' ,stu.vstu_name as 'name',stu.vstu_rollno
as 'rollno'  FROM section_wise_student stu  join define_section  def on def.nsec_id=stu.section 
WHERE stu.ncourse_id=?  and stu.nbranch_id=?  and stu.section=?  order by stu.vstu_rollno");
$stmt->bind_param('ssi', $courseType,$branchType,$sec);
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