<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "itm";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$roll=$_POST["roll"];
$desc=$_POST["body"];
$title=$_POST["title"];
$n_type=$_POST["type"];
//select login.id,login.roll,login.name,login.type,login.image,student.class_id from login inner join student on login.roll = student.roll where login.roll = 'q' and login.password ='q';
$nodate=date("Y/m/d");
$stmtq = $conn->prepare('INSERT INTO `notice`(`title`, `body`, `notice_date`, `t_id`, type)  values(?,?,?,?,?)');
			$stmtq->bind_param("sssss", $title, $desc, $nodate, $roll, $n_type);
			if($stmtq->execute()){
				echo '1';
				}
				else{
				echo '0';    
				}

mysql_close($con);

?>