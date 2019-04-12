<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
if(!$_POST['att_sub'] or !$_POST['att_class_id'] or !$_POST['att_date']){echo "sasa";}
$att_sub=$_POST['att_sub'];
$att_sub=htmlspecialchars($att_sub, ENT_QUOTES, 'UTF-8');
$att_date=$_POST['att_date'];
$att_date=htmlspecialchars($att_date, ENT_QUOTES, 'UTF-8');
$att_time=$_POST['att_time'];
$att_time=htmlspecialchars($att_time, ENT_QUOTES, 'UTF-8');
$att_class_id=$_POST['att_class_id'];
$att_class_id=htmlspecialchars($att_class_id, ENT_QUOTES, 'UTF-8');
$current_date=date('Y-m-d');
$att_roll=$_POST['studentroll'];
$att_checked_status=$_POST['checkedstatus'];
$ini_status="0";
foreach ($att_roll as $key => $att_roll_q) {
        $stmt = $conn->prepare('update attendance set status="0", last_edited=?, teacher_roll=? where roll=? and att_date=? and sub_id=? and class_id=? and time=?');
        $stmt->bind_param('sssssss',$current_date,$roll, $att_roll_q, $att_date, $att_sub, $att_class_id,$att_time );
        $stmt->execute();
}
foreach ($att_checked_status as $key => $att_status_q) {
        $stmt = $conn->prepare('update attendance set status="1" where roll=? and att_date=? and sub_id=? and class_id=? and time=?');
        $stmt->bind_param('sssss', $att_status_q, $att_date, $att_sub, $att_class_id, $att_time);
        $stmt->execute();
}
echo "<div class='family'>Attendance was uploaded successfully !</div>";
?>