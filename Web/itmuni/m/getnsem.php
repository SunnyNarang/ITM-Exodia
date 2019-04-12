<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['course'] or !$_POST['branch']){echo '<script>window.parent.location = "index.php"</script>';}
$postedcourse=$_POST['branch'];
$postedcourse=htmlspecialchars($postedcourse, ENT_QUOTES, 'UTF-8');
$postedbranch=$_POST['course'];
$postedbranch=htmlspecialchars($postedbranch, ENT_QUOTES, 'UTF-8');
?>
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Sem</span>
				<select name="notes_sem" id="notes_sem" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Sem</option>
<?php
echo $postedbranch;
$stmt = $conn->prepare('SELECT distinct sem from class where course=? and branch= ?');
		$stmt->bind_param("ss", $postedcourse, $postedbranch);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   echo $sem=$row['sem'];
?>
<option value="<?php echo $sem; ?>"><?php echo $sem; ?></option>
<?php }}?>
				</select>
				
<script type="text/javascript">
$(document).ready(function() {				
	$('select[name=notes_sem]').change(function() {
		var sem = $(this).val();
		var course = $('select[name=notes_course]').val();
		var branch = $('select[name=notes_branch]').val();
		getnoclasss(branch, course, sem);
    });
});
</script>				