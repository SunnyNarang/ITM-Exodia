<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
?>
<div class="profileCard1" style="">
                <div class="pImg">
                   <span id="backtobutt" onclick="backtonotes()" style="cursor:pointer;font-size: 10px;font-weight: 800;"><i class="fa fa-arrow-left" style="display: block;font-size: 15px;line-height: 18px;margin-top: -5px;"></i>GO BACK</span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="margin-bottom:10px;font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Your Notes</h1>
				</div>
            </div>
			<div id="hellofattlog" class="family" style="padding:0;margin:0;width:100%">
					<?php			
					$stmt = $conn->prepare('SELECT * from notes where teacher_id=? ');
					$stmt->bind_param("s", $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
 $notes_id=$row['id'];	  
	  $notes_title=$row['title'];
	   $notes_file=$row['file'];
	   $notes_date=$row['date'];
	   $notes_sub_id=$row['sub_id'];
	   $notes_description=$row['description'];
	   
$stmt1 = $conn->prepare('SELECT * from subject where id=?');
$stmt1->bind_param("s", $notes_sub_id);
$stmt1->execute();
$result1 = $stmt1->get_result(); 
while($row1 = $result1->fetch_assoc()) {  
	$sub_code=$row1['code'];
	$sub_name=$row1['name'];
	$sub_type=$row1['type'];
	$class_id=$row1['class_id'];
}

$stmt0 = $conn->prepare('SELECT * from class where id=?');
$stmt0->bind_param("s", $class_id);
$stmt0->execute();
$result0 = $stmt0->get_result(); 
while($row0 = $result0->fetch_assoc()) {  
	$class_course=$row0['course'];
	$class_name=$row0['name'];
	$class_branch=$row0['branch'];
	$class_sem=$row0['sem'];
}

	   ?>
	   <div class="family" style="font-weight:800;width:100%;margin:0;padding:8px">
	   <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md"><?php echo $notes_date; ?></span> - <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md"><?php echo $class_course; ?></span> - <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md"><?php echo $class_branch; ?></span> - <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md">Sem <?php echo $class_sem; ?></span> - <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md"><?php echo $class_name; ?></span> - <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md"><?php echo $sub_code; ?> - <?php echo $sub_name; ?></span> - <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md"><?php echo $sub_type; ?></span> - <span style="margin: 1px 0px;display: inline-block;" class="btn btn-info btn-md"><?php echo $notes_title; ?></span> <span style="margin: 1px 0px;display: inline-block;background: #ea4335;box-shadow: 1px 1px 4px #4a4747;" class="btn btn-info btn-md" onclick="delnoteslog('<?php echo $notes_id; ?>');">Delete</span>
	   </div>
    <?php }
} else{echo "<div class='family'>No logs available !</div>";}?>
			</div>	

