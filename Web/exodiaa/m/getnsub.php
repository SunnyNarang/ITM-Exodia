<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['classs']){echo '<script>window.parent.location = "index.php"</script>';}
$postedclass=$_POST['classs'];
$postedclass=htmlspecialchars($postedclass, ENT_QUOTES, 'UTF-8');
?>
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Subject</span>
				<select name="notes_subb" id="notes_course" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Subject</option>
<?php
	$stmt = $conn->prepare('SELECT * from subject where class_id=?');
		$stmt->bind_param("s", $postedclass);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $name=$row['name'];
	   $sub_id=$row['id'];
	   $sub_code=$row['code'];
	   $sub_type=$row['type'];
?>
<option value="<?php echo $sub_id; ?>"><?php echo $sub_code; ?> - <?php echo $name; ?> [<?php echo $sub_type; ?>]</option>
<?php }}?>
				</select>
				
<script type="text/javascript">
$(document).ready(function() {				
	$('select[name=notes_subb]').change(function() {
		var sub = $(this).val();
		getnosubb(sub);
    });
});
</script>				