<?php

error_reporting(0);
include("conn.php");
$stmt = $conn->prepare('SELECT distinct subject.type,subject.name, subject.code, class.branch, class.sem, class.course
FROM subject
inner join class
on subject.class_id = class.id
');
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 

}
$stmt2 = $conn->prepare('SELECT course
FROM class
GROUP BY course
');
$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows > 0) {
 while($r2=$result2->fetch_assoc())
 {
  $res2[] = $r2;
 }
 
}
$stmt4 = $conn->prepare('select distinct course , sem from class');
$stmt4->execute();
$result4 = $stmt4->get_result();
if ($result4->num_rows > 0) {
 while($r4=$result4->fetch_assoc())
 {
  $res4[] = $r4;
 }
 
}
$stmt1 = $conn->prepare('SELECT distinct branch,course
FROM class
');
$stmt1->execute();
$result1 = $stmt1->get_result();
if ($result1->num_rows > 0) {
 while($r1=$result1->fetch_assoc())
 {
  $res1[] = $r1;
 }
 

}

	echo json_encode($res2)."``%f%``".json_encode($res4)."``%f%``".json_encode($res)."``%f%``".json_encode($res1);
mysql_close($con);

?>