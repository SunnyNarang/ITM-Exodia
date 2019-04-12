<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');
   
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-bar-chart" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Attendance</h1>
                <div class="daytime">
				<a class="itsatte" onclick="gotoatt()">Mark Attendance</a>
				<a class="itsatte" onclick="gotoattlog(1)">Attendance Log</a>
				</div>
				</div>
            </div>
