<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-th-large" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Manage Teachers</h1>
					<button data-toggle="modal" data-target="#add_a_tea" style="text-transform: inherit;letter-spacing: inherit;word-spacing: 1px;margin: 0px;">Add a Teacher</button>
<div class="modal fade" id="add_a_tea" role="dialog">
<div class="modal-dialog" style="margin-top:20px">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
<h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800">Add a Teacher</h4>
</div>
<div class="modal-body" id="notes_up_sub_submit">
<header class="codrops-header" style="padding:0 10px;margin-bottom:0px;text-align:justify">
<form id="addteacher" style="display:initial" action="" autocomplete="off">
<div class="row">
<div class="col-sm-6">
<span style="padding:0;margin-top: 10px;font-size:15px;font-weight:800;text-align: left;">Select Department</span>
				<select name="select_dep" id="select_dep" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
			<?php	$stmtc = $conn->prepare('SELECT distinct dep from teacher order by dep');
$stmtc->execute();
$resultc = $stmtc->get_result();
if ($resultc->num_rows > 0) {
while($rowc = $resultc->fetch_assoc()) {
$tea_dep=$rowc['dep'];
?>
				<option value="<?php echo $tea_dep ?>"><?php echo $tea_dep ?></option>
<?php }} ?>
<option value="">Add new Department</option>
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
				<input type="file" name="admit_image" id="admit_image" class="custom-file-input form-control" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 0px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
</div>
<div class="row">
<div class="12" style="text-align: left;margin: 15px;">
<input name="tea_admin_check" value="2" type="hidden">
<input type="checkbox" name="tea_admin_check" value="3">
<label for="tea_admin_check" style="text-transform:Capitalize">Make Admin</label>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="admit_tea_btnm" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 14px;margin-top: 10px;margin-bottom: 0px;">
				</p>
</div>
<div class="col-sm-6">
<p id="" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<input type="submit" id="admit_tea_btn" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
<p id="" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 0px;margin-bottom: 0px;">
				<input type="reset" id="" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>				
</div>
</div>
</form>
</header>
</div>
<div class="modal-footer" style="padding: 10px;color: #fff;background: #30302d;"><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;"></span>
</div>
</div>

</div>
</div>	
                </div>
            </div>
