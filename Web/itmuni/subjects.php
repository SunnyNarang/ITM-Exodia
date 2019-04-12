<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');
$stmt = $conn->prepare('SELECT * from student where student.roll = ? or student.email = ?');
$stmt->bind_param('ss', $roll, $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $class_id=$row['class_id'];
    }
}
$stmt1 = $conn->prepare('select count(*) as went from (SELECT * FROM attendance where roll = ? and status = "1") s');
		$stmt1->bind_param('s', $roll);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		if ($result1->num_rows > 0) {
	   while($row1 = $result1->fetch_assoc()){
	   $hewent=$row1['went'];}}else{$hewent="00";}
	   
$stmt2 = $conn->prepare('select count(*) as otal from (SELECT * FROM attendance where roll = ? ) s');
		$stmt2->bind_param('s', $roll);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		if ($result2->num_rows > 0) {
	   while($row2 = $result2->fetch_assoc()){
	   $otal=$row2['otal'];}}else{$otal="00";}	
	 
	 $percentage= round($hewent/$otal*100,1);   
$stmt = $conn->prepare('SELECT * FROM subject where class_id = ?');
$stmt->bind_param('s', $class_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-book" style="font-size:25px"></span>
					<!--<span style="font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>-->
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Your Subjects</h1>
                </div>
            </div>
<?php
if ($percentage>=30){
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $sub_id=$row['id'];
	   $sub_name=$row['name'];
	   $sub_code=$row['code'];
	   $sub_type=$row['type'];
	   $sub_teacher=$row['teacher_roll'];
	    $stmt0 = $conn->prepare('SELECT name as t_name FROM teacher where roll = ?');
		$stmt0->bind_param('s', $sub_teacher);
		$stmt0->execute();
		$result0 = $stmt0->get_result();
	   while($row0 = $result0->fetch_assoc()){
	   $teacher_name=$row0['t_name'];}
?>			
			<div class="family" onclick="subjects(<?php echo $sub_id; ?>);">
			<input value="<?php echo $sub_id; ?>" type="hidden" id="hideid<?php echo $sub_id; ?>">
			<div style="display:inline-block;float:left">
			<a class="btn btn-info btn-md" style="font-size: 24px;margin: 0;vertical-align: middle;margin-top: 4px;margin-right: 10px;"><?php echo $sub_type; ?></a>
			</div>
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;"><?php echo $sub_name; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $sub_code; ?> - <?php echo $teacher_name; ?></span>
			</div>
			<div style="display:inline-block;float:right">
			<a class="btn btn-info btn-md">View</a>
			</div>
			</div>
<?php } }else {?>
			<div class="family">
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No subjects found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please report to your Mentor.</span>
			</div>
			</div>			
<?php } ?>		
<?php }else { ?>
<div class="family">
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">Sorry, your attendance is too low !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">You need at least 30% attendance to view notes.</span>
			</div>
			</div>			
<?php } ?>	
<script>
				
			
	</script>
	<!--function subjects(id) {
						$.ajax({
						type:'GET',
						url: 'm/sub.php',
						data:{subid:$('#hideid'+id+'').val()},
						success: function(data){
						$('#no').html(data);
						},
						error:function (){}
						});
				}
				
				-->