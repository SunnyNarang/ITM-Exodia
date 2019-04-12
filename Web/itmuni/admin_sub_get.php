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
                   <span onclick="backtoadmin_sub()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
				<div class="row">
				<div class="col-sm-12">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800"><?php echo $class_course; ?> - <?php echo $class_branch; ?> - Sem <?php echo $class_sem; ?> - <?php echo $class_name; ?></h1>
					<button data-toggle="modal" data-target="#add_a_subject" style="text-transform: inherit;letter-spacing: inherit;word-spacing: 1px;margin: 0px;margin-bottom: 10px;margin-top: -10px;">Add a Subject</button>
					<div class="modal fade" id="add_a_subject" role="dialog">
			<div class="modal-dialog" style="margin-top:90px">
			<div class="modal-content">
			<div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
			<h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800">Add a Subject</h4>
			</div>
			<div class="modal-body">
			<header class="codrops-header" style="padding:10px;margin-bottom:0px;text-align:justify">
			<form id="insertsub" style="display:initial" action="" autocomplete="off">
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Name</span>
				<input type="hidden" name="class_id" value="<?php echo $postedclass_id; ?>">
				<input name="sub_name" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" placeholder="Enter Subject Name" required>			
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Code</span>
				<input name="sub_code" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" placeholder="Enter Subject Code" required>				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-3">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Credits</span>
				<input name="sub_credits" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" placeholder="Enter Credits" required>
				</p>
			</div>
			<div class="col-sm-3">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Type</span>
				<select name="sub_type" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">
				<option value="T">Theory</option>
				<option value="P">Practical</option>
				</select>
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Teacher Roll</span>
				<input name="sub_teacher_roll" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;" placeholder="Enter Teacher's Roll" required>				
				</p>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
					<span id="sub_insert_msg"></span>			
				</p>
			</div>
			<div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-bottom: 5px;">
				<button id="sub_insert" type="submit" style="font-size: 14px;letter-spacing: 0px;">Submit</button>				
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
$stmtq = $conn->prepare('SELECT distinct type from subject where class_id = ?');
$stmtq->bind_param("s", $postedclass_id);
$stmtq->execute();
$resultq = $stmtq->get_result();
if ($resultq->num_rows > 0) {
    while($rowq = $resultq->fetch_assoc()) {
	   $class_sub_type=$rowq['type'];
 ?>			
			<div id="" class="family" style="background: #333333;font-size: 22px;padding: 8px 15px;color: #fff;font-family: titillium web;margin:0;width:100%">
			<?php echo $class_sub_type; ?> - <?php if($class_sub_type=="T"){echo 'Theory';} elseif($class_sub_type=="P"){echo 'Practical';} ?>
			</div>	
<?php			
$stmtw = $conn->prepare('SELECT * from subject where class_id = ? and type = ? order by name');
$stmtw->bind_param("ss", $postedclass_id, $class_sub_type);
$stmtw->execute();
$resultw = $stmtw->get_result();
if ($resultw->num_rows > 0) {
    while($roww = $resultw->fetch_assoc()) {
	   $class_sub_id=$roww['id'];
	   $class_sub_name=$roww['name'];	
	   $class_sub_code=$roww['code'];
	   $class_sub_credits=$roww['credits'];
	   $class_sub_teacher=$roww['teacher_roll'];
	   
	   $stmt13 = $conn->prepare('SELECT image from login where roll=?');
$stmt13->bind_param("s", $class_sub_teacher);
$stmt13->execute();
$result13 = $stmt13->get_result();
if ($result13->num_rows > 0) {
while($row13 = $result13->fetch_assoc()) {
$teacherimage=$row13['image'];		   }} else {$teacherimage="user.png";}
?>	   
			<div data-toggle="modal" data-target="#edit_sub_<?php echo $class_sub_id; ?>" id="fucking_sub_<?php echo $class_sub_id; ?>" class="family" style="width:100%;margin:0;border-left:8px solid #333;padding:10px;border-right:8px solid #333;">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $teacherimage; ?>" style="width:40px;height:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $class_sub_name; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $class_sub_code; ?> - <?php echo $class_sub_credits; ?> Credits</span>
			</div>
			<div style="display:inline-block;float:right;vertical-align:middle">
			<span style="font-family: titillium web;color: #fff;background: #333;padding: 4px 15px;text-transform: uppercase;font-size: 12px;margin-top: 11px;border-radius: 4px;">Edit</span>
			</div>
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
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Type</span>
				<select name="sub_type" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px 5px;color: #555;border:1px solid #a6a6a6;border-radius: 3px;">
				<option value="T" <?php if($class_sub_type=="T"){echo 'Selected';} ?>>Theory</option>
				<option value="P" <?php if($class_sub_type=="P"){echo 'Selected';} ?>>Practical</option>
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
<?php }} else{echo "<div class='family'>No subjects found ! Please add a subject.</div>";} ?>
	<?php }} else{echo "<div class='family'>No subjects found ! Please add a subject.</div>";} ?>
	<?php } ?>
	<script type="text/javascript">
$(document).ready(function() {
  			  $("#insertsub").submit(function(event){
        event.preventDefault();
   insertsub();
  });
	$('#add_a_subject').on('hidden.bs.modal', function () {
		closemodalsub('<?php echo $postedclass_id; ?>');
	});
});
</script>
