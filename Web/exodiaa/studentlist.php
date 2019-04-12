<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
if(!$_POST['date'] or !$_POST['sub'] or !$_POST['class_id']){echo '<script>window.parent.location = "index.php"</script>';}
$posteddate=$_POST['date'];
$posteddate=htmlspecialchars($posteddate, ENT_QUOTES, 'UTF-8');
$postedbatch=$_POST['stu_batch'];
$postedbatch=htmlspecialchars($postedbatch, ENT_QUOTES, 'UTF-8');
$postedtime=$_POST['att_time'];
$postedtime=htmlspecialchars($postedtime, ENT_QUOTES, 'UTF-8');
$postedsub=$_POST['sub'];
$postedsub=htmlspecialchars($postedsub, ENT_QUOTES, 'UTF-8');
$postedclass_id=$_POST['class_id'];
$postedclass_id=htmlspecialchars($postedclass_id, ENT_QUOTES, 'UTF-8');
//start if-else
$stmt = $conn->prepare('SELECT * from attendance where class_id=? and sub_id=? and att_date=? and time=?');
$stmt->bind_param("ssss", $postedclass_id, $postedsub, $posteddate, $postedtime);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
?>	
<form id="attendanceupdate" method="post" action="" style="text-align:center">
	<input type="hidden" name="att_date" value="<?php echo $posteddate; ?>">
	<input type="hidden" name="att_sub" value="<?php echo $postedsub; ?>">
	<input type="hidden" name="att_class_id" value="<?php echo $postedclass_id; ?>">
	<input type="hidden" name="att_time" value="<?php echo $postedtime; ?>">
	<div id="updatemessageatt" style="background: #000;color: #fff;padding: 8px;opacity: 0.5;font-family: 'Titillium Web';word-spacing: 1px;"></div>
	
		<?php
while($row = $result->fetch_assoc()) {
$studentroll=$row['roll'];
$studentstatus=$row['status'];
$last_edited=$row['last_edited'];
$student_teacher_roll=$row['teacher_roll'];

$stmt12 = $conn->prepare('SELECT * from student where roll=?');
$stmt12->bind_param("s", $studentroll);
$stmt12->execute();
$result12 = $stmt12->get_result();
while($row12 = $result12->fetch_assoc()) {
$studentname=$row12['name'];	
}

$stmt13 = $conn->prepare('SELECT * from teacher where roll=?');
$stmt13->bind_param("s", $student_teacher_roll);
$stmt13->execute();
$result13 = $stmt13->get_result();
while($row13 = $result13->fetch_assoc()) {
$teachername=$row13['name'];	
}
?>
	<div class="family" style="width:100%;margin:0;background:#fff;padding:10px">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $studentroll; ?>.jpg" style="width:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $studentname; ?></span>
			<input type="hidden" name="studentroll[]" value="<?php echo $studentroll; ?>">
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $studentroll; ?></span>
			</div>
			<div style="display:inline-block;float:right;vertical-align:middle">
			<div class="checkboxFour">
  <input type="checkbox" <?php if($studentstatus==1) echo "checked";?> id="student_<?php echo $studentroll; ?>" name="checkedstatus[]" value="<?php echo $studentroll; ?>" style="display:none"/>
  <label for="student_<?php echo $studentroll; ?>"></label>
  </div>
			</div>
			</div>

<?php } ?><input type="hidden" name="hello2" id="hehehe2" value="Attendance is already taken on <?php echo $last_edited; ?> by <?php echo $teachername; ?>" >
	<button id="buttonofgodupdate" type="submit" style="text-align:center;margin: 10px 0px;">Update</button>
</form>
<?php
}else{
	//else
		if($postedbatch=="All"){$stmt = $conn->prepare('SELECT * from student where class_id=?');
$stmt->bind_param("s", $postedclass_id);} else{
$stmt = $conn->prepare('SELECT * from student where class_id=? and batch=?');
$stmt->bind_param("ss", $postedclass_id,$postedbatch);}
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	?>
	<form id="attendancemagic" method="post" action="" style="text-align:center">
	<input type="hidden" name="att_date" value="<?php echo $posteddate; ?>">
	<input type="hidden" name="att_sub" value="<?php echo $postedsub; ?>">
	<input type="hidden" name="att_class_id" value="<?php echo $postedclass_id; ?>">
	<input type="hidden" name="att_time" value="<?php echo $postedtime; ?>">
	<?php
while($row = $result->fetch_assoc()) {
$studentroll=$row['roll'];
$studentname=$row['name'];
?>
<div class="family" style="width:100%;margin:0;background:#fff;padding:10px">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $studentroll; ?>.jpg" style="width:40px;height:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $studentname; ?></span>
			<input type="hidden" name="studentroll[]" value="<?php echo $studentroll; ?>">
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $studentroll; ?></span>
			</div>
			<div style="display:inline-block;float:right;vertical-align:middle">
			<div class="checkboxFour">
  <input type="checkbox" checked id="student_<?php echo $studentroll; ?>" name="checkedstatus[]" value="<?php echo $studentroll; ?>" style="display:none"/>
  <label for="student_<?php echo $studentroll; ?>"></label>
  </div>
			</div>
			</div>
			
<?php }?>
<button id="buttonofgod" type="submit" style="text-align:center;margin: 10px 0px;">Submit</button>
</form>
<?php }else{echo "<div class='family'>No students found</div>";}}?>
 <script type="text/javascript"> 
      $(document).ready(function(){
   $('#updatemessageatt').html($('#hehehe2').val());
		$("#attendancemagic").submit(function(event){
		event.preventDefault();
		sendinglist();
  });
  
		$("#attendanceupdate").submit(function(event){
		event.preventDefault();
		upsendinglist();
  });
      });
  </script>
