<?php

include("conn.php");

$old=$_POST["old"];
$new=$_POST["new"];
$roll=$_POST["roll"];

$stmt = $conn->prepare('select * from itm_mapp_details where vrollno = ? and vappkey = ?');
$stmt->bind_param('ss', $roll,$old);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {

$stmt1 = $conn->prepare('update itm_mapp_details set vappkey = ? where vrollno = ? and vappkey = ?');
$stmt1->bind_param('sss', $new,$roll,$old);
$stmt1->execute();
echo '1';
}
else
	{
$stmt3 = $conn->prepare('select * from itm_mapp_details where vrollno = ?');
$stmt3->bind_param('s', $roll);
$stmt3->execute();
$result3 = $stmt3->get_result();
if ($result3->num_rows > 0) {
echo '2';
}
else
	{echo "0";}
}

mysql_close($con);

?>