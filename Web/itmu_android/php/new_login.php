<?php
error_reporting(0);

include("conn.php");

$username=$_POST["username"];
$pass=$_POST["key"];

//select login.id,login.roll,login.name,login.type,login.image,student.class_id from login inner join student on login.roll = student.roll where login.roll = 'q' and login.password ='q';


$stmt = $conn->prepare("SELECT vrollno
FROM `itm_mapp_details`
WHERE (
vrollno = ?
OR vemail = ?
)
AND vappkey = ?");
$stmt->bind_param('sss', $username, $username, $pass);
$stmt->execute();//ab login kam kr rha kya mtlb ab kuch aur tho nhi krna na?
//nhi
//thik hai aur ab gettimetable .php pr krna hai kam
$result = $stmt->get_result();
$r = $result->fetch_assoc();
$roll = $r['vrollno'];
if ($result->num_rows > 0) 
{
 
    $stmt2 = $conn->prepare("SELECT vstu_rollno as username,section,vstu_name as name FROM `section_wise_student` WHERE vstu_rollno=?");
    $stmt2->bind_param('s', $roll);
    $stmt2->execute();//ab login kam kr rha kya mtlb ab kuch aur tho nhi krna na?
    //nhi
    //thik hai aur ab gettimetable .php pr krna hai kam
    $result2 = $stmt2->get_result();
    echo json_encode($result2->fetch_assoc());
    
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

$conn.close();
 
 
 
 
 ?>