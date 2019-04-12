<?php
ob_start();
define('IN_SITE', true, true);
session_start();
if(!$_SESSION['ITM Exodia'] or !$_SESSION['roll']){session_destroy(); session_unset(); echo '<script>window.parent.location = "index.php"</script>';}else{
$school=$_SESSION['ITM Exodia'];
$roll=$_SESSION['roll'];
include('db.php');
$stmt = $conn->prepare('Update login set active=now() where roll = ?');
$stmt->bind_param('s', $roll);
$stmt->execute();}
?>