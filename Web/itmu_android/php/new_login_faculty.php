<?php
error_reporting(0);

include("conn.php");

$username= $_POST["username"];
$pass= $_POST["key"];

$stmt = $conn->prepare("SELECT vemail as email
FROM `itm_mapp_details`
WHERE (
vrollno = ?
OR vemail = ?
)
AND vappkey = ?");
$stmt->bind_param('sss', $username,$username, $pass);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
 echo json_encode($result->fetch_assoc());
 
$stmt6 = $conn->prepare("SELECT * 
FROM  `DynamicLinks`");
$stmt6->execute();
$result6 = $stmt6->get_result();
if ($result6->num_rows > 0) {
 while($r6=$result6->fetch_assoc())
 {
  $res6[] = $r6;
 }
 	echo "``%f%``".json_encode($res6);
}
    
}
else
{
    echo "0";
}
 
 
 
 
 ?>