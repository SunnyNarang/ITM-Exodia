<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);




$name=$_POST["name"];
$my=$_POST["class"];
$class_id=$_POST["id"];

if($my=='1'){

$stmt = $conn->prepare('select student.name,student.roll,login.image from student inner join login on student.roll = login.roll where student.class_id like ? group by student.id');
$stmt->bind_param('s', $class_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       
       $out[]=$row; 
        
    }
    echo json_encode($out);
    
}
else
	{echo "0";}


}
else{
$newname=$name.'%';
$stmt = $conn->prepare('select student.*,login.image from student inner join login on student.roll = login.roll where student.name like ? or student.roll like ? or student.email like ? group by student.id');
$stmt->bind_param('sss', $newname,$newname,$newname);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       
       $out[]=$row; 
        
    }
    echo json_encode($out);
    
}
else
	{echo "0";}
}
mysql_close($conn);
?>