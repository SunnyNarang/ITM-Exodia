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
?>
					<div class="daytime" style="background:#fff;padding: 3px;text-align: center;border-bottom: 1px solid #e8e8e8;">
		<?php			$stmt = $conn->prepare('SELECT distinct branch from class where course=?');
		$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $branch=$row['branch'];
	   ?>
	   <a class="itsnbranch" id="<?php echo $branch; ?>" datae="<?php echo $today; ?>"><?php echo $branch; ?></a>
    <?php }
}?>
</div>
<div id="hellofnbranch" style="padding:0;margin:0;width:100%"></div>
  <script type="text/javascript"> 
      $(document).ready(function(){
		  
		  
	  $('.itsnbranch').click(function() {
	var alt = $(this).attr('id');
	var course = $(this).attr('datae');
	$('.itsnbranch').removeClass('newitsnbranch');
	$(this).addClass('newitsnbranch');
	getnclass(alt, course);
	});
	  });
		  </script>