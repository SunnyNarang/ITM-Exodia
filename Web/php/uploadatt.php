<?php

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$class_id=$_POST["class_id"];
$subject_id=$_POST["subject_id"];
$teacher_roll=$_POST["teacher_roll"];
$date=$_POST["date"];
$time=$_POST["time"];
$last_edited=$_POST["last_edited"];
$fadu_data=$_POST["stu_att"];
$upload=$_POST["upload"];


if($upload=='0'){
$stmt1 = $conn->prepare("select count(*) as count from attendance where sub_id = ? and class_id = ?  and time =? and att_date =?");
$stmt1->bind_param('ssss',$subject_id,$class_id,$time,$date);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row = $result1->fetch_assoc(); 
$no_of_rows = $row['count'];

if ($no_of_rows == 0) {


$yoyo =  explode("+",$fadu_data);
$size = sizeof($yoyo);

for($i = 0 ; $i<$size;$i=$i+2){
    $roll = $yoyo[$i];
    $status = $yoyo[$i+1];
$stmt = $conn->prepare("INSERT INTO `itm`.`attendance` (`id`, `roll`, `att_date`, `sub_id`, `class_id`,`time`, `status`, `teacher_roll`, `last_edited`) VALUES (NULL, ? , ?, ?, ?, ?, ?, ?,?)");
$stmt->bind_param('ssssssss', $roll,$date,$subject_id,$class_id,$time,$status,$teacher_roll,$date);
$stmt->execute();
  
}
echo '1';
}
else
	{
	    
echo '0';
	    
	}
}

else
{
    
$yoyo =  explode("+",$fadu_data);
$size = sizeof($yoyo);

for($i = 0 ; $i<$size;$i=$i+2){
    $roll = $yoyo[$i];
    $status = $yoyo[$i+1];
$stmt1 = $conn->prepare("UPDATE  `itm`.`attendance` SET `teacher_roll` = ?, `status` =  ? , `last_edited` = ? WHERE  `time` = ? and `roll` = ? and att_date = ? and sub_id = ? and class_id = ?");
$stmt1->bind_param('ssssssss',$teacher_roll, $status,$last_edited,$time,$roll,$date,$subject_id,$class_id);
$stmt1->execute();
    
    
}
echo '10';
}
//mysql_close($con);
?>