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
$sem=$_POST['sem'];
$sem=htmlspecialchars($sem, ENT_QUOTES, 'UTF-8');
?>
					<div class="daytime" style="background:#fff;padding: 3px;text-align: center;">
		<?php			$stmt = $conn->prepare('SELECT distinct name,id from class where course=? and branch= ? and sem=?');
		$stmt->bind_param("sss", $today, $course, $sem);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $name=$row['name'];
	   $class_id=$row['id'];
	   ?>
	   <a class="itsnclass" id="<?php echo $class_id; ?>"><?php echo $name; ?></a>
    <?php }
}?>
</div><div id="hellofnlist" style="padding:0;margin:0;width:100%"></div>
  <script type="text/javascript"> 
      $(document).ready(function(){
		  
		  
	  $('.itsnclass').click(function() {
	var alt = $(this).attr('id');
	$('.itsnclass').removeClass('newitsnclass');
	$(this).addClass('newitsnclass');
	getnlist(alt);
	});
	  });
		  </script>
