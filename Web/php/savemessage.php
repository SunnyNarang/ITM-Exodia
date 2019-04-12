<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$p1=$_POST["p1"];
$p2=$_POST["p2"];
$message=$_POST["message"];

$message=htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
$healthy = array("fuck", "motherfucker", "bitch", "bastard");
$yummy   = array("f***", "motherf*****", "bit**", "bast***");
$message = str_replace($healthy, $yummy, $message);
$status='1';
//select login.id,login.roll,login.name,login.type,login.image,student.class_id from login inner join student on login.roll = student.roll where login.roll = 'q' and login.password ='q';


//$stmt = $conn->prepare('UPDATE message set statusp2="1" where person2=? and person1=?');
//$stmt->bind_param('ss', $p2,$p1);
//$stmt->execute();


$stmt = $conn->prepare('insert into message (person1,person2,message,mess_date,statusp1) values (?,?,?,now(),?)');
$stmt->bind_param('ssss', $p1, $p2,$message,$status);
echo '1';

$stmt->execute();
mysql_close($con);
?>