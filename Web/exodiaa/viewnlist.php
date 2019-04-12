<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
if(!$_POST['today']){echo '<script>window.parent.location = "index.php"</script>';}
$today=$_POST['today'];
$today=htmlspecialchars($today, ENT_QUOTES, 'UTF-8');
?>
					<div class="daytime" style="border-top: 3px solid rgba(90, 90, 90, 0.95);padding: 10px;background: #fff;text-align: center;border-bottom: 3px solid rgba(90, 90, 90, 0.95);">
		<?php			$stmt = $conn->prepare('SELECT * from class where id=?');
		$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $sem=$row['sem'];
	   $branch=$row['branch'];
	   $course=$row['course'];
}}


	   ?>
<select name="combonsub" id="combonsub" style="width: 100%;font-family: 'Titillium Web';font-weight: 600;margin-top: 10px;padding: 4px;color: #555;border-color: #ccc;border-radius: 3px;">
<option value="">Select a Subject</option>
<?php
			$stmt = $conn->prepare('SELECT * from subject where class_id=?');
		$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $sub_id=$row['id'];
	   $sub_name=$row['name'];
	   $sub_type=$row['type'];
	   $sub_code=$row['code'];
?>
<option value="<?php echo $sub_id; ?>"><?php echo $sub_code; ?> - <?php echo $sub_name; ?> [<?php echo $sub_type; ?>]</option>
<?php }}?>
</select>

<!--<div class="checkboxFour">
  <input type="checkbox" checked id="checkboxFourInput" name="" />
  <label for="checkboxFourInput"></label>
  </div>
  --></div>
<div id="hellofnbabes" style="padding:0;margin:0;width:100%"></div>
<script type="text/javascript">
$(document).ready(function() {

	$('select[name=combonsub]').change(function() {
		var combo = $(this).val();
		getnotes(combo);
    });
});
</script>