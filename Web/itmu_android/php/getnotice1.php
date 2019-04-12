<?php
error_reporting(0);
include("conn.php");
$section=$_POST["section"];


$stmt = $conn->prepare('SELECT nbatch_id as batch,ncourse_id as course,nbranch_id as branch FROM `define_section` WHERE nsec_id=?');
$stmt->bind_param('s', $section);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 $r=$result->fetch_assoc();
 

$stmt2 = $conn->prepare("SELECT message_title AS title, message AS body, TIMESTAMP AS n_date, byuser AS t_name
FROM itm_zone_notice
WHERE is_active =  'YES' and batch=? and branch=? and course =?
LIMIT 0 , 30");
$stmt2->bind_param('sss', $r['batch'], $r['branch'], $r['course']);

$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows > 0) {
 while($r2=$result2->fetch_assoc())
 {
  $res2[] = $r2;
 }
 
	echo json_encode($res2);
}
else
	{echo "0";}


}
else
	{echo "0";}

mysql_close($conn);


?>