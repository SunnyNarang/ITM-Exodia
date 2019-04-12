<?php
error_reporting(0);/*

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "saurav";
    $database = "exo";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);
    
    $admit_dob = '1600-07-07';
    $admit_f_name = 'sjdflka dhflakf ';
    
     $admit_f_mob = '9893601266';
     $admit_address1 = 'gali yo guoudjm';
     $admit_address2 = 'jklgkl kfdg slk';
     $admit_city = 'gwalior';
     $admit_phone = '9589481074';
     $admit_branch = 'IT';
     $admit_course = 'BE';
     $admit_sem = '2';
     $baby_type = '1';
     
			
    for($i=1;$i<=60;$i++){
        
            $admit_name = 'IT'.$i.'';
            $admit_roll = 'ITSTD'.$i;
            $admit_email = $i.'@IT.com';
            $final_name = 'ITSTD'.$i.'.jpg';
            echo '--hello--';
        
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
mysql_close($con);
echo 'done';*/
?>