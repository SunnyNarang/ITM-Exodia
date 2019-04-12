<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
include('db.php');
if(!$roll or !$type){header('Location: index.php');}
$notes_course=$_POST['notes_course'];
$notes_course=htmlspecialchars($notes_course, ENT_QUOTES, 'UTF-8');
$notes_branch=$_POST['notes_branch'];
$notes_branch=htmlspecialchars($notes_branch, ENT_QUOTES, 'UTF-8');
$notes_sem=$_POST['notes_sem'];
$notes_sem=htmlspecialchars($notes_sem, ENT_QUOTES, 'UTF-8');
$notes_classs=$_POST['notes_classs'];
$notes_classs=htmlspecialchars($notes_classs, ENT_QUOTES, 'UTF-8');
$notes_subb=$_POST['notes_subb'];
$notes_subb=htmlspecialchars($notes_subb, ENT_QUOTES, 'UTF-8');
$notes_title=$_POST['notes_title'];
$notes_title=htmlspecialchars($notes_title, ENT_QUOTES, 'UTF-8');
$notes_desc=$_POST['notes_desc'];
$notes_desc=htmlspecialchars($notes_desc, ENT_QUOTES, 'UTF-8');
$sequal=$roll.date("Ymdhis");
$curr=date("Y-m-d");
if(isset($_FILES["file"]["type"]))
{
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
}
else
{
if (file_exists("files/" . $_FILES["file"]["name"])) {
echo $_FILES["file"]["name"] . " <span id='invalid'><b>File already exists.</b></span> ";
}
else
{
$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "files/".$sequal.$_FILES['file']['name']; // Target path where file is to be stored
move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
$final_name=$sequal.$_FILES['file']['name'];
}
$stmt = $conn->prepare('insert into notes(date,sub_id,title,file,description,teacher_id) values(?,?,?,?,?,?)');
$stmt->bind_param("ssssss", $curr, $notes_subb, $notes_title, $final_name, $notes_desc, $roll);
if($stmt->execute()){echo '<div class="trigger"></div>
<svg version="1.1" id="tick" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 37 37" style="enable-background:new 0 0 37 37;width:120px" xml:space="preserve">
<path class="circ path" style="fill:none;stroke:#34a853;stroke-width:3;stroke-linejoin:round;stroke-miterlimit:10;" d="
	M30.5,6.5L30.5,6.5c6.6,6.6,6.6,17.4,0,24l0,0c-6.6,6.6-17.4,6.6-24,0l0,0c-6.6-6.6-6.6-17.4,0-24l0,0C13.1-0.2,23.9-0.2,30.5,6.5z"
	/>
<polyline class="tick path" style="fill:none;stroke:#34a853;stroke-width:3;stroke-linejoin:round;stroke-miterlimit:10;" points="
	11.6,20 15.9,24.2 26.4,13.8 "/>
</svg>
<span style="font-weight:800;color:#424240;font-family: Oswald, sans-serif;display:block;font-size: 20px;margin-top: 10px;margin-bottom: 10px;">Note Uploaded Successfully !</span>
<span style="margin-top:10px;font-family: Titillium Web, sans-serif;background: #424240;color: #fff;padding: 5px 30px;box-shadow: 1px 1px 5px #8c8c8c;border-radius: 3px;cursor:pointer" onclick="closeupmodal()" data-dismiss="modal" aria-label="Close">Close</span>';} else {echo "There was some error.";};
}
} else {echo "There was some error.";}
?>
