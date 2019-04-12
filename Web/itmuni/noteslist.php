<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "./index.php"</script>';}
include('db.php');
if(!$_POST['sub']){echo '<script>window.parent.location = "index.php"</script>';}
$postedsub=$_POST['sub'];
$postedsub=htmlspecialchars($postedsub, ENT_QUOTES, 'UTF-8');
?>
<?php
			$stmt = $conn->prepare('SELECT notes.id as n_id, notes.description as description, notes.title as title, notes.file as file, teacher.name as t_name, teacher.roll as t_roll FROM notes inner join teacher on notes.teacher_id=teacher.roll where notes.sub_id = ?');
$stmt->bind_param('s', $postedsub);
$stmt->execute();
$result = $stmt->get_result();
			if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$n_id=$row['n_id'];
	   $title=$row['title'];
	   $file=$row['file'];
	   $desc=$row['description'];
	   $t_name=$row['t_name'];
	   $t_roll=$row['t_roll'];
	   ?>
	   			<div class="family" style="width:100%;margin:0">
			<div class="col-sm-6">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;"><?php echo $title; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $desc; ?></span>
			<a style="font-family: 'Titillium Web', sans-serif;color:#00baff;margin-top:10px;display:block">- <?php echo $t_name; ?></a>
			<a href="download.php?file=<?php echo $file; ?>" style="background: #30302d;color: #fff;padding: 8px 15px;display:inline-block;width: 100px;text-align: center;border-radius: 4px;margin-top: 10px;">Download</a> <a onclick="delnoteslog('<?php echo $n_id; ?>')" style="background: #ec4141;color: #fff;padding: 8px 15px;display:inline-block;width: 100px;text-align: center;border-radius: 4px;margin-top: 10px;">Delete</a>
			</div>
			<div class="col-sm-6 hideme">
			<iframe src="files/<?php echo $file; ?>" style="border: 0;width: 100%;height: 125px;"></iframe>
			</div>
			</div>	
			<?php }}else {?>
			<div class="family" style="width:100%;margin:0">
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No notes found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please report to your Mentor.</span>
			</div>
			</div>		
		
<?php } ?>		