<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-th-large" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Manage Subjects</h1>
                </div>
            </div>
<?php
$stmtc = $conn->prepare('SELECT distinct course from class order by course');
$stmtc->execute();
$resultc = $stmtc->get_result();
if ($resultc->num_rows > 0) {
while($rowc = $resultc->fetch_assoc()) {
$editcourse=$rowc['course'];			
?>
	<div class="row family" style="margin:0;background:#fff;width:100%;text-align:left">
	<span style="text-align: left;font-size: 30px;font-family: Oswald;font-weight: 600;color: #585858"><?php echo $editcourse; ?></span>
	<?php
	$stmts = $conn->prepare('SELECT distinct sem from class where course = ? order by sem');
	$stmts->bind_param("s", $editcourse);
	$stmts->execute();
	$results = $stmts->get_result();
	if ($results->num_rows > 0) {
	while($rows = $results->fetch_assoc()) {
	$editsem=$rows['sem'];
	?>
		<span style="text-align: left;font-size: 20px;font-family: 'Titillium Web', sans-serif;font-weight: 600;color: #00baff;margin-bottom: 8px;">Semester <?php echo $editsem; ?></span>
		<?php
		$stmtb = $conn->prepare('SELECT distinct branch from class where course = ? and sem = ? order by branch');
		$stmtb->bind_param("ss", $editcourse, $editsem);
		$stmtb->execute();
		$resultb = $stmtb->get_result();
		if ($resultb->num_rows > 0) {
		while($rowb = $resultb->fetch_assoc()) {
		$editbranch=$rowb['branch'];	
		?>
			<span style="text-align: left;font-size: 20px;color: #696767;border-right: 10px solid #ec4141;border-left: 10px solid #ec4141;font-family: 'Titillium Web', sans-serif;margin-right: 5px;font-weight: 600;display:initial;padding: 0px 10px;border-radius:5px;margin-bottom:10px"><?php echo $editbranch; ?></span>
			<?php
			$stmtn = $conn->prepare('SELECT id,name from class where course = ? and sem = ? and branch = ? order by name');
			$stmtn->bind_param("sss", $editcourse, $editsem, $editbranch);
			$stmtn->execute();
			$resultn = $stmtn->get_result();
			if ($resultn->num_rows > 0) {
			while($rown = $resultn->fetch_assoc()) {
			$editid=$rown['id'];	
			$editname=$rown['name'];	
			?>
			<span onclick="admin_sub_get('<?php echo $editid; ?>')" style="text-align: left;font-size: 16px;background: #696767;font-family: 'Titillium Web', sans-serif;font-weight: 600;display: inline-block;padding: 5px 10px;border-radius: 5px;margin-right: 10px;margin-bottom: 10px;color: #fff;"><?php echo $editname; ?><i class="fa fa-pencil-square" style="margin-left:8px"></i></span>
            
			<?php }} ?>	<br>
		<?php }} ?>	
	<?php }} ?>	
	</div>		
<?php }} ?>	
	  <script type="text/javascript"> 
      $(document).ready(function(){
	  });
	  </script>		