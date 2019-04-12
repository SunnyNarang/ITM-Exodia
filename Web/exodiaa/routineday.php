<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');
$stmt = $conn->prepare('SELECT * from student where student.roll = ? or student.email = ?');
$stmt->bind_param('ss', $roll, $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $class_id=$row['class_id'];
	   $batch=$row['batch'];
    }
}else {header('Location: index.php');}

$day=date('l');	
if($_POST['today']){$day=$_POST['today'];}
$stmt = $conn->prepare('SELECT *, routine.id as routine_id, subject.id as sub_id, subject.code as sub_code FROM routine inner join subject on routine.sub_id=subject.id where routine.class_id = ? and routine.day = ? and (batch = "0" or batch = ?) ');
$stmt->bind_param('sss', $class_id, $day, $batch);
$stmt->execute();
$result = $stmt->get_result();
	   
?>

<div>
<h1 style="font-family: 'Titillium Web', sans-serif;margin:0;font-weight:800;padding: 10px 15px;color: #4e4e4e;background: #fdfdfd;border-bottom: 1px solid #ececec;text-transform:capitalize"><?php echo $day; ?></h1>
<div style="padding:10px;background:#fff">

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $mon_r_id=$row['routine_id'];
	   $mon_sub_id=$row['sub_id'];
	   $mon_sub_code=$row['sub_code'];	
	   $mon_start=$row['start_time'];
	   $mon_end=$row['end_time'];
	   $mon_name=$row['name'];
	   $mon_sub_type=$row['type'];
	   $sub_teacher=$row['teacher_roll'];
	   
	    $stmt0 = $conn->prepare('SELECT name as t_name FROM teacher where roll = ?');
		$stmt0->bind_param('s', $sub_teacher);
		$stmt0->execute();
		$result0 = $stmt0->get_result();
	   while($row0 = $result0->fetch_assoc()){
	   $teacher_name=$row0['t_name'];}
	   
	    $stmt1 = $conn->prepare('select count(*) as went from (SELECT * FROM attendance where roll = ? and sub_id = ? and status = "1") s');
		$stmt1->bind_param('ss', $roll, $mon_sub_id);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		if ($result1->num_rows > 0) {
	   while($row1 = $result1->fetch_assoc()){
	   $hewent=$row1['went'];}}else{$hewent="00";}
	   
	    $stmt2 = $conn->prepare('select count(*) as otal from (SELECT * FROM attendance where roll = ? and sub_id = ?) s');
		$stmt2->bind_param('ss', $roll, $mon_sub_id);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		if ($result2->num_rows > 0) {
	   while($row2 = $result2->fetch_assoc()){
	   $otal=$row2['otal'];}}else{$otal="00";}
	   
	   ?>
<div style="border-left:3px solid #00baff;padding-left:10px;margin:20px 10px">
<div style="display:inline-block;vertical-align:middle">
<span style="font-family: 'Oswald', sans-serif;font-size:19px;color:#545454"><?php echo date_format(date_create($mon_start),"h:i A");?> - <?php echo date_format(date_create($mon_end),"h:i A"); ?></span>
<span style="font-family: 'Titillium Web', sans-serif;font-size:16px;font-weight:800;color:#00baff"><a class="btn btn-info btn-md" style="padding: 2px 8px;margin: 0;vertical-align: middle;margin-right: 5px;text-align:uppercase"><?php echo $mon_sub_type; ?></a><?php echo $mon_name; ?> - <?php echo $mon_sub_code; ?></span>
<span style="font-family: 'Oswald', sans-serif;"><?php echo $teacher_name; ?></span>
</div>
<div style="float: right;font-family: 'Titillium Web', sans-serif;font-size: 25px;font-weight: 800;color: #565656;">
<span style="float:right"><span style="border-bottom:1px solid #00baff"><?php echo $hewent; ?></span><span style=""><?php echo $otal; ?></span></span>
</div>
</div>
<?php
}}else{
?>
<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No time table found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please report to your Mentor.</span>
			</div>
<?php } ?>
</div>
</div>

