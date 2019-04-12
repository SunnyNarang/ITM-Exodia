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
<link rel="stylesheet" type="text/css"  href="css/bootstrap-datetimepicker.css">

					<div class='input-group date date-input' id='datetimepicker2'  data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
								<input type='date' name="date" id="date" class="form-control" placeholder="Search by Date" style="font-family: 'Titillium Web';font-weight: 600;" value="<?php echo date('Y-m-d'); ?>" />
								<span class="input-group-addon" style="display: table-cell;">
								<span class="glyphicon glyphicon-calendar"></span>
								</span>
					</div>
<select name="combotime" id="combotime" style="width: 100%;font-family: 'Titillium Web';font-weight: 600;margin-top: 10px;padding: 4px;color: #555;border-color: #ccc;border-radius: 3px;">
<?php
			$stmt = $conn->prepare('select distinct start_time,end_time from routine');
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $start_time=$row['start_time'];
	   $end_time=$row['end_time'];
?>
<option value="<?php echo $start_time; ?> - <?php echo $end_time; ?>"><?php echo $start_time; ?> - <?php echo $end_time; ?></option>
<?php }}?>
</select>
<div class="row">
<div class="col-sm-6" style="padding:0px 1px">
<select name="combosub" id="combosub" style="width: 100%;font-family: 'Titillium Web';font-weight: 600;margin-top: 10px;padding: 4px;color: #555;border-color: #ccc;border-radius: 3px;">
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
</div>
<div class="col-sm-6" style="padding:0px 1px">
<select name="combobatch" id="combobatch" style="width: 100%;font-family: 'Titillium Web';font-weight: 600;margin-top: 10px;padding: 4px;color: #555;border-color: #ccc;border-radius: 3px;">
<option value="All">All Students</option>
<?php
			$stmt = $conn->prepare('SELECT distinct batch as stu_batch from student where class_id=?');
		$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $stu_batch=$row['stu_batch'];
?>
<option value="<?php echo $stu_batch; ?>"><?php echo $stu_batch; ?> Students</option>
<?php }}?>
</select>
</div>
</div>
<!--<div class="checkboxFour">
  <input type="checkbox" checked id="checkboxFourInput" name="" />
  <label for="checkboxFourInput"></label>
  </div>
  --></div>
<div id="hellofbabes" style="padding:0;margin:0;width:100%"></div>
<script type="text/javascript">
$(document).ready(function() {
	$("#date").change(function() {
		var alt = $(this).val();
		var alt2 = $('select[name=combosub]').val();
		var alt3 = $('select[name=combotime]').val();
		var alt4 = $('select[name=combobatch]').val();
		getstudent(alt,alt2,alt3,<?php echo $today;?>,alt4);
    });
	$('select[name=combosub]').change(function() {
		var combo = $(this).val();
		var combo2 = $('#date').val();
		var alt3 = $('select[name=combotime]').val();
		var alt4 = $('select[name=combobatch]').val();
		getstudent(combo2,combo,alt3,<?php echo $today;?>,alt4);
    });
	$('select[name=combotime]').change(function() {
		var time1 = $('select[name=combosub]').val();
		var time2 = $('#date').val();
		var time3 = $('select[name=combotime]').val();
		var alt4 = $('select[name=combobatch]').val();
		getstudent(time2,time1,time3,<?php echo $today;?>,alt4);
    });
	$('select[name=combobatch]').change(function() {
		var time1 = $('select[name=combosub]').val();
		var time2 = $('#date').val();
		var time3 = $('select[name=combotime]').val();
		var alt4 = $('select[name=combobatch]').val();
		getstudent(time2,time1,time3,<?php echo $today;?>,alt4);
    });
});
</script>
		  				<script type="text/javascript">

	$('.date-input').datetimepicker({
        language:  'en',
		format: 'yyyy-mm-dd',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
$(function () {
                $('#datetimepicker2').datetimepicker('setEndDate', '<?php echo date('Y-m-d'); ?>');
            });
	
        </script>