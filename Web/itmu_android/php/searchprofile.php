<?php
error_reporting(0);

include("conn.php");

$roll=$_POST["serachid"];



$stmt = $conn->prepare("");
$stmt->bind_param('',);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $out[]=$row;
       $person=$row['person'];
$baby = $conn->prepare("SELECT name, image from login where roll = ?");
$baby->bind_param('s', $person);
$baby->execute();
$result1 = $baby->get_result();
while($row1 = $result1->fetch_assoc()) {
	$out1[] = $row1;
}
        
        
    }
    echo json_encode($out)."``%f%``".json_encode($out1);
    
}
else
	{echo "0";}

mysql_close($con);
?>