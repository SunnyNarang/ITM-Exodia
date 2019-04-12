<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$u=$_POST["username"];

//select login.id,login.roll,login.name,login.type,login.image,student.class_id from login inner join student on login.roll = student.roll where login.roll = 'q' and login.password ='q';


 $stmt = $conn->prepare('select image from login where roll=?');
$stmt->bind_param('s', $u);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 $r=$result->fetch_assoc();
	echo $r['image'];
 
 
}

else{
 echo '0';
}

mysql_close($con);
?>