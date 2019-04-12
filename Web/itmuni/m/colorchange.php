<?php
ob_start();
define('IN_SITE', true, true);
session_start();
if(!$_SESSION['ITM Exodia'] or !$_SESSION['roll']){session_destroy(); session_unset(); header('Location: ../login.php');};
$school=$_SESSION['ITM Exodia'];
$roll=$_SESSION['roll'];
include('../db.php');
if(!$_POST['color']){ header('Location: index.php');}
$color=$_POST['color'];
$color=htmlspecialchars($color, ENT_QUOTES, 'UTF-8');
$stmt = $conn->prepare('update login set color = ? where roll = ?');
$stmt->bind_param('ss', $color, $roll);
$stmt->execute();
?>