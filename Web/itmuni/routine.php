<?php
ob_start();
error_reporting(0);
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
}else {header('Location: index.php');}

?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-dashcube" style="font-size:25px"></span>
					<!--<span style="font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>-->
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="margin-bottom:10px;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Class Routine</h1>
					<div class="daytime">
					<a class="itsday" id="monday">M</a>
					<a class="itsday" id="tuesday" style="padding:8px 14px">T</a>
					<a class="itsday" id="wednesday">W</a>
					<a class="itsday" id="thursday" style="padding:8px 14px">T</a>
					<a class="itsday" id="friday" style="padding:8px 14px">F</a>
					<a class="itsday" id="saturday" style="padding:8px 14px">S</a>
					</div>
				</div>
            </div>
			<div id="hellofday" class="family" style="padding:0;margin:0;width:100%">
<?php include('routineday.php'); ?>
			</div>	
			<?php $dayvict=date('l'); $dayvict=strtolower($dayvict); ?>
			
  <script type="text/javascript"> 
      $(document).ready(function(){
		  
		  $("#<?php echo $dayvict ?>").addClass('newitsday');
		  
	  $('.itsday').click(function() {
	var alt = $(this).attr('id');
	$('.itsday').removeClass('newitsday');
	$(this).addClass('newitsday');
	gotoday(alt);
	});
	  });
		  </script>
