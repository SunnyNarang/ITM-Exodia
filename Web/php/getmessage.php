<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);

$roll =$_POST["p1"];
$person2roll= $_POST["p2"];




$stmt3 = $conn->prepare('SELECT * FROM message  where (person2=? and status_app=0 and person1=?)');
$stmt3->bind_param('ss', $roll,$person2roll);

$stmt3->execute();

$result3 = $stmt3->get_result();

if($result3->num_rows>0){
 
 $stmt1 = $conn->prepare('UPDATE message set status_app="1" where person2=? and person1=?');
$stmt1->bind_param('ss', $roll, $person2roll);
$stmt1->execute();
 
 while($r=$result3->fetch_assoc())
 {
  $res[] = $r;
 }
 
	echo json_encode($res)."``%f%``".$prev->num_rows;//hahahaha....i'm watching u :p
	





}
else
{
 echo '0';
}






mysql_close($con);


?>