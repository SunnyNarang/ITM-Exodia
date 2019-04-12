<?php

error_reporting(0);
 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);

$roll = $_POST['roll'];
$num = $_POST['num'];
$point = (int)$num;
$stmt = $conn->prepare("SELECT DISTINCT class.course, attendance.att_date, attendance.sub_id, attendance.class_id, class.name AS class_name,subject.type, subject.code AS subject_name,attendance.time, class.branch, class.sem
FROM attendance
INNER JOIN class ON class.id = attendance.class_id
INNER JOIN subject ON subject.id = attendance.sub_id
WHERE attendance.teacher_roll =  ? order by att_date desc
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