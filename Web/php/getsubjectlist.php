<?php

error_reporting(0);
 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);



$stmt = $conn->prepare('SELECT distinct subject.type,subject.id,subject.name, subject.code, class.branch, class.sem, class.course,subject.class_id
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
$stmt3 = $conn->prepare('select distinct name,branch,sem,course,id from class
');
$stmt3->execute();
$result3 = $stmt3->get_result();
if ($result3->num_rows > 0) {
 while($r3=$result3->fetch_assoc())
 {
  $res3[] = $r3;
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
$stmt5 = $conn->prepare('SELECT DISTINCT batch
FROM student');
$stmt5->execute();
$result5 = $stmt5->get_result();
if ($result5->num_rows > 0) {
 while($r5=$result5->fetch_assoc())
 {
  $res5[] = $r5;
 }
 
}
$stmt6 = $conn->prepare('SELECT DISTINCT start_time,end_time
FROM routine');
$stmt6->execute();
$result6 = $stmt6->get_result();
if ($result6->num_rows > 0) {
 while($r6=$result6->fetch_assoc())
 {
  $res6[] = $r6;
 }
 
}
	echo json_encode($res2)."``%f%``".json_encode($res1)."``%f%``".json_encode($res4)."``%f%``".json_encode($res3)."``%f%``".json_encode($res)."``%f%``".json_encode($res5)."``%f%``".json_encode($res6);
mysql_close($con);

?>