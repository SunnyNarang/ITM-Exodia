<?php 
if ( ! defined('IN_SITE') )
header('Location: ../index.php');
?>
<ul class="change-fa">
	<li><a class="fa fa-bookmark" href="index.php">Dashboard</a></li>
	<li><a href="#" data-target="profile" class="fa fa-user thelink">Profile</a></li>
	<li><a href="#" data-target="attendance" class="fa fa-bar-chart thelink">Attendance</a></li>
	<li><a href="#" data-target="subjects" class="fa fa-book thelink">Notes</a></li>
	<li><a href="#" data-target="routine" class="fa fa-dashcube thelink">Class Routine</a></li>
	<li><a href="#" data-target="result" class="fa fa-file-text thelink">Exam</a></li>
	<li><a class="fa fa-sitemap" href="reports.php">Forum</a></li>
	<li><a href="#" data-target="account" class="fa fa-gear thelink">Account</a></li>
	<li><a href="#" data-target="developers" class="fa fa-gear thelink">Developers</a></li>
	<li><a class="fa fa-hand-lizard-o" href="logout.php">Logout</a></li>
</ul>