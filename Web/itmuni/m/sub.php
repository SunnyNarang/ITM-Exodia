<?php
if(!$_POST['subid']){header('Location: ../index.php');}
$subid=$_POST['subid'];
$subid=htmlspecialchars($subid, ENT_QUOTES, 'UTF-8');
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('../db.php');
$stmt = $conn->prepare('SELECT * FROM subject where id = ?');
$stmt->bind_param('s', $subid);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
	   $sub_code=$row['code'];
	   $sub_name=$row['name'];
	   $sub_type=$row['type'];
}
 ?>
 <div class="profileCard1">
                <div class="pImg">
					<span onclick="simongoback()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
                    <h1 style="float:left;display:inline-block;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">[<?php echo $sub_type; ?>] <?php echo $sub_name; ?></h1>
					<h1 style="float:right;display:inline-block;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800"><?php echo $sub_code; ?></h1>
                </div>
            </div>
			<?php
			$stmt = $conn->prepare('SELECT notes.description as description, notes.title as title, notes.file as file, teacher.name as t_name, teacher.roll as t_roll FROM notes inner join teacher on notes.teacher_id=teacher.roll where notes.sub_id = ?');
$stmt->bind_param('s', $subid);
$stmt->execute();
$result = $stmt->get_result();
			if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
			<a href="download.php?file=<?php echo $file; ?>" style="background: #30302d;color: #fff;padding: 8px 15px;display: block;width: 100px;text-align: center;border-radius: 4px;margin-top: 10px;">Download</a>
			</div>
			<div class="col-sm-6 hideme">
			<iframe src="files/<?php echo $file; ?>" style="border: 0;width: 100%;height: 125px;"></iframe>
			</div>
			</div>	
			<?php }}else {?>
			<div class="family">
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No notes found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please report to your Mentor.</span>
			</div>
			</div>		
		
<?php } ?>		
 <script>
					
			
	</script>