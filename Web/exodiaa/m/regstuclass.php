<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['course'] or !$_POST['branch'] or !$_POST['sem']){echo '<script>window.parent.location = "index.php"</script>';}
$postedcourse=$_POST['course'];
$postedcourse=htmlspecialchars($postedcourse, ENT_QUOTES, 'UTF-8');
$postedbranch=$_POST['branch'];
$postedbranch=htmlspecialchars($postedbranch, ENT_QUOTES, 'UTF-8');
$postedsem=$_POST['sem'];
$postedsem=htmlspecialchars($postedsem, ENT_QUOTES, 'UTF-8');
$stmt = $conn->prepare('SELECT * from temp_students where course=? and branch=? and sem=? order by roll');
$stmt->bind_param("sss", $postedcourse, $postedbranch, $postedsem);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
?>
<form id="submitreg" method="post" action="" style="text-align:center">

		<?php
while($row = $result->fetch_assoc()) {
$studentid=$row['id'];
$studentname=$row['name'];
$studentroll=$row['roll'];
$studentemail=$row['email'];
$studentdob=$row['dob'];
$studentf_name=$row['f_name'];
$studentf_mob=$row['f_mob'];
$studentadd1=$row['address1'];
$studentadd2=$row['address2'];
$studentcity=$row['city'];
$studentphone=$row['phone'];
$studentbranch=$row['branch'];
$studentcourse=$row['course'];
$studentsem=$row['sem'];

$stmt13 = $conn->prepare('SELECT image from login where roll=?');
$stmt13->bind_param("s", $studentroll);
$stmt13->execute();
$result13 = $stmt13->get_result();
while($row13 = $result13->fetch_assoc()) {
$studentimage=$row13['image'];	

?>
	<div class="family" id="family_<?php echo $studentroll; ?>" style="width:100%;margin:0;background:#fff;padding:10px">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $studentimage; ?>" style="width:40px;height:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;display: inline-block;vertical-align:middle"><?php echo $studentname; ?></span>
			<span onclick="del_fucker('<?php echo $studentroll; ?>')" style="font-family: 'Titillium Web', sans-serif;font-size: 10px;display: inline-block;color: #ffffff;background: #bd1919;padding: 2px 10px;font-weight: 800;vertical-align: middle;border-radius: 4px;margin-left: 10px;">Delete</span>
			<input type="hidden" name="studentroll[]" value="<?php echo $studentroll; ?>">
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $studentroll; ?></span>
			</div>
			<div style="display:inline-block;float:right;vertical-align:middle">
			<div class="checkboxFour">
  <input type="checkbox" id="student_<?php echo $studentroll; ?>" name="checkedstatus[]" value="<?php echo $studentroll; ?>" style="display:none"/>
  <label for="student_<?php echo $studentroll; ?>"></label>
  </div>
			</div>
			</div>
<?php }} ?>
<div style="text-align: left;padding: 10px;border-bottom: 1px solid #e6e6e6;">
<span style="font-size: 20px;font-family: titillium web;font-weight: 600;color: #8a8686;">Move selected students to </span>
<select name="ultimate_class" style="margin-left:10px;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;" required>
<option value="">Select a class</option>
<?php
$stmt = $conn->prepare('SELECT * from class where course = ? and branch = ? and sem = ?');
$stmt->bind_param("sss", $postedcourse, $postedbranch, $postedsem);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
$classname=$row['name'];
$classid=$row['id'];
?>
<option value="<?php echo $classid; ?>"><?php echo $classname; ?></option>
<?php }}?>
</select>
</div>
<button id="buttonofreg" type="submit" style="text-align:center;margin: 10px 0px;">Submit</button>
</form>
 <script type="text/javascript"> 
      $(document).ready(function(){  
		$("#submitreg").submit(function(event){
		event.preventDefault();
		submitreg();
  });
      });
  </script>
<?php } ?>