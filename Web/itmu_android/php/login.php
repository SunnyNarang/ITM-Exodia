<?php
error_reporting(0);

include("conn.php");

$username=$_POST["username"];
$pass=$_POST["pass"];

//select login.id,login.roll,login.name,login.type,login.image,student.class_id from login inner join student on login.roll = student.roll where login.roll = 'q' and login.password ='q';


$stmt = $conn->prepare('Select type From login where roll = ? and password = ?');
$stmt->bind_param('ss', $username, $pass);

$stmt->execute();//ab login kam kr rha kya mtlb ab kuch aur tho nhi krna na?
//nhi
//thik hai aur ab gettimetable .php pr krna hai kam
$result = $stmt->get_result();
if ($result->num_rows > 0) 
{
 $r=$result->fetch_assoc();
   if($r["type"]==1)
   {
     
     $stmt10 = $conn->prepare('Select id From login where roll = ?');
$stmt10->bind_param('s', $username);

$stmt10->execute();//ab login kam kr rha kya mtlb ab kuch aur tho nhi krna na?
//nhi
//thik hai aur ab gettimetable .php pr krna hai kam
$result10 = $stmt10->get_result();



     $stmt11 = $conn->prepare('Select id From student where roll = ?');
$stmt11->bind_param('s', $username);

$stmt11->execute();//ab login kam kr rha kya mtlb ab kuch aur tho nhi krna na?
//nhi
//thik hai aur ab gettimetable .php pr krna hai kam
$result11 = $stmt11->get_result();

if ($result10->num_rows > 0&&$result11->num_rows == 0) {
 
 echo "yo";
}
else{

     
     
         
     $stmt = $conn->prepare('Select login.image,login.name,login.type,student.class_id ,student.batch From login 
join student
on login.roll = student.roll
where login.roll = ? and login.password = ?');
     $stmt->bind_param('ss', $username, $pass);
     
     $stmt->execute();
     $res = $stmt->get_result();
     
     
   }}
   else// if($r["type"]==1)
   {
     $stmt = $conn->prepare('Select * From login where roll = ? and password = ?');
     $stmt->bind_param('ss', $username, $pass);
     
     $stmt->execute();
     $res = $stmt->get_result();
     
   }
   echo json_encode($res->fetch_assoc());
	

   
 
}
else
	{echo "0";}

mysql_close($con);
?>