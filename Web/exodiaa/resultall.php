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

if($_POST['today']){$examid=$_POST['today'];
$stmt = $conn->prepare('SELECT * from exam where id=?');
$stmt->bind_param('s', $examid);
$stmt->execute();
$result = $stmt->get_result();
	   while($row = $result->fetch_assoc()) {
	   $exam_name=$row['name'];
	   }
?>

<div>
<h1 style="font-family: 'Titillium Web', sans-serif;margin:0;font-weight:800;padding: 10px 15px;color: #4e4e4e;background: #fdfdfd;border-bottom: 1px solid #ececec;text-transform:capitalize"><?php echo $exam_name; ?></h1>
<div style="padding:10px;background:#fff">

<?php
$stmt = $conn->prepare('SELECT *,result.subject_id as subject_id,result.c_obt as c_obt,result.grade as grade FROM exam inner join result on result.exam_id=exam.id WHERE roll=? and exam_id=?');
$stmt->bind_param('ss', $roll, $examid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $subject_id=$row['subject_id'];
	   $subject_c_obt=$row['c_obt'];
	   $subject_grade=$row['grade'];
if($subject_grade==10){$subject_grade='A+';}
elseif($subject_grade==9){$subject_grade='A';}
elseif($subject_grade==8){$subject_grade='B+';}
elseif($subject_grade==7){$subject_grade='B';}
elseif($subject_grade==6){$subject_grade='C+';}
elseif($subject_grade==5){$subject_grade='C';}
elseif($subject_grade==4){$subject_grade='D+';}
elseif($subject_grade==3){$subject_grade='D';}
elseif($subject_grade==2){$subject_grade='E+';}
elseif($subject_grade==1){$subject_grade='E';}
elseif($subject_grade==0){$subject_grade='F';}
	    $stmt0 = $conn->prepare('SELECT * FROM subject where id = ?');
		$stmt0->bind_param('s', $subject_id);
		$stmt0->execute();
		$result0 = $stmt0->get_result();
	   while($row0 = $result0->fetch_assoc()){
	   $subject_name=$row0['name'];
	   $subject_code=$row0['code'];
	   $subject_type=$row0['type'];
	   $subject_credits=$row0['credits'];
	   }
	   
	   ?>
<div style="border-left:3px solid #00baff;padding-left:10px;margin:20px 10px">
<div style="display:inline-block;vertical-align:middle">
<span style="font-family: 'Titillium Web', sans-serif;font-size:16px;font-weight:800;color:#00baff"><a class="btn btn-info btn-md" style="padding: 2px 8px;margin: 0;vertical-align: middle;margin-right: 5px;text-align:uppercase"><?php echo $subject_type; ?></a><?php echo $subject_name; ?> - <?php echo $subject_code; ?></span>
<span style="font-family: 'Oswald', sans-serif;"><?php echo $subject_grade; ?></span>
</div>
<div style="float: right;font-family: 'Titillium Web', sans-serif;font-size: 16px;font-weight: 800;color: #565656;">
<span style="float:right"><span style="border-bottom:1px solid #00baff"><?php echo $subject_c_obt; ?> credits</span><span style=""><?php echo $subject_credits; ?> credits</span></span>
</div>
</div>
<?php
}}else{
?>
<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No time table found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please report to your Mentor.</span>
			</div>
<?php }} ?>
</div>
</div>

