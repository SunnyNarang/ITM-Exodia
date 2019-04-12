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
?>
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Class</span>
				<select name="statnotes_classs" id="notes_course" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Class</option>
<?php
	$stmt = $conn->prepare('SELECT distinct name,id from class where course=? and branch= ? and sem=?');
		$stmt->bind_param("sss", $postedcourse, $postedbranch, $postedsem);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $name=$row['name'];
	   $class_id=$row['id'];
?>
<option value="<?php echo $class_id; ?>"><?php echo $name; ?></option>
<?php }}?>
				</select>
				
<script type="text/javascript">
$(document).ready(function() {				
	$('select[name=statnotes_classs]').change(function() {
		var classs = $(this).val();
		getgraphlist(classs);
    });
});
</script>				
