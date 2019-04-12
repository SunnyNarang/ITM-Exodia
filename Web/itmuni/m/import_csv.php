<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
?>
<div class="row" style="text-align:initial">
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "Roll"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "Name"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "Email"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "DOB"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "G_Name"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "G_Mob"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "Address 1"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "Address 2"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "Phone"; ?>" readonly></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="padding: 4px 0px;color: #000;font-weight: 400;width:100%;text-align:center;border: 1px solid #c0c0c0;background: #f3f3f3;" value="<?php echo "City"; ?>" readonly></div>
</div>
<form id="import_csv_det" style="text-align:left;margin-bottom: 10px;margin-top: 0px;" action="" autocomplete="off">
<?php
$admit_course=$_POST['admit_course'];
$admit_branch=$_POST['admit_branch'];
$admit_sem=$_POST['admit_sem'];
?>
<input type="hidden" name="admit_course" value="<?php echo $admit_course; ?>">
<input type="hidden" name="admit_branch" value="<?php echo $admit_branch; ?>">
<input type="hidden" name="admit_sem" value="<?php echo $admit_sem; ?>">
<?php
$file = $_FILES['csv_file']['tmp_name'];
 $handle = fopen($file, "r");
 $c = 0;
 while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
 {
 $csv_roll = $filesop[0];
 $csv_name = $filesop[1];
 $csv_email = $filesop[2];
 $csv_dob = $filesop[3];
 $csv_g_name = $filesop[4];
 $csv_g_mob = $filesop[5];
 $csv_address1 = $filesop[6];
 $csv_address2 = $filesop[7];
 $csv_phone = $filesop[8];
 $csv_city = $filesop[9];
 
 $stmt = $conn->prepare('SELECT roll,email from login where roll = ? or email = ?');
$stmt->bind_param('ss', $csv_roll, $csv_email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	die('<div class="row" style="text-align:initial">
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_roll.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_name.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_email.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_dob.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_g_name.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_g_mob.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_address1.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_address2.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_phone.'"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid red;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="'.$csv_city.'"></div>
</div>	');
	?>

<?php	
}
?>

<div class="row" style="text-align:initial">
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_roll; ?>" name="csv_roll[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_name; ?>" name="csv_name[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_email; ?>" name="csv_email[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_dob; ?>" name="csv_dob[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_g_name; ?>" name="csv_g_name[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_g_mob; ?>" name="csv_g_mob[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_address1; ?>" name="csv_address1[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_address2; ?>" name="csv_address2[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_phone; ?>" name="csv_phone[]"></div>
<div class="col-sm-1" style="padding:0;width:10%;display:inline-block"><input style="border: 1px solid #c0c0c0;padding: 4px 0px;width:100%;font-size:13.5px;color: #000;font-weight: 400;" value="<?php echo $csv_city; ?>" name="csv_city[]"></div>
</div>
 <?php

 }
 ?>
 <div class="row">
 <div class="col-sm-4"></div><div class="col-sm-4"></div>
				<div class="col-sm-4" style="text-align:right;margin-top: 10px;">
				<input type="submit" value="Import Data" id="csv_btn-det" style="margin-top: 5px;margin-bottom:5px;color: #fff;background: #3c3c3b;border: none;font-size: 14px;font-family: titillium Web;padding: 5px 20px;box-shadow: 2px 2px 5px #696969;">
				</div>
				</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
			  $("#import_csv_det").submit(function(event){
        event.preventDefault();
    import_submit_det();
  });
});
</script>
