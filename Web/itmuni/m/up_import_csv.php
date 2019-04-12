<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$csv_course=$_POST['admit_course'];
$csv_branch=$_POST['admit_branch'];
$csv_sem=$_POST['admit_sem'];
$csv_roll=$_POST['csv_roll'];
$csv_name=$_POST['csv_name'];
$csv_email=$_POST['csv_email'];
$csv_dob=$_POST['csv_dob'];
$csv_g_name=$_POST['csv_g_name'];
$csv_g_mob=$_POST['csv_g_mob'];
$csv_address1=$_POST['csv_address1'];
$csv_address2=$_POST['csv_address2'];
$csv_phone=$_POST['csv_phone'];
$csv_city=$_POST['csv_city'];
$zipped = array_map(null, $csv_roll, $csv_name, $csv_email, $csv_dob, $csv_g_name, $csv_g_mob, $csv_address1, $csv_address2, $csv_phone, $csv_city);

foreach($zipped as $tuple) {
    // here you could do list($n, $t) = $tuple; to get pretty variable names
    $new_roll= $tuple[0]; // name
    $new_name= $tuple[1]; // type
	$new_email= $tuple[2];
	$new_dob= $tuple[3];
	$new_g_name= $tuple[4];
	$new_g_mob= $tuple[5];
	$new_address1= $tuple[6];
	$new_address2= $tuple[7];
	$new_phone= $tuple[8];
	$new_city= $tuple[9];

//verify roll n email	
$stmt = $conn->prepare('SELECT roll from temp_students where roll=? or email=?');
$stmt->bind_param("ss", $new_roll, $new_email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	die("Roll or Email Already Exists !");
} else{
	$stmtq = $conn->prepare('SELECT roll from student where roll=? or email=?');
	$stmtq->bind_param("ss", $new_roll, $new_email);
	$stmtq->execute();
	$resultq = $stmtq->get_result();
	if ($resultq->num_rows > 0) {
		die ("Roll or Email Already Registered !");
	} else {
		$stmtqzz = $conn->prepare('SELECT roll from student where roll=? or email=?');
	$stmtqzz->bind_param("ss", $new_roll, $new_email);
	$stmtqzz->execute();
	$resultqzz = $stmtqzz->get_result();
	if ($resultqzz->num_rows > 0) {
		die ("Roll or Email Already Exists !");
	}
	}
}

$new_image=$new_roll."jpeg";

//verified..now entering values
$baby_type="1";
$stmtq = $conn->prepare('INSERT INTO `temp_students`(`name`, `roll`, `email`, `dob`, `f_name`, `f_mob`, `address1`, `address2`, `city`, `phone`, `branch`, `course`, `sem`)  values(?,?,?,?,?,?,?,?,?,?,?,?,?)');
			$stmtq->bind_param("sssssssssssss", $new_name, $new_roll, $new_email, $new_dob, $new_g_name, $new_g_mob, $new_address1, $new_address2, $new_city, $new_phone, $csv_branch, $csv_course, $csv_sem);
			if($stmtq->execute()){
				$stmtq = $conn->prepare('INSERT INTO `login`(`roll`, `name`, `email`, `password`, `type`, `image`)  values(?,?,?,?,?,?)');
				$stmtq->bind_param("ssssss", $new_roll, $new_name, $new_email, $new_roll, $baby_type, $new_image);
				if($stmtq->execute()){
					echo "<br>".$new_roll." has been admitted.";
				}
			}

	
}

?>