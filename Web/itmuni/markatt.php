<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
?>
<div class="profileCard1" style="padding-bottom:0px">
                <div class="pImg">
                   <span onclick="backtoatt()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="margin-bottom:10px;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Mark Attendance</h1>
					<div class="daytime">
		<?php			$stmt = $conn->prepare('SELECT distinct course from class');
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $course=$row['course'];
	   ?>
	   <a class="itsexam" id="<?php echo $course; ?>"><?php echo $course; ?></a>
    <?php }
}?>
					
					</div>
				</div>
            </div>
			<div id="hellofday" class="family" style="padding:0;margin:0;width:100%">
<div id="hellofcourse" style="padding:0;margin:0;width:100%"></div>
			</div>	
			
  <script type="text/javascript"> 
      $(document).ready(function(){
		  
		  
	  $('.itsexam').click(function() {
	var alt = $(this).attr('id');
	$('.itsexam').removeClass('newitsexam');
	$(this).addClass('newitsexam');
	getbranch(alt);
	});
	  });
		  </script>
