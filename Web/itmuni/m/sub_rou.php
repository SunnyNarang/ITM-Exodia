<?php
ob_start();
error_reporting(E_ALL);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$class_id=$_POST['class_id'];
$class_id=htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8');
$add_rou_day=$_POST['add_rou_day'];
$add_rou_day=htmlspecialchars($add_rou_day, ENT_QUOTES, 'UTF-8');
$add_rou_sub=$_POST['add_rou_sub'];
$add_rou_sub=htmlspecialchars($add_rou_sub, ENT_QUOTES, 'UTF-8');
$add_rou_start=$_POST['add_rou_start'];
$add_rou_start=htmlspecialchars($add_rou_start, ENT_QUOTES, 'UTF-8');
$add_rou_start=date("H:i:s", strtotime($add_rou_start));
$add_rou_end=$_POST['add_rou_end'];
$add_rou_end=htmlspecialchars($add_rou_end, ENT_QUOTES, 'UTF-8');
$add_rou_end=date("H:i:s", strtotime($add_rou_end));
$sub_batch=$_POST['sub_batch'];
$sub_batch=htmlspecialchars($sub_batch, ENT_QUOTES, 'UTF-8');

$stmtw = $conn->prepare('SELECT * from routine where day=? and sub_id=? and class_id=? and start_time = ? and end_time = ? and batch = ?');
$stmtw->bind_param("ssssss", $add_rou_day, $add_rou_sub, $class_id, $add_rou_start, $add_rou_end, $sub_batch);
$stmtw->execute();
$resultw = $stmtw->get_result();
if ($resultw->num_rows > 0) {
	die("<span style='color:red;margin-top:5px;font-size:18px'>Already Exists !</span>");
} else{
$stmt = $conn->prepare('insert into routine(day, sub_id,class_id,start_time,end_time,batch) values(?,?,?,?,?,?)');
$stmt->bind_param('ssssss', $add_rou_day, $add_rou_sub, $class_id, $add_rou_start, $add_rou_end,$sub_batch);
if($stmt->execute()){echo "<span style='color:#328c15;margin-top:5px;font-size:18px'>Inserted Successfully !</span>";} else{echo "error";}
}
?>
