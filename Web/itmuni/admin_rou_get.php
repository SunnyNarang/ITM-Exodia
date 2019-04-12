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
                   <span onclick="backtoadmin_rou()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
				<div class="row">
				<div class="col-sm-12">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800"><?php echo $class_course; ?> - <?php echo $class_branch; ?> - Sem <?php echo $class_sem; ?> - <?php echo $class_name; ?></h1>
					<button data-toggle="modal" data-target="#add_a_routine" style="text-transform: inherit;letter-spacing: inherit;word-spacing: 1px;margin: 0px;margin-bottom: 10px;margin-top: -10px;">Add a Routine</button>
					<div class="modal fade" id="add_a_routine" role="dialog">
			<div class="modal-dialog" style="margin-top:90px">
			<div class="modal-content">
			<div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
			<h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800">Add a Routine</h4>
			</div>
			<div class="modal-body">
			<header class="codrops-header" style="padding:10px;margin-bottom:0px;text-align:justify">
			<form id="insertrou" style="display:initial" action="" autocomplete="off">
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Day</span>
				<input type="hidden" name="class_id" value="<?php echo $postedclass_id; ?>">
				<select name="add_rou_day" id="add_rou_day" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="Monday">Monday</option>
				<option value="Tuesday">Tuesday</option>
				<option value="Wednesday">Wednesday</option>
				<option value="Thursday">Thursday</option>
				<option value="Friday">Friday</option>
				<option value="Saturday">Saturday</option>
				</select>				
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Subject</span>
				<select name="add_rou_sub" id="add_rou_sub" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<?php
				$stmtq = $conn->prepare('SELECT id, code, name, type from subject where class_id=?');
				$stmtq->bind_param("s", $postedclass_id);
				$stmtq->execute();
				$resultq = $stmtq->get_result();
				if ($resultq->num_rows > 0) {
				while($rowq = $resultq->fetch_assoc()) {
				$sub_id=$rowq['id'];
				$sub_name=$rowq['name'];
				$sub_type=$rowq['type'];
				$sub_code=$rowq['code'];
				?>
				<option value="<?php echo $sub_id; ?>">[<?php echo $sub_type; ?>] <?php echo $sub_code; ?> - <?php echo $sub_name; ?></option>
				<?php }}?>
				</select>			
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-3">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Start time</span>
				<input name="add_rou_start" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" type="time" required>
				</p>
			</div>
			<div class="col-sm-3">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">End time</span>
				<input name="add_rou_end" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" type="time" required>
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Batch</span>
				<select name="sub_batch" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">
				<option value="0" >All Students</option>
				<option value="B1" >B1</option>
				<option value="B2" >B2</option>
				</select>		
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
					<span id="sub_rou_msg"></span>			
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<button id="sub_rou" type="submit" style="font-size: 14px;letter-spacing: 0px;">Submit</button>				
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
				</div>
            </div>
