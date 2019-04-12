<?php

//error_reporting(0);
 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$course=$_POST["course"];
$subject=$_POST["subject"];
$sem =$_POST["sem"];
$branch =$_POST["branch"];
$your =$_POST["your"];
$roll =$_POST["roll"];


if($your=='0'){

$stmt1 = $conn->prepare("select distinct subject.class_id from class inner join subject on class.id = subject.class_id where class.branch = ? and class.course = ? and class.sem= ? and subject.name = ?");
$stmt1->bind_param('ssss', $branch,$course,$sem,$subject);
$stmt1->execute();
$result1 = $stmt1->get_result();
if ($result1->num_rows > 0) {
 $r1=$result1->fetch_assoc();
 $class_id = $r1['class_id'];
 
 $stmt3 = $conn->prepare("select id from subject where class_id =? and name =?");
$stmt3->bind_param('ss', $class_id,$subject);
$stmt3->execute();
$result3 = $stmt3->get_result();
if ($result3->num_rows > 0) {
 $r3=$result3->fetch_assoc();
 $sub_id = $r3['id'];
}
$stmt = $conn->prepare('SELECT notes.description as description, notes.title as title, notes.file as file, teacher.name as name, teacher.roll as roll FROM notes inner join teacher on notes.teacher_id=teacher.roll where notes.sub_id = ?');
$stmt->bind_param('s', $sub_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 
	echo json_encode($res);
}
else
	{echo "0";}
}
else
{
    echo '0';
}
//mysql_close($con);
}


else
{
 
 $stmt = $conn->prepare('select notes.title, notes.description,notes.file,teacher.name from notes inner join teacher on teacher.roll = notes.teacher_id where teacher.roll = ?');
$stmt->bind_param('s', $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
 while($r=$result->fetch_assoc())
 {
  $res[] = $r;
 }
 
	echo json_encode($res);
}

else{
 echo '0';
}
 
 
 
}
//mysql_close($conn);


?>