<?php

//error_reporting(0);
include("conn.php");

$roll =$_POST['roll'];
$num = $_POST['num'];
$point = (int)$num;
$stmt = $conn->prepare("SELECT ACF.nconf_id ACFID, ACF.att_date, ACF.sectionid,
ACF.conf_tid TIMETABLEID, ACF.timeToFr AS PeriodSlot, ACF.period, ACF.conf_subcode AS subjectcode,
ACF.conf_fname AS teacher, ACF.conf_fname2, ACF.stu_reg_id, DS.vsec_name AS SECNAME, DS.ncourse_id, 
IC.Cse_M_Name AS COURSE_NAME, DS.nbranch_id, IB.Brn_M_Name AS BRANCH_NAME, DS.nbatch_id AS BATCH, DS.sem AS SEMESTER, (

SELECT count( * )
FROM section_wise_student
WHERE section = ACF.sectionid
) 'tot'
FROM attendance_conf_faculty ACF
JOIN define_section DS ON DS.nsec_id = ACF.sectionid
JOIN iden_course IC ON IC.Cse_M_ID = DS.ncourse_id
LEFT JOIN iden_branch IB ON IB.Brn_M_ID = DS.nbranch_id
WHERE ACF.user = ?
ORDER BY ACF.att_date DESC
LIMIT ? , 20");

$stmt->bind_param('si', $roll, $point);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 
echo json_encode($res);
}

?>