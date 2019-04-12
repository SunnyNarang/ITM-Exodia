<?php
if ( ! defined('IN_SITE') )
header('Location: ../index.php');
$stmt = $conn->prepare('SELECT student.*, class.name as class, class.branch as branch, class.course as course, class.sem as sem FROM student inner join class on student.class_id=class.id where student.roll = ? or student.email = ?');
$stmt->bind_param('ss', $roll, $roll);

$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $stu_name=$row['name'];
	   $stu_course=$row['course'];
	   $stu_email=$row['email'];
	   $stu_f_name=$row['f_name'];
	   $stu_f_mob=$row['f_mob'];
	   $stu_address1=$row['address1'];
	   $stu_address2=$row['address2'];
	   $stu_city=$row['city'];
	   $stu_phone=$row['phone'];
	   $stu_class_id=$row['class_id'];
	   $stu_sem=$row['sem'];
	   $stu_class=$row['class'];
	   $stu_branch=$row['branch'];
    }
}
$name = explode(' ',trim($stu_name));
?>
<div class="card">
							  <div class="avatar-flip">
								<img src="img/<?php echo $image; ?>">
								<img src="img/<?php echo $image; ?>">
							  </div>
							  <h2 style="font-family: 'Oswald', sans-serif;"><?php echo $name[0]; ?> <span style="color:#585858"><?php echo $name[1]; ?></span></h2>
							  <h4 style="font-family: 'Titillium Web', sans-serif;font-size: 21px;color: #ec4141;font-weight: 800;"><?php echo $roll; ?></h4>
							  <div class="hideme"><h4 style="font-family: 'Titillium Web', sans-serif;"><?php echo $stu_course; ?> - <?php echo $stu_branch; ?></h4>
							  <h3 style="font-family: 'Poiret One', cursive;font-weight: 800;margin: 0;font-size: 18px;"><?php echo $stu_class; ?> - Semester <?php echo $stu_sem; ?></h3>
							</div>
							</div>
							
							