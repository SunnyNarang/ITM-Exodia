<?php
error_reporting(0);

include("conn.php");

$roll=$_POST["sender"];

$stmt1 = $conn->prepare('UPDATE login set activestatus="1" where roll=?');
$stmt1->bind_param('s', $roll);
$stmt1->execute();

$stmt = $conn->prepare("SELECT m.id,m.mess_date, m.person1, m.person2, m.message, CASE WHEN m.person1 = ? THEN m.person2 WHEN m.person2 = ? THEN m.person1 END AS person, CASE WHEN m.person1 = ? THEN m.status_app WHEN m.person2 = ? THEN m.status_app END AS msgstatus FROM message m LEFT JOIN message m2 ON ((m.person1=m2.person1 AND m.person2=m2.person2) OR (m.person1=m2.person2 AND m.person2=m2.person1)) AND m.mess_date<m2.mess_date WHERE (m.person1=? OR m.person2=?) AND m2.person2 IS NULL ORDER BY m.mess_date DESC");
$stmt->bind_param('ssssss', $roll, $roll, $roll, $roll, $roll, $roll);
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