<?php
$stmtq = $conn->prepare("SELECT distinct day FROM `routine` WHERE class_id= ? ORDER BY FIELD(day, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY');");
$stmtq->bind_param("s", $postedclass_id);
$stmtq->execute();
$resultq = $stmtq->get_result();
if ($resultq->num_rows > 0) {
    while($rowq = $resultq->fetch_assoc()) {
	   $class_row_day=$rowq['day'];
 ?>			
			<div id="" class="family" style="background: #333333;font-size: 22px;padding: 8px 15px;color: #fff;font-family: titillium web;margin:0;width:100%">
			<?php echo $class_row_day; ?>
			</div>	
<?php			
$stmtw = $conn->prepare('SELECT id, sub_id, start_time, end_time, batch from routine where class_id = ? and day = ? order by start_time');
$stmtw->bind_param("ss", $postedclass_id, $class_row_day);
$stmtw->execute();
$resultw = $stmtw->get_result();
if ($resultw->num_rows > 0) {  ?>
<div class="family" style="width:100%;margin:0;border-left:8px solid #333;padding:10px;border-right:8px solid #333;">
<?php
    while($roww = $resultw->fetch_assoc()) {
	   $class_row_id=$roww['id'];
	   $class_row_sub_id=$roww['sub_id'];	
	   $class_row_start_time=$roww['start_time'];
	   $class_row_end_time=$roww['end_time'];
	   $class_row_batch=$roww['batch'];
	   
	   $stmt13 = $conn->prepare('SELECT name,code,type from subject where id=?');
$stmt13->bind_param("s", $class_row_sub_id);
$stmt13->execute();
$result13 = $stmt13->get_result();
if ($result13->num_rows > 0) {	
while($row13 = $result13->fetch_assoc()) {
$sub_name=$row13['name'];
$sub_code=$row13['code'];
$sub_type=$row13['type'];		   }}
?>	   
			
			<div class="col-sm-2" style="padding:0;vertical-align:middle">
			<span style="font-family: Oswald;font-weight: 400;font-size: 15px;"><?php echo date("g:i a", strtotime($class_row_start_time)); ?> - <?php echo date("g:i a", strtotime($class_row_end_time)); ?></span>
			<span style="font-family: Titillium Web;font-size: 15px;font-weight: 400;">
			<span style="display: inline;background: #333;color: #fff;padding: 0px 5px;border-radius: 4px;margin-right: 5px;"><?php echo $sub_type; ?></span><?php echo $sub_code; ?></span>
			<span style="font-family: Titillium Web;font-size: 15px;font-weight: 400;"><?php echo $sub_name; ?></span>
			<span  data-toggle="modal" data-target="#edit_sub_<?php echo $class_sub_id; ?>" id="fucking_sub_<?php echo $class_sub_id; ?>" class="btn-md" style="display: initial;color:#fff;padding: 4px 10px;font-size: 10px;border-radius: 3px;">EDIT</span>
			</div>
			
			
			<div class="modal fade" id="edit_sub_<?php echo $class_sub_id; ?>" role="dialog">
			<div class="modal-dialog" style="margin-top:90px">
			<div class="modal-content">
			<div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
			<h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800"><?php echo $class_sub_name; ?></h4>
			<span onclick="del_subject('<?php echo $class_sub_id; ?>')" style="background: #ec2929;color: #fff;font-family: Titillium Web;padding: 4px 10px;display: inline-block;border-radius: 4px;vertical-align: middle;font-size: 12px;cursor:pointer"><i class="fa fa-warning" style="margin-right:5px"></i>Delete</span>
			</div>
			<div class="modal-body">
			<header class="codrops-header" style="padding:10px;margin-bottom:0px;text-align:justify">
			<form id="updatesub_<?php echo $class_sub_id; ?>" style="display:initial" action="" autocomplete="off">
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Name</span>
				<input name="sub_name" value="<?php echo $class_sub_name; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" required>				
				<input name="sub_id" type="hidden" value="<?php echo $class_sub_id; ?>">
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Code</span>
				<input name="sub_code" value="<?php echo $class_sub_code; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" required>				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-3">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Credits</span>
				<input name="sub_credits" value="<?php echo $class_sub_credits; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" required>
				</p>
			</div>
			<div class="col-sm-3">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Batch</span>
				<select name="sub_batch" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">
				<option value="0" >B1</option>
				<option value="B2" >B2</option>
				</select>
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Teacher Roll</span>
				<input name="sub_teacher_roll" value="<?php echo $class_sub_teacher; ?>" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" required>				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
					<span id="sub_update_msg_<?php echo $class_sub_id; ?>"></span>			
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<button id="sub_update_<?php echo $class_sub_id; ?>" type="submit" style="font-size: 14px;letter-spacing: 0px;">Update</button>				
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
			  $("#updatesub_<?php echo $class_sub_id; ?>").submit(function(event){
        event.preventDefault();
   updatesubject('<?php echo $class_sub_id; ?>');
  });
  
    $('#edit_sub_<?php echo $class_sub_id; ?>').on('hidden.bs.modal', function () {
		closemodalsub('<?php echo $postedclass_id; ?>');
	});
});
</script>			
<?php } ?></div> <?php } else{echo "<div class='family'>No routine found.</div>";} ?>
	<?php }} else{echo "<div class='family'>No routine found.</div>";} ?>
	<?php } ?>
	<script type="text/javascript">
$(document).ready(function() {
  			  $("#insertrou").submit(function(event){
        event.preventDefault();
   insertrou();
  });
	$('#add_a_routine').on('hidden.bs.modal', function () {
		closemodalrou('<?php echo $postedclass_id; ?>');
	});
});
</script>
