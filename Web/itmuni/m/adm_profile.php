<?php
if ( ! defined('IN_SITE') )
header('Location: ../index.php');
$stmt = $conn->prepare('SELECT * from teacher where teacher.roll = ? or teacher.email = ?');
$stmt->bind_param('ss', $roll, $roll);

$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $tea_name=$row['name'];
	   $tea_dep=$row['dep'];
	   $tea_email=$row['email'];
	   $tea_address1=$row['address1'];
	   $tea_address2=$row['address2'];
	   $tea_city=$row['city'];
	   $tea_phone=$row['phone'];
    }
}
$name = explode(' ',trim($tea_name));
?>
<div class="card">
							  <div class="avatar-flip">
								<img src="img/<?php echo $image; ?>">
								<img src="img/<?php echo $image; ?>">
							  </div>
							  <h2 style="font-family: 'Oswald', sans-serif;"><?php echo $name[0]; ?> <span style="color:#585858"><?php echo $name[1]; ?></span></h2>
							  <h4 style="font-family: 'Titillium Web', sans-serif;font-size: 21px;color: #ec4141;font-weight: 800;"><?php echo $roll; ?></h4>
							  <div class="hideme"><h4 style="font-family: 'Titillium Web', sans-serif;"><?php echo $tea_dep; ?></h4>
							  
							</div>
							</div>
							
							