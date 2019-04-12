<?php

error_reporting(0);
include("conn.php");
    $roll=$_POST["roll"];
    $class_id=$_POST["class_id"];
    $result="";
    
$stmt1 = $conn->prepare('select count(*) as went from (SELECT * FROM attendance where roll = ? and status = "1" and class_id = ?) s');
		$stmt1->bind_param('ss', $roll,$class_id);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		if ($result1->num_rows > 0) {
		    
	   while($row1 = $result1->fetch_assoc()){
	  $went=$row1['went'];
	       
	   }
		    
		}else{$went="00";}
	   
$stmt2 = $conn->prepare('select count(*) as otal from (SELECT * FROM attendance where roll = ? and class_id = ? ) s');
		$stmt2->bind_param('ss', $roll,$class_id);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		if ($result2->num_rows > 0) {
		    
	   while($row2 = $result2->fetch_assoc()){
            $total=$row2['otal'];
        }   
		}else{$total="00";}
		
		
		
		$stmt3 = $conn->prepare('SELECT * FROM subject where class_id = ?');
$stmt3->bind_param('s', $class_id);
$stmt3->execute();
$result3 = $stmt3->get_result();
if ($result3->num_rows > 0) {
    while($row = $result3->fetch_assoc()) {
	   $mon_sub_id=$row['id'];
	   $mon_sub_code=$row['code'];
	   $mon_name=$row['name'];
	   $mon_sub_type=$row['type'];
	   $sub_teacher=$row['teacher_roll'];
	   
	    $stmt0 = $conn->prepare('SELECT name as t_name FROM teacher where roll = ?');
		$stmt0->bind_param('s', $sub_teacher);
		$stmt0->execute();
		$result0 = $stmt0->get_result();
	   while($row0 = $result0->fetch_assoc()){
	   $teacher_name=$row0['t_name'];}
	   
	    $stmt4 = $conn->prepare('select count(*) as went from (SELECT * FROM attendance where roll = ? and sub_id = ? and status = "1") s');
		$stmt4->bind_param('ss', $roll, $mon_sub_id);
		$stmt4->execute();
		$result4 = $stmt4->get_result();
		if ($result4->num_rows > 0) {
	   while($row4 = $result4->fetch_assoc()){
	   $hewent=$row4['went'];}}else{$hewent="00";}
	   
	    $stmt5 = $conn->prepare('select count(*) as otal from (SELECT * FROM attendance where roll = ? and sub_id = ?) s');
		$stmt5->bind_param('ss', $roll, $mon_sub_id);
		$stmt5->execute();
		$result5 = $stmt5->get_result();
		if ($result5->num_rows > 0) {
	   while($row5 = $result5->fetch_assoc()){
	   $otal=$row5['otal'];}}else{$otal="00";}
	   
	   if($result=="")
	   {
	   	$result='[{"name":"'.$mon_name.'","code":"'.$mon_sub_code.'","type":"'.$mon_sub_type.'","went":"'.$hewent.'","total":"'.$otal.'"}]';
	   	
	   }
	   else{
	   	$yo = explode("]",$result);
	   	$result = $yo[0].',{"name":"'.$mon_name.'","code":"'.$mon_sub_code.'","type":"'.$mon_sub_type.'","went":"'.$hewent.'","total":"'.$otal.'"}]';
	   }
	   
	   
}
}

echo  $went."``%f%``".$total."``%f%``".$result;

mysql_close($con);

?>