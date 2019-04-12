<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
?>
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Name</span>
				<input required name="add_name" id="notes_title" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p></p>

<p id="add_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<input required type="submit" id="add_upl_btn" style="">		
				</p>

</form>
			