<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
if(!$_POST['admit_branch'] or !$_POST['admit_course']){die ("Please select course and branch");}
$admit_course=$_POST['admit_course'];
$admit_course=htmlspecialchars($admit_course, ENT_QUOTES, 'UTF-8');
$admit_branch=$_POST['admit_branch'];
$admit_branch=htmlspecialchars($admit_branch, ENT_QUOTES, 'UTF-8');
$admit_sem=$_POST['admit_sem'];
$admit_sem=htmlspecialchars($admit_sem, ENT_QUOTES, 'UTF-8');
$admit_roll=$_POST['admit_roll'];
$admit_roll=htmlspecialchars($admit_roll, ENT_QUOTES, 'UTF-8');
$admit_name=$_POST['admit_name'];
$admit_name=htmlspecialchars($admit_name, ENT_QUOTES, 'UTF-8');
$admit_email=$_POST['admit_email'];
$admit_email=htmlspecialchars($admit_email, ENT_QUOTES, 'UTF-8');
$admit_dob=$_POST['admit_dob'];
$admit_dob=htmlspecialchars($admit_dob, ENT_QUOTES, 'UTF-8');
$admit_f_name=$_POST['admit_f_name'];
$admit_f_name=htmlspecialchars($admit_f_name, ENT_QUOTES, 'UTF-8');
$admit_f_mob=$_POST['admit_f_mob'];
$admit_f_mob=htmlspecialchars($admit_f_mob, ENT_QUOTES, 'UTF-8');
$admit_address1=$_POST['admit_address1'];
$admit_address1=htmlspecialchars($admit_address1, ENT_QUOTES, 'UTF-8');
$admit_address2=$_POST['admit_address2'];
$admit_address2=htmlspecialchars($admit_address2, ENT_QUOTES, 'UTF-8');
$admit_city=$_POST['admit_city'];
$admit_city=htmlspecialchars($admit_city, ENT_QUOTES, 'UTF-8');
$admit_phone=$_POST['admit_phone'];
$admit_phone=htmlspecialchars($admit_phone, ENT_QUOTES, 'UTF-8');
$baby_type="1";

/* function ak_img_resize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } else {
           $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
      $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
      $img = imagecreatefrompng($target);
    } else { 
      $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
} */

function ak_img_resize($target, $newcopy, $w, $h, $ext){
    list($w_orig, $h_orig) = getimagesize($target);

    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){
      $img = imagecreatefromgif($target);
    } else if($ext =="png"){
      $img = imagecreatefrompng($target);
    } else {
      $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    imagecopyresized($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy);
  }

$stmt = $conn->prepare('SELECT roll from temp_students where roll=? or email=?');
$stmt->bind_param("ss", $admit_roll, $admit_email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	die("Roll or Email Already Exists !");
} else{
	$stmtq = $conn->prepare('SELECT roll from student where roll=? or email=?');
	$stmtq->bind_param("ss", $admit_roll, $admit_email);
	$stmtq->execute();
	$resultq = $stmtq->get_result();
	if ($resultq->num_rows > 0) {
		die ("Roll or Email Already Registered !");
	} else {
		$stmtqzz = $conn->prepare('SELECT roll from student where roll=? or email=?');
	$stmtqzz->bind_param("ss", $admit_roll, $admit_email);
	$stmtqzz->execute();
	$resultqzz = $stmtqzz->get_result();
	if ($resultqzz->num_rows > 0) {
		die ("Roll or Email Already Exists !");
	}
	}
}
if(isset($_FILES["admit_image"]["type"]))
{
	if ($_FILES["admit_image"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["admit_image"]["error"] . "<br/><br/>";
	}
	else
		{
			$check = getimagesize($_FILES["admit_image"]["tmp_name"]);
		if($check !== false) {
			$sourcePath = $_FILES['admit_image']['name'];
			$ext = pathinfo($sourcePath, PATHINFO_EXTENSION);
			$ext = strtolower($ext);
			
			if($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif" ) {
				die ('File is not an image');
			}
			
			$sourcePath = $_FILES['admit_image']['tmp_name']; // Storing source path of the file in a variable
			$targetPath = "img/".$admit_roll.".".$ext; // Target path where file is to be stored
			move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
			$final_name=$admit_roll.".".$ext;
			
			$target_file = "img/".$admit_roll.".".$ext;
$resized_file = "img/".$admit_roll.".".$ext;
$wmax = 200;
$hmax = 200;
//ak_img_resize($target_file, $resized_file, $wmax, $hmax, $ext);
ak_img_resize($target_file, $resized_file, $wmax, $hmax, $ext);
			
			$stmtq = $conn->prepare('INSERT INTO `temp_students`(`name`, `roll`, `email`, `dob`, `f_name`, `f_mob`, `address1`, `address2`, `city`, `phone`, `branch`, `course`, `sem`)  values(?,?,?,?,?,?,?,?,?,?,?,?,?)');
			$stmtq->bind_param("sssssssssssss", $admit_name, $admit_roll, $admit_email, $admit_dob, $admit_f_name, $admit_f_mob, $admit_address1, $admit_address2, $admit_city, $admit_phone, $admit_branch, $admit_course, $admit_sem);
			if($stmtq->execute()){
				echo "<br>Image Uploaded.";
				$stmtq = $conn->prepare('INSERT INTO `login`(`roll`, `name`, `email`, `password`, `type`, `image`)  values(?,?,?,?,?,?)');
				$stmtq->bind_param("ssssss", $admit_roll, $admit_name, $admit_email, $admit_dob, $baby_type, $final_name);
				if($stmtq->execute()){
					echo "<br>Student has been admitted.";
				}
			}
			
		}
		else {die ('File is not an image');}
	} 
} else {die ("There was some error ! Please Upload your file.");}
?>