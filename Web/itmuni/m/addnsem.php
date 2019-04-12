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
				<select name="add_sem" id="add_sem" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Sem</option>
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
				
<script type="text/javascript">
$(document).ready(function() {				
	$('select[name=add_sem]').change(function() {
		var sem = $(this).val();
		getaddclasss(sem);
    });
});
</script>				