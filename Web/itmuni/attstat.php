<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
?>
<div class="profileCard1" style="padding-bottom:0px">
                <div class="pImg">
                   <span onclick="backtostat()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="margin-bottom:20px;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Attendance Statistics</h1>
				</div>
            </div>
<div class="family" style="background:#fff;margin:0px;width:100%">			
<div class="row"><div class="col-sm-2"></div>
		  <div class="col-sm-4">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Course</span>
				<select name="statnotes_course" id="notes_course" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Course</option>
<?php
			$stmt = $conn->prepare('SELECT distinct course from class');
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $course=$row['course'];
?>
<option value="<?php echo $course; ?>"><?php echo $course; ?></option>
<?php }}?>
				</select>
				</p>
				</div>
<div class="col-sm-4">
				<p id="statnotes_psub" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				</p></div></div>
<div class="row"><div class="col-sm-2"></div> <div class="col-sm-4">
				<p id="statnotes_pbranch" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 10px;">
				</p>
				</div><div class="col-sm-4">
				<p id="statnotes_psem" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 10px;">
				</p>
				</div>	</div></div>
<div class="" style="background:#fff;margin:0px;width:100%" id="getgraph"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('select[name=statnotes_course]').change(function() {
		var combo = $(this).val();
		statgetnobranch(combo);
    });
});
</script>