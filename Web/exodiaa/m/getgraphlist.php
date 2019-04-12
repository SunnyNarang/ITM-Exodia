<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
  include("fusioncharts.php");
if(!$_POST['class_id']){echo '<script>window.parent.location = "index.php"</script>';}
$postedclass_id=$_POST['class_id'];
$postedclass_id=htmlspecialchars($postedclass_id, ENT_QUOTES, 'UTF-8');
?>
<?php
$stmt = $conn->prepare('SELECT roll, ROUND(SUM(status = 1)/COUNT(*) * 100) AS att
FROM attendance
where class_id=?
GROUP BY roll order by roll');
$stmt->bind_param("s", $postedclass_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $stu_roll=$row['roll'];
	   $stu_att=$row['att'];
	   $stmt1 = $conn->prepare('SELECT * from student where roll=?');
		$stmt1->bind_param("s", $stu_roll);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		if ($result1->num_rows > 0) {
			 while($row1 = $result1->fetch_assoc()) {
				 $stu_name=$row1['name'];
			 }
		}

?>
	<div class="family" onclick="gotodgraph('<?php echo $stu_roll; ?>', '<?php echo $postedclass_id; ?>', '<?php echo $stu_att; ?>', '<?php echo $stu_name; ?>')" style="width:100%;margin:0;border-left:8px solid <?php if($stu_att>="75"){echo "#0a5f09";} else {echo "#800c0c";} ?>;padding:10px;border-right:8px solid <?php if($stu_att>="75"){echo "#0a5f09";} else {echo "#800c0c";} ?>;">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $stu_roll; ?>.jpg" style="width:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $stu_name; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $stu_roll; ?></span>
			</div>
			<div style="display:inline-block;float:right;vertical-align:middle">
			<span style="font-family: 'Oswald', sans-serif;color:<?php if($stu_att>="75"){echo "#0a5f09";} else {echo "#800c0c";} ?>;font-size: 25px;margin-top: 3px;"><?php echo $stu_att; ?> %</span>
			</div>
			</div>

<?php }}?>			
