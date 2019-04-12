<?php
error_reporting(0);
include("conn.php");
$roll=$_POST["roll"];
$custom=$_POST["custom"];
$class_id=$_POST["class_id"];
$sub_id=$_POST["sub_id"];
$to=$_POST["to"];
$from=$_POST["from"];


if($custom=='0'){


$stmt = $conn->prepare("SELECT attendance.roll AS nroll, student.name,student.batch, (

SELECT count( * )
FROM attendance
WHERE roll = nroll
AND class_id =?
AND sub_id =?
AND STATUS =1
) AS present, (

SELECT count( * )
FROM attendance
WHERE roll = nroll
AND class_id =?
AND sub_id =?
) AS out_of
FROM attendance
INNER JOIN student ON student.roll = attendance.roll
WHERE attendance.class_id =?
AND attendance.sub_id =?
GROUP BY attendance.roll");
$stmt->bind_param('ssssss',$class_id,$sub_id,$class_id,$sub_id,$class_id,$sub_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())
    {
       $res[]=$row;
        
    }
    echo json_encode($res);
}
else
	{echo "0";}}
	
	
	else{
	 
	 
$stmt = $conn->prepare("
SELECT attendance.roll AS nroll, student.name,student.batch, (

SELECT count( * )
FROM attendance
WHERE roll = nroll
AND class_id =?
AND sub_id =?
and att_date between DATE(?) and DATE(?)
AND STATUS =1
) AS present, (

SELECT count( * )
FROM attendance
WHERE roll = nroll
AND class_id =?
AND sub_id =?
and att_date between DATE(?) and DATE(?)
) AS out_of
FROM attendance
INNER JOIN student ON student.roll = attendance.roll
WHERE attendance.class_id =?
AND attendance.sub_id =?
GROUP BY attendance.roll ");
$stmt->bind_param('ssssssssss',$class_id,$sub_id,$from,$to,$class_id,$sub_id,$from,$to,$class_id,$sub_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())
    {
       $res[]=$row;
        
    }
    echo json_encode($res);
}
else
	{echo "0";}
	}
mysql_close($con);
?>



