<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$sub_name=$_POST['sub_name'];
$sub_name=htmlspecialchars($sub_name, ENT_QUOTES, 'UTF-8');
$sub_code=$_POST['sub_code'];
$sub_code=htmlspecialchars($sub_code, ENT_QUOTES, 'UTF-8');
$sub_credits=$_POST['sub_credits'];
$sub_credits=htmlspecialchars($sub_credits, ENT_QUOTES, 'UTF-8');
$class_id=$_POST['class_id'];
$class_id=htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8');
$sub_type=$_POST['sub_type'];
$sub_type=htmlspecialchars($sub_type, ENT_QUOTES, 'UTF-8');
$sub_teacher_roll=$_POST['sub_teacher_roll'];
$sub_teacher_roll=htmlspecialchars($sub_teacher_roll, ENT_QUOTES, 'UTF-8');
$stmtw = $conn->prepare('SELECT * from subject where name=? and code=? and type=? and class_id = ?');
$stmtw->bind_param("ssss", $sub_name, $sub_code, $sub_type, $class_id);
$stmtw->execute();
$resultw = $stmtw->get_result();
if ($resultw->num_rows > 0) {
	die("<span style='color:red;margin-top:5px;font-size:18px'>Already Exists !</span>");
} else{
$stmt = $conn->prepare('insert into subject(name,code,credits,type,teacher_roll,class_id) values(?,?,?,?,?,?)');
        $stmt->bind_param('ssssss', $sub_name, $sub_code, $sub_credits, $sub_type, $sub_teacher_roll,$class_id);
if($stmt->execute()){echo "<span style='color:#328c15;margin-top:5px;font-size:18px'>Inserted Successfully !</span>";}
}
?>