<?php
$stmtc = $conn->prepare('SELECT distinct dep from teacher order by dep');
$stmtc->execute();
$resultc = $stmtc->get_result();
if ($resultc->num_rows > 0) {
while($rowc = $resultc->fetch_assoc()) {
$getdep=$rowc['dep'];			
?>
	<div class="row family" style="margin:0;background:#fff;width:100%;text-align:left">
	<span style="text-align: left;font-size: 30px;font-family: Oswald;font-weight: 600;color: #585858"><?php echo $getdep; ?></span>
	</div>
	<?php
	$stmts = $conn->prepare('SELECT name,roll,email,address1,address2,city,dep,phone,dob from teacher where dep = ? order by name');
	$stmts->bind_param("s", $getdep);
	$stmts->execute();
	$results = $stmts->get_result();
	if ($results->num_rows > 0) {
	while($rows = $results->fetch_assoc()) {
	$tea_name=$rows['name'];
	$tea_email=$rows['email'];
	$tea_address1=$rows['address1'];
	$tea_address2=$rows['address2'];
	$tea_city=$rows['city'];
	$tea_depr=$rows['dep'];
	$tea_phone=$rows['phone'];
	$tea_roll=$rows['roll'];
	$tea_dob=$rows['dob'];
	
	$stmtsa = $conn->prepare('SELECT image,type from login where roll = ?');
	$stmtsa->bind_param("s", $tea_roll);
	$stmtsa->execute();
	$resultsa = $stmtsa->get_result();
	if ($resultsa->num_rows > 0) {
	while($rowsa = $resultsa->fetch_assoc()) {
	$tea_image=$rowsa['image'];
	$tea_type=$rowsa['type'];
	?>
			<div data-toggle="modal" data-target="#editr_<?php echo $tea_roll; ?>" class="family" style="width:100%;margin:0;padding:10px">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $tea_image; ?>" style="width:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $tea_name; ?><?php if($tea_type=="3"){echo "<i class='fa fa-check-circle' style='margin-left:5px'></i>";} ?></span>
			<input type="hidden" name="studentroll[]" value="<?php echo $studentroll; ?>">
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $tea_roll; ?></span>
			</div>
			</div>
			
			<div class="modal fade" id="editr_<?php echo $tea_roll; ?>" role="dialog">
<div class="modal-dialog" style="margin-top:20px">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
<h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800">Edit <?php echo $tea_roll; ?></h4>
</div>
<div class="modal-body" id="notes_up_sub_submit">
<header class="codrops-header" style="padding:0 10px;margin-bottom:0px;text-align:justify">
<form id="form_<?php echo $tea_roll; ?>" style="display:initial" action="" autocomplete="off">
<div class="row">
<div class="col-sm-6">
<span style="padding:0;margin-top: 10px;font-size:15px;font-weight:800;text-align: left;">Select Department</span>
				<select name="select_dep<?php echo $tea_roll; ?>" id="select_dep" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
			<?php	$stmtcm = $conn->prepare('SELECT distinct dep from teacher order by dep');
$stmtcm->execute();
$resultcm = $stmtcm->get_result();
if ($resultcm->num_rows > 0) {
while($rowcm = $resultcm->fetch_assoc()) {
$tea_dep=$rowcm['dep'];
?>
				<option value="<?php echo $tea_dep ?>" <?php if($tea_depr==$tea_dep){echo "selected";} ?>><?php echo $tea_dep ?></option>
<?php }} ?>
<option value="">Add new Department</option>
				</select>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;display:inline-block;vertical-align: middle;float: left;">Email</span><span id="emailchecker" style="color:red;display:inline-block;vertical-align: middle;"></span>
				<input type="email" onkeyup="emailchecker();" required name="admit_email" id="admit_email" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" disabled value="<?php echo $tea_email; ?>">
				</p>
</div>
<input type="hidden" name="admit_roll" value="<?php echo $tea_roll; ?>">
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Name</span>
				<input required name="admit_name" id="admit_name" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" value="<?php echo $tea_name; ?>">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Phone</span>
				<input required name="admit_phone" id="admit_phone" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" value="<?php echo $tea_phone; ?>">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Date of Birth</span>
				<input type="date" required name="admit_dob" id="admit_dob" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" value="<?php echo $tea_dob; ?>">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Address Line 1</span>
				<input required name="admit_address1" id="admit_address1" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" value="<?php echo $tea_address1; ?>">
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Address Line 2</span>
				<input required name="admit_address2" id="admit_address2" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" value="<?php echo $tea_address2; ?>">
				</p>
</div>
<div class="col-sm-6">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">City</span>
				<input required name="admit_city" id="admit_city" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" value="<?php echo $tea_city; ?>">
				</p>
</div>
</div>
<div class="row">

</div>
<div class="row">
<div class="12" style="text-align: left;margin: 15px;">
<input name="tea_admin_check" value="2" type="hidden">
<input type="checkbox" name="tea_admin_check" value="3">
<label for="tea_admin_check" style="text-transform:Capitalize">Make Admin</label>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<p id="admit_tea_btnm<?php echo $tea_roll; ?>" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 14px;margin-top: 10px;margin-bottom: 0px;">
				</p>
</div>
<div class="col-sm-6">
<p id="" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<input type="submit" id="admit_tea_btn<?php echo $tea_roll; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;" value="Update">
				</p>				
</div>
</div>
</form>
</header>
</div>
<div class="modal-footer" style="padding: 10px;color: #fff;background: #30302d;"><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;"></span>
</div>
</div>

</div>
</div>	

	  <script type="text/javascript"> 
      $(document).ready(function(){
$(function() {
    $('select[name=select_dep<?php echo $tea_roll; ?>]').change( function() {
        var value = $(this).val();
        if (!value || value == '') {
           var other = prompt( "Please enter a department" );
           if (!other) return false;
           $(this).append('<option value="'
                             + other
                             + '" selected="selected">'
                             + other
                             + '</option>');
							
        } else {other=value;} 
		console.log(other);
    });
});
 $("#form_<?php echo $tea_roll; ?>").submit(function(event){
        event.preventDefault();
    form_up_teacher('<?php echo $tea_roll; ?>');
  });
  $('#editr_<?php echo $tea_roll; ?>').on('hidden.bs.modal', function () {
  $('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_tea.php');
});

	  });
	  </script>	

	<?php }} ?>	
	</div>		
<?php }} ?>	
<?php }} ?>	
	  <script type="text/javascript"> 
      $(document).ready(function(){
$(function() {
    $('select[name=select_dep]').change( function() {
        var value = $(this).val();
        if (!value || value == '') {
           var other = prompt( "Please enter a department" );
           if (!other) return false;
           $(this).append('<option value="'
                             + other
                             + '" selected="selected">'
                             + other
                             + '</option>');
							
        } else {other=value;} 
		console.log(other);
    });
});
 $("#addteacher").submit(function(event){
        event.preventDefault();
    add_up_teacher();
  });
  $('#add_a_tea').on('hidden.bs.modal', function () {
  $('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_tea.php');
});

	  });
	  </script>		