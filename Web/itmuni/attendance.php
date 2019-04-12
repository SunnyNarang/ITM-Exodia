<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');
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
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-bar-chart" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Attendance</h1>
					<?php $percentage= round($hewent/$otal*100,1); 
					$percentagewith=$percentage."%";
					$percentagefordata=explode(".",$percentage);
					$percentagefordataw="0.".$percentagefordata[0].$percentagefordata[1];
					if($percentagefordataw=="0.100"){$percentagefordataw="1";}
					if($percentage>="75")
					{$watercolor='rgba(33, 125, 22, 1)';$textcolor='rgba(8, 78, 8, 0.8)';}
				elseif($percentage<="75" and $percentage>="40")
				{$watercolor='rgba(228, 137, 42, 1)';$textcolor='rgba(179, 102, 22, 0.8)';}else{
					$watercolor='rgba(218, 53, 37, 1)';$textcolor='rgba(179, 33, 19, 0.8)';};
					?> 
                </div>
            </div>
<div class="family" style="text-align:center;background:#fff;margin:0;width:100%">
			<canvas onclick="reloadatt();" id="demo-3" style="demo"></canvas>
			<div style="border-top: 1px solid #ccc;margin-top: 15px;">
			<div class="col-sm-6" style="font-size: 25px;font-family: Oswald;color: #424240;margin-top: 10px;">
			<span>Total classes attended = <span class="count" style="display:initial"><?php echo $hewent; ?></span></span>
		</div>
					<div class="col-sm-6" style="font-size: 25px;font-family: Oswald;color: #424240;margin-top: 10px;">
			<span>Total classes held = <span class="count" style="display:initial"><?php echo $otal; ?></span></span>
		</div>
			</div>
			</div>
    <script type="text/javascript" src="js/waterbubble.min.js"></script>
  <script>
	$('#demo-3').waterbubble({txt: '<?php echo $percentagewith; ?>',radius: 100,data: <?php echo $percentagefordataw; ?>,wave: true,animation: true, waterColor: '<?php echo $watercolor; ?>',textColor: '<?php echo $textcolor; ?>',});
	$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 500,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
				</script>
				
<div id="hellofday" class="family" style="padding:0;margin:0;width:100%;background:#fff">
				<?php
$stmt = $conn->prepare('SELECT * from student where student.roll = ? or student.email = ?');
$stmt->bind_param('ss', $roll, $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $class_id=$row['class_id'];
    }
}else {header('Location: index.php');}
$stmt = $conn->prepare('SELECT * FROM subject where class_id = ?');
$stmt->bind_param('s', $class_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $mon_sub_id=$row['id'];
	   $mon_sub_code=$row['code'];
	   $mon_name=$row['name'];
	   $mon_sub_type=$row['type'];
	   $sub_teacher=$row['teacher_roll'];
	   
	    $stmt0 = $conn->prepare('SELECT name as t_name FROM teacher where roll = ?');
		$stmt0->bind_param('s', $sub_teacher);
		$stmt0->execute();
		$result0 = $stmt0->get_result();
	   while($row0 = $result0->fetch_assoc()){
	   $teacher_name=$row0['t_name'];}
	   
	    $stmt4 = $conn->prepare('select count(*) as went from (SELECT * FROM attendance where roll = ? and sub_id = ? and status = "1") s');
		$stmt4->bind_param('ss', $roll, $mon_sub_id);
		$stmt4->execute();
		$result4 = $stmt4->get_result();
		if ($result4->num_rows > 0) {
	   while($row4 = $result4->fetch_assoc()){
	   $hewent=$row4['went'];}}else{$hewent="00";}
	   
	    $stmt5 = $conn->prepare('select count(*) as otal from (SELECT * FROM attendance where roll = ? and sub_id = ?) s');
		$stmt5->bind_param('ss', $roll, $mon_sub_id);
		$stmt5->execute();
		$result5 = $stmt5->get_result();
		if ($result5->num_rows > 0) {
	   while($row5 = $result5->fetch_assoc()){
	   $otal=$row5['otal'];}}else{$otal="00";}
?>
<div style="border-left:3px solid #00baff;padding-left:10px;margin:20px">
<div style="display:inline-block;vertical-align:middle">
<span style="font-family: 'Titillium Web', sans-serif;font-size:16px;font-weight:800;color:#00baff"><a class="btn btn-info btn-md" style="padding: 2px 8px;margin: 0;vertical-align: middle;margin-right: 5px;text-align:uppercase"><?php echo $mon_sub_type; ?></a><?php echo $mon_name; ?> - <?php echo $mon_sub_code; ?></span>
<span style="font-family: 'Oswald', sans-serif;"><?php echo $teacher_name; ?></span>
</div>
<div style="float: right;font-family: 'Titillium Web', sans-serif;font-size: 20px;font-weight: 800;color: #565656;">
<span style="float:right"><span style="border-bottom:1px solid #00baff" class="count"><?php echo $hewent; ?></span><span class="count"><?php echo $otal; ?></span></span>
</div>
</div>
<?php
}}else{
?>
<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No time table found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please report to your Mentor.</span>
			</div>
<?php } ?>
</div>