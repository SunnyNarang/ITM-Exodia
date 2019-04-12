<?php
ob_start();
session_start();
error_reporting(0);
$roll=$_SESSION['roll'];
$session_type=$_SESSION['type'];
if(!$roll or !$session_type){header('Location: index.php');}
if(!$_GET['roll2']){$roll2=$roll;}else{$roll2=$_GET['roll2'];}
include('db.php');
	   function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}
$stmt = $conn->prepare('SELECT * from login where roll = ?');
$stmt->bind_param('s', $roll2);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $type=$row['type'];
	   $image=$row['image'];
	   $name=$row['name'];
	   $last=$row['active'];
	   $last = strtotime($last);
    }
}else {session_destroy(); session_unset(); echo '<script>window.parent.location = "index.php"</script>';};
if($type=="1"){
$stmt0 = $conn->prepare('SELECT student.*, class.name as class, class.branch as branch, class.course as course, class.sem as sem FROM student inner join class on student.class_id=class.id where student.roll = ?');}else{
$stmt0 = $conn->prepare('SELECT * from teacher where roll = ?');}
$stmt0->bind_param('s', $roll2);
$stmt0->execute();
$result0 = $stmt0->get_result();
$result = $stmt->get_result();
if ($result0->num_rows > 0) {
    while($row0 = $result0->fetch_assoc()) {
       $stu_name=$row0['name'];
	   $stu_course=$row0['course'];
	   $stu_email=$row0['email'];
	   $stu_gender=$row0['gender'];
	   $stu_f_name=$row0['f_name'];
	   $stu_f_mob=$row0['f_mob'];
	   $stu_address1=$row0['address1'];
	   $stu_address2=$row0['address2'];
	   $stu_city=$row0['city'];
	   $stu_phone=$row0['phone'];
	   $stu_class_id=$row0['class_id'];
	   $stu_sem=$row0['sem'];
	   $stu_class=$row0['class'];
	   $stu_branch=$row0['branch'];
	   $stu_dob=$row0['dob'];
    }
}
?>
<div class="profileCard1">
                <div class="pImg" style="background:none;box-shadow:none;margin-top:-80px">
                   <img style="width: 150px;border-radius: 100%;border: 8px solid #f3efe0;" src="img/<?php echo $image; ?>">
                </div>
                <div class="pDes">
                    <h1 class="" style="text-align:left;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">
					<div class="row" style="text-align:left">
					<div class="col-sm-6" style="margin-top:10px">
					<span style="display:block;font-family: 'Oswald', sans-serif;color:#585858"><?php echo $stu_name; ?></span>
					<span style="display:block;font-size: 21px;color: #ec4141;font-weight: 800;margin-top: 10px;"><?php echo $roll2; ?></span>
					<span style="display:block;font-family: 'Poiret One', cursive;font-weight: 800;margin: 0;font-size: 18px;margin-top: 10px;"><?php echo $stu_class. "- Semester". $stu_sem; ?></span>
					</div>
					<div class="col-sm-6">
					<span style="display:block;font-family: 'Titillium Web', sans-serif;font-size:22px;margin-top: 10px;"><?php echo $stu_course; ?> - <?php echo $stu_branch; ?></span>
					<?php if(!$_GET['roll2'] or $_GET['roll2']==$roll){ 
					echo "<span style='display:block;font-family: Titillium Web, sans-serif;font-size:16px;font-style:italic;margin-top: 10px;'><i class='fa fa-circle' style='color:green;margin-right:5px'></i>Online</span>";
					} else{
					echo "<span style='color: #ec4141;display:block;font-family: Titillium Web, sans-serif;font-size:16px;font-style:italic;margin-top: 10px;'>Last active ". humanTiming($last). " ago</span>";
					}?>
					</div>
					</div>
					</h1>
                </div>
            </div>
			<div class="family" style="margin:0;width:100%;text-align: center;padding: 10px;">
			<div style="">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#8e8e8e;font-weight: 800;">
			<div class="row" style="text-align:left">
			<div class="col-sm-6">
			<span style="font-size:30px;font-family:'Oswald', sans-serif;color:#585858">Contact</span>
			<span style="font-size:16px"><?php 
			if($session_type=='1'){ if($type=='1'){echo substr($stu_phone, 0,7).'***';} else{echo $stu_phone;}}
			else{echo $stu_phone;}
			 ?></span>
			<span style="font-size:16px"><?php echo $stu_email; ?></span>
			</div>
			<div class="col-sm-6">
			<span style="font-size:30px;font-family:'Oswald', sans-serif;color:#585858">Academics</span>
			<span style="font-size:16px">Attendance : <?php
			$stmt1 = $conn->prepare('select count(*) as went from (SELECT * FROM attendance where roll = ? and status = "1") s');
		$stmt1->bind_param('s', $roll2);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		if ($result1->num_rows > 0) {
	   while($row1 = $result1->fetch_assoc()){
	   $hewent=$row1['went'];}}else{$hewent="00";}
	   
