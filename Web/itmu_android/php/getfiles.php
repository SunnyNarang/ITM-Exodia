<?php

error_reporting(0);
include("conn.php");

$id=$_POST["id"];
$roll = $_POST["roll"];



$stmt1 = $conn->prepare('select count(*) as went from (SELECT * FROM attendance where roll = ? and status = "1") s');
		$stmt1->bind_param('s', $roll);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		if ($result1->num_rows > 0) {
	   while($row1 = $result1->fetch_assoc()){
	   $hewent=$row1['went'];}}else{$hewent="00";}
	   
$stmt2 = $conn->prepare('select count(*) as otal from (SELECT * FROM attendance where roll = ? ) s');
		$stmt2->bind_param('s', $roll);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		if ($result2->num_rows > 0) {
	   while($row2 = $result2->fetch_assoc()){
	   $otal=$row2['otal'];}}else{$otal="00";}
	   
$percentage= round($hewent/$otal*100,1); 

if($percentage>=30){

$stmt = $conn->prepare('SELECT notes.description as description, notes.title as title, notes.file as file, teacher.name as t_name, teacher.roll as t_roll FROM notes inner join teacher on notes.teacher_id=teacher.roll where notes.sub_id = ?');
$stmt->bind_param('s', $id);
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
}


else{
 
 echo "10";
 
 
}


mysql_close($con);



?>