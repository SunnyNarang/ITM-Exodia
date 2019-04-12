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
			<canvas onclick="reloadteaatt();" id="demo-3" style="demo"></canvas>
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

</div>