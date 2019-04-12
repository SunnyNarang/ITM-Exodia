<?php

include("conn.php");

$section=$_POST["section"];
$subject=$_POST["subject"];
$teacher1=$_POST["teacher1"];
$period=$_POST["period"];
$periodto=$_POST["periodTo"];
$tid=$_POST["tid"];
$teacher2=$_POST["teacher2"];
$date=$_POST["date"];
$time=$_POST["time"];
$ccid=$_POST["ccid"];
$attendance=$_POST["attendance"];
$upload = $_POST["upload"];
    
    
if($upload=='0'){
$stmt1 = $conn->prepare("select count(*) as count from `attendance_conf_faculty` where `conf_subcode`=?  and 
`conf_tid` = ? and period = ? and periodTo = ? and att_date=? and timeToFr=? and sectionid=?");
$stmt1->bind_param('sssssss',$subject,$tid,$period,$periodto,$date,$time,$section);

$stmt1->execute();
$result1 = $stmt1->get_result();
$row = $result1->fetch_assoc(); 
$no_of_rows = $row['count'];

if ($no_of_rows == 0) {


$stmt1 = $conn->prepare("INSERT INTO  `attendance_conf_faculty` ( `conf_subcode`, `conf_fname`, conf_fname2, 
`conf_taken_dates`, `conf_tid`,period,periodTo,att_date, timeToFr, sectionid,user,stu_reg_id)
	 VALUES ( ?, ?, ?, '".date("Y-m-d")."', ?,?,
	 ?,?,?,?, ?,?)
");
$stmt1->bind_param('sssssssssss',$subject,$teacher1,$teacher2,$tid,$period,$periodto,$date,$time,$section,$ccid,$attendance);
$stmt1->execute();
echo '1';
}
else
	{
	    
echo '0';
	    
	}
}

else
{
    
$stmt1 = $conn->prepare("update `attendance_conf_faculty` set `conf_fname`=? and stu_reg_id=? and user=? where `conf_subcode`=?  and 
`conf_taken_dates` = '".date("Y-m-d")."' and `conf_tid` = ? and period = ? and periodTo = ? and att_date=? and timeToFr=? and sectionid=?");
$stmt1->bind_param('sssssss',$teacher1,$attendance,$ccid,$subject,$tid,$period,$periodto,$date,$time,$section);
$stmt1->execute();
    
    
echo '10';
}





//mysql_close($con);
?>