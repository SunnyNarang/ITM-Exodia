<?php

error_reporting(0);
include("conn.php");


$stmt = $conn->prepare("SELECT Syl_M_SubRefCode as subject, Syl_M_Course as c_id, Syl_M_Branch as br_id, Syl_M_wefYear as batch, Syl_M_Sem as sem
FROM  `itm_zone_syllabus");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 

}
$stmt1 = $conn->prepare('SELECT  Brn_M_ID as br_id,Brn_M_Name as br_name,Brn_M_CourseID as c_id FROM `iden_branch`
');//SELECT distinct branch,course FROM class
$stmt1->execute();
$result1 = $stmt1->get_result();
if ($result1->num_rows > 0) {
 while($r1=$result1->fetch_assoc())
 {
  $res1[] = $r1;
 }
 

}
$stmt2 = $conn->prepare('select Syl_M_Course as c_id, (select Cse_M_Name from iden_course where iden_course.Cse_M_ID=itm_zone_syllabus.Syl_M_Course ) as course  from  itm_zone_syllabus where itm_zone_syllabus.Syl_M_Course in (select ncourse_id from define_section) group by Syl_M_Course
');
$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows > 0) {
 while($r2=$result2->fetch_assoc())
 {
  $res2[] = $r2;
 }
 

}
$stmt3 = $conn->prepare("SELECT id, (

SELECT DISTINCT Cse_M_Name
FROM iden_course
WHERE iden_course.Cse_M_ID = tbl_itm_zone_attandance_cust.course
) 'course1', (

SELECT DISTINCT Brn_M_Name
FROM iden_branch
WHERE Brn_M_ID = tbl_itm_zone_attandance_cust.school
) 'school1', sem, batch, total1, userby, TIME, (

SELECT vsec_name
FROM define_section
WHERE nsec_id = tbl_itm_zone_attandance_cust.section
)sectionName, section, course AS c_id, school AS br_id, (

SELECT sem
FROM define_section
WHERE nsec_id = tbl_itm_zone_attandance_cust.section
) 'sem', (

SELECT id
FROM define_section
WHERE nsec_id = tbl_itm_zone_attandance_cust.section
) 'tid'
FROM tbl_itm_zone_attandance_cust
");
$stmt3->execute();
$result3 = $stmt3->get_result();
if ($result3->num_rows > 0) {
 while($r3=$result3->fetch_assoc())
 {
  $res3[] = $r3;
 }
 
}


$stmt6 = $conn->prepare("SELECT * 
FROM  `section_timing`");
$stmt6->execute();
$result6 = $stmt6->get_result();
if ($result6->num_rows > 0) {
 while($r6=$result6->fetch_assoc())
 {
  $res6[] = $r6;
 }
 
}
 
	echo
	json_encode($res2)."``%f%``".
	json_encode($res1)."``%f%``".
	json_encode($res3)."``%f%``".
	json_encode($res)."``%f%``".
	json_encode($res6).
	"";

?>