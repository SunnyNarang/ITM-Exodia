<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
?>
<div class="profileCard1" style="padding-bottom:0px">
                <div class="pImg">
                   <span onclick="backtoreg()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="margin-bottom:1px;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800;border-bottom: 1px solid #d2d2d2;padding-bottom: 10px;">Import Students</h1>
					<form id="import_csv" style="text-align:left;margin-bottom: 10px;margin-top: 8px;" action="" autocomplete="off">
					<div class="row">
					<div class="col-sm-3" style="text-align:left">
					<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Course</span>
				<select required name="admit_course" id="admit_course" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
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
					<div class="col-sm-3" style="text-align:left">
					<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Branch</span>
				<select required name="admit_branch" id="admit_branch" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Branch</option>
				
				</select>
				</p>
					</div>
					<div class="col-sm-3" style="text-align: left;margin-top: 13px;">
					<span style="padding:0;margin-top: 10px;font-size:15px;font-weight:800;text-align: left;">Select Sem</span>
				<select name="admit_sem" id="admit_sem" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				</select>
					</div>
					<div class="col-sm-3" style="text-align:left">
					<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 8px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Upload CSV File</span>
				<input type="file" required name="csv_file" id="csv_file" class="custom-file-input form-control" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 0px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				
				</p>
				</div>
				</div>
				<div class="row">
				<div class="col-sm-4" style="text-align:left">
				<input type="submit" id="csv_btn" style="margin-top: 5px;margin-bottom:10px;color: #fff;background: #3c3c3b;border: none;font-size: 14px;font-family: titillium Web;padding: 5px 20px;box-shadow: 2px 2px 5px #696969;">
				</div>
				</div>
				</form>
				</div>
            </div>
<div class="family" style="cursor:auto;background:#fff;margin:0px;width:100%;border-bottom: 1px solid #dbdbdb;padding:0" id="imported_data">	
</div>			
<script type="text/javascript">
$(document).ready(function() {
	$("#admit_course").change(function() {
	$.get('m/loadsubcat.php?parent_cat=' + $(this).val(), function(data) {
			$("#admit_branch").html(data);
		});
	});
			  $("#import_csv").submit(function(event){
        event.preventDefault();
    import_submit();
  });
});
</script>
