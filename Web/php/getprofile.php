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

$stmt = $conn->prepare('select * from attendance where roll =?');
$stmt->bind_param('s', $roll);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 

$stmt = $conn->prepare('SELECT student. * , student.roll AS nroll,class.name as class_name,class.branch,class.sem, (

SELECT COUNT( * ) 
FROM attendance
WHERE roll = nroll
AND STATUS =1
) AS present, (

SELECT COUNT( * ) 
FROM attendance
WHERE roll = nroll
) AS out_of
FROM student
JOIN class ON student.class_id = class.id
JOIN attendance ON student.roll = attendance.roll
WHERE student.roll =  ?
GROUP BY student.roll');
$stmt->bind_param('s', $roll);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 $r=$result->fetch_assoc();
 
	echo json_encode($r);//hahahaha....i'm watching u :p
}
else
	{echo "0";}
}
else
	{
$stmt = $conn->prepare('SELECT student. * , student.roll AS nroll,class.name as class_name,class.branch,class.sem 
FROM student
JOIN class ON student.class_id = class.id
WHERE student.roll =  ?
GROUP BY student.roll');
$stmt->bind_param('s', $roll);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 $r=$result->fetch_assoc();
 
	echo json_encode($r);//hahahaha....i'm watching u :p
}
else
	{echo "0";}}


mysql_close($conn);
?>