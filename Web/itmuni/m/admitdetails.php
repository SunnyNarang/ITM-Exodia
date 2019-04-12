<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['course']){echo '<script>window.parent.location = "index.php"</script>';}
$postedcourse=$_POST['course'];
$postedcourse=htmlspecialchars($postedcourse, ENT_QUOTES, 'UTF-8');
?>
<div class="row">
<div class="col-sm-6">
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
				<option value="9">9</option>
				<option value="10">10</option>
				</select>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;display:inline-block;vertical-align: middle;float: left;">Roll</span><span id="rollchecker" style="color:red;display:inline-block;vertical-align: middle;"></span>
				<input onkeyup="rollchecker();" required name="admit_roll" id="admit_roll" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Name</span>
				<input required name="admit_name" id="admit_name" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;display:inline-block;vertical-align: middle;float: left;">Email</span><span id="emailchecker" style="color:red;display:inline-block;vertical-align: middle;"></span>
				<input type="email" onkeyup="emailchecker();" required name="admit_email" id="admit_email" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Date of Birth</span>
				<input type="date" required name="admit_dob" id="admit_dob" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Guardian Name</span>
				<input required name="admit_f_name" id="admit_f_name" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Guardian Phone No.</span>
				<input required name="admit_f_mob" id="admit_f_mob" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Address Line 1</span>
				<input required name="admit_address1" id="admit_address1" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Address Line 2</span>
				<input required name="admit_address2" id="admit_address2" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">City</span>
				<input required name="admit_city" id="admit_city" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Phone</span>
				<input required name="admit_phone" id="admit_phone" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Upload Image</span>
				<input type="file" required name="admit_image" id="admit_image" class="custom-file-input form-control" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 0px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="admit_sub_btnm" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 14px;margin-top: 10px;margin-bottom: 0px;">
				</p>
</div>
<div class="col-sm-6">
<p id="" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<input type="submit" id="admit_sub_btn" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
<p id="" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 0px;margin-bottom: 0px;">
				<input type="reset" id="" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>				
</div>
</div>
</form>
