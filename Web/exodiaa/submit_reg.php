<?php
ob_start();
session_start();
error_reporting(0);
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
if(!$_POST['checkedstatus']){die("No students selected !");} else{
$u_class=$_POST['ultimate_class'];
$att_checked_status=$_POST['checkedstatus'];
foreach ($att_checked_status as $key => $att_status_q) {
	$stmt = $conn->prepare('SELECT roll,name,email,dob,f_name,f_mob,address1,address2,phone,city from temp_students where roll=?');
	$stmt->bind_param("s", $att_status_q);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) { 
		while($row = $result->fetch_assoc()) {	
			$temp_roll=$row['roll'];
			$temp_name=$row['name'];
			$temp_email=$row['email'];
			$temp_dob=$row['dob'];
			$temp_f_name=$row['f_name'];
			$temp_f_mob=$row['f_mob'];
			$temp_address1=$row['address1'];
			$temp_address2=$row['address2'];
			$temp_phone=$row['phone'];
			$temp_city=$row['city'];
			$temp_batch="B1";
			$stmtq = $conn->prepare('insert into student(roll,name,email,dob,f_name,f_mob,address1,address2,city,phone,batch,class_id) values(?,?,?,?,?,?,?,?,?,?,?,?)');
			$stmtq->bind_param('ssssssssssss', $temp_roll, $temp_name, $temp_email, $temp_dob, $temp_f_name, $temp_f_mob, $temp_address1, $temp_address2, $temp_city, $temp_phone, $temp_batch, $u_class);
			if($stmtq->execute()){
				$stmta = $conn->prepare('delete from temp_students where roll=?');
				$stmta->bind_param("s", $att_status_q);
				if($stmta->execute()){echo "".$att_status_q." was moved successfully.<br>";}
			}
		}	
	}
}

}
?>