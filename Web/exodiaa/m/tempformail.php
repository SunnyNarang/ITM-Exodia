<?php
ini_set ('allow_url_fopen', '1');
ini_set ('allow_url_include', '1');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("X-XSS-Protection: 0");
echo $_GET["roll"];
echo $_GET["id"];
echo $_GET["email"];

$subject = 'Reset Password - ITM Exodia';
$toEmail = '$_GET["email"]';
$message = 'Reset Password - ITM Exodia';          
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ITM Exodia" . "\r\n";


$to=$toEmail;
$subject=$subject;
$from="Exodia@zarainforise.com"; 
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: <".$from.">\n";
$headers .= "X-Priority: 1\n";
$message='<a href="http://localhost/exodia/reset.php?q=$_GET['id']" >Reset Password</a>';
$message .= "<br/>Regards $_GET['id']<br />saurav";


if (mail($to, $subject, $message, $headers )) {
  $data['msg']="Message send successfully";
} 
else {
  $data['msg']="Please try again, Message could not be sent!";
}  
?>