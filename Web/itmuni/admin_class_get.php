<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
if(!$_POST['class_id']){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
$postedclass_id=$_POST['class_id'];
$postedclass_id=htmlspecialchars($postedclass_id, ENT_QUOTES, 'UTF-8');
$stmt = $conn->prepare('SELECT * from class where id = ?');
$stmt->bind_param("s", $postedclass_id);
$stmt->execute();
$result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
	   $class_course=$row['course'];
	   $class_branch=$row['branch'];
	   $class_sem=$row['sem'];
	   $class_name=$row['name'];
	   
?>
<div class="profileCard1" style="padding-bottom:0px">
                <div class="pImg">
                   <span onclick="backtoadmin_class()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
				<div class="row">
				<div class="col-sm-8">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800"><?php echo $class_course; ?> - <?php echo $class_branch; ?> - Sem <?php echo $class_sem; ?> - <?php echo $class_name; ?></h1>
				</div>
				<div class="col-sm-4">
					<span onclick="delaclass('<?php echo $postedclass_id; ?>')" style="background: #ec2929;color: #fff;font-family: Titillium Web;padding: 4px 10px;display: inline-block;border-radius: 4px;vertical-align: middle;margin: 15px;font-size: 12px;cursor:pointer"><i class="fa fa-warning" style="margin-right:5px"></i>Delete Class</span>
				</div>
				</div>
				</div>
            </div>
<?php
$stmtq = $conn->prepare('SELECT distinct batch from student where class_id = ? order by batch');
$stmtq->bind_param("s", $postedclass_id);
$stmtq->execute();
$resultq = $stmtq->get_result();
    while($rowq = $resultq->fetch_assoc()) {
	   $stu_batch=$rowq['batch'];
 ?>			
			<div id="" class="family" style="background: #333333;font-size: 22px;padding: 8px 15px;color: #fff;font-family: titillium web;margin:0;width:100%">
			<?php echo $stu_batch; ?> Batch
			</div>	
<?php			
$stmtw = $conn->prepare('SELECT * from student where class_id = ? and batch = ? order by name');
$stmtw->bind_param("ss", $postedclass_id, $stu_batch);
$stmtw->execute();
$resultw = $stmtw->get_result();
    while($roww = $resultw->fetch_assoc()) {
	   $stu_roll=$roww['roll'];	
	   $stu_name=$roww['name'];
	   $stu_email=$roww['email'];
	   $stu_dob=$roww['dob'];
	   $stu_f_name=$roww['f_name'];
	   $stu_f_mob=$roww['f_mob'];
	   $stu_address1=$roww['address1'];
	   $stu_address2=$roww['address2'];
	   $stu_city=$roww['city'];
	   $stu_phone=$roww['phone'];
	   $stu_batch=$roww['batch'];	   
	   
	   $stmt13 = $conn->prepare('SELECT image from login where roll=?');
$stmt13->bind_param("s", $stu_roll);
$stmt13->execute();
$result13 = $stmt13->get_result();
while($row13 = $result13->fetch_assoc()) {
$studentimage=$row13['image'];	
?>	   
			<div data-toggle="modal" data-target="#edit_<?php echo $stu_roll; ?>" id="fucking_<?php echo $stu_roll; ?>" class="family" style="width:100%;margin:0;border-left:8px solid #333;padding:10px;border-right:8px solid #333;">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $studentimage; ?>" style="width:40px;height:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $stu_name; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $stu_roll; ?></span>
			</div>
			<div style="display:inline-block;float:right;vertical-align:middle">
			<span style="font-family: titillium web;color: #fff;background: #333;padding: 4px 15px;text-transform: uppercase;font-size: 12px;margin-top: 11px;border-radius: 4px;">Edit</span>
			</div>
			</div>
			
			<div class="modal fade" id="edit_<?php echo $stu_roll; ?>" role="dialog">
			<div class="modal-dialog" style="margin-top:90px">
			<div class="modal-content">
			<div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
			<h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800"><?php echo $stu_roll; ?></h4>
			<span onclick="unregister_stu('<?php echo $stu_roll; ?>')" style="background: #ec2929;color: #fff;font-family: Titillium Web;padding: 4px 10px;display: inline-block;border-radius: 4px;vertical-align: middle;font-size: 12px;cursor:pointer"><i class="fa fa-warning" style="margin-right:5px"></i>Un-register Student</span>
			</div>
			<div class="modal-body">
			<header class="codrops-header" style="padding:10px;margin-bottom:0px;text-align:justify">
			<form id="adminstudetails_<?php echo $stu_roll; ?>" style="display:initial" action="" autocomplete="off">
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Name</span>
				<input name="name" value="<?php echo $stu_name; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				<input name="roll" type="hidden" value="<?php echo $stu_roll; ?>">
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Email</span>
				<input name="email" value="<?php echo $stu_email; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Date of Birth</span>
				<input name="dob" value="<?php echo $stu_dob; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Guardian Name</span>
				<input name="f_name" value="<?php echo $stu_f_name; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Guardian Mobile</span>
				<input name="f_mob" value="<?php echo $stu_f_mob; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Address Line 1</span>
				<input name="add1" value="<?php echo $stu_address1; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Address Line 2</span>
				<input name="add2" value="<?php echo $stu_address2; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">City</span>
				<input name="city" value="<?php echo $stu_city; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Phone</span>
				<input name="phone" value="<?php echo $stu_phone; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">				
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Batch</span>
				<select name="batch" id="notes_course" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="B1"<?php if($stu_batch=="B2"){echo "selected";} ?>>B1</option>	
				<option value="B2"<?php if($stu_batch=="B2"){echo "selected";} ?>>B2</option>	
				</select>				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
					<span id="det_update_msg_<?php echo $stu_roll; ?>"></span>			
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<button id="det_update_<?php echo $stu_roll; ?>" type="submit" style="font-size: 14px;letter-spacing: 0px;">Update</button>				
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
$(document).ready(function() {
			  $("#adminstudetails_<?php echo $stu_roll; ?>").submit(function(event){
        event.preventDefault();
   adminstudetails('<?php echo $stu_roll; ?>');
  });
});
</script>			
	<?php } } ?>
	<?php } ?>
	<?php } ?>

