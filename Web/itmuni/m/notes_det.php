<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
?>
<div class="col-sm-12">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Title</span>
				<input required name="notes_title" id="notes_title" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
<div class="col-sm-12">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
	<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Description</span>
				<textarea required name="notes_desc" id="notes_desc" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">		</textarea>
				</p>
</div>			
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
	<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Upload File</span>
				<input required type="file" id="imgInp" name="file" style="padding:5px 0px;width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" class="custom-file-input form-control" style="">		
				</p>
</div>	
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<input required type="submit" id="notes_upl_btn" style="">		
				</p>
</div>
</div>
</form>
			