<?php 
if ( ! defined('IN_SITE') )
header('Location: ../index.php');
?>
<ul class="change-fa">
	<li><a class="fa fa-bookmark" href="index.php">Dashboard</a></li>
	<li><a href="#" data-target="statistics" class="fa fa-user thelink">Statistics</a></li>
		<li><a href="#" data-target="att" class="fa fa-bar-chart thelink">Attendance</a></li>
	<li><a href="#" data-target="notes" class="fa fa-book thelink">Notes</a></li>
	<li><a href="#" data-target="admin_class" class="fa fa-book thelink">Manage Classes</a></li>
	<li><a href="#" data-target="admin_tea" class="fa fa-file-text thelink">Manage Teachers</a></li>
	<li><a href="#" data-target="admin_stu" class="fa fa-book thelink">Manage Students</a></li>
	<li><a href="#" data-target="admin_subject" class="fa fa-book thelink">Manage Subjects</a></li>
	<li><a href="#" data-target="admin_routine" class="fa fa-book thelink">Manage Routines</a></li>
	<li><a href="#" data-target="account" class="fa fa-gear thelink">Account</a></li>
	<li><a class="fa fa-hand-lizard-o" href="logout.php">Logout</a></li>
</ul>