$stmt2 = $conn->prepare('select count(*) as otal from (SELECT * FROM attendance where roll = ? ) s');
		$stmt2->bind_param('s', $roll2);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		if ($result2->num_rows > 0) {
	   while($row2 = $result2->fetch_assoc()){
	   $otal=$row2['otal'];}}else{$otal="00";}
			$percentage= round($hewent/$otal*100,1); 
				echo 	$percentagewith=$percentage."%";
			?></span>
			<span style="font-size:16px">CGPA : 8.8</span>
			</div>
			</div>
			</span>
			</div>
			</div>
			
			<div class="family" style="margin:0;width:100%;text-align: center;padding: 10px;">
			<div style="">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#8e8e8e;font-weight: 800;">
			<div class="row" style="text-align:left">
			<div class="col-sm-6">
			<span style="font-size:30px;font-family:'Oswald', sans-serif;color:#585858">Address</span>
			<span style="font-size:16px"><?php echo $stu_address1; ?></span>
			<span style="font-size:16px"><?php echo $stu_address2; ?></span>
			<span style="font-size:16px"><?php echo $stu_city; ?></span>
			</div>
			<div class="col-sm-6">
			<span style="font-size:50px;color:#585858"><i class="fa fa-birthday-cake"></i></span>
			<span style="font-size:20px"><?php echo $stu_dob; ?></span>
			</div>
			</div>
			</span>
			</div>
			</div>	
			<div class="family" style="margin:0;width:100%;text-align: left;padding: 10px;border-radius:0px 0px 6px 6px">
			<div style="">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#8e8e8e;font-weight: 800;">
			<div class="row" style="text-align:left">
			<div class="col-sm-6">
			<span style="font-size:30px;font-family:'Oswald', sans-serif;color:#585858">Guardian Name</span>
			<span style="font-size:16px"><?php echo $stu_f_name; ?></span>
			</div>
			<div class="col-sm-6">
			<span style="font-size:30px;font-family:'Oswald', sans-serif;color:#585858">Guardian Number</span>
			<span style="font-size:16px"><?php echo substr($stu_f_mob, 0,7); ?>***</span>
			</div>
			</div>
			</span>
			</div>
			</div>
  <script>
	
				</script>
    <script type="text/javascript" src="js/jquery.isotope.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
				
				<script type="text/javascript">

	$('.date-input').datetimepicker({
        language:  'en',
		format: 'yyyy-mm-dd',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
$(function () {
                $('#datetimepicker1').datetimepicker();
            });
	
        </script>
<script type="text/javascript">
$(document).ready(function() {
    
	$("#datetimepicker1").change(function() {
		$('#loadnotice').html('<img src=img/loader.gif style="margin-top: 25%;">');
		$.get('searchnotice.php?parent=' + $('#date').val(), function(data) {
			$("#loadnotice").html(data);
		});	
    });

});
</script>