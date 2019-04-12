<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
if(!$_POST['today']){echo '<script>window.parent.location = "index.php"</script>';}
$today=$_POST['today'];
$today=htmlspecialchars($today, ENT_QUOTES, 'UTF-8');
$course=$_POST['course'];
$course=htmlspecialchars($course, ENT_QUOTES, 'UTF-8');
?>
					<div class="daytime" style="background:#fff;padding: 3px;text-align: center;border-bottom: 1px solid #e8e8e8;">
		<?php			$stmt = $conn->prepare('SELECT distinct sem from class where course=? and branch= ?');
		$stmt->bind_param("ss", $course, $today);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $sem=$row['sem'];
	   ?>
	  <a class="itsnsem" id="<?php echo $course; ?>" datae="<?php echo $today; ?>" sem="<?php echo $sem; ?>">Sem <?php echo $sem; ?></a>
    <?php }
}?>
</div><div id="hellofnsem" style="padding:0;margin:0;width:100%"></div>
  <script type="text/javascript"> 
      $(document).ready(function(){
		  
		  
	  $('.itsnsem').click(function() {
	var alt = $(this).attr('id');
	var course = $(this).attr('datae');
	var sem = $(this).attr('sem');
	$('.itsnsem').removeClass('newitsnsem');
	$(this).addClass('newitsnsem');
	getnsem(alt, course, sem);
	});
	  });
		  </script>
