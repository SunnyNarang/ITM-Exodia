<?php
if(!$_POST['searchtext']){header('Location: index.php');}
$searchtext=$_POST['searchtext'];
$searchtext=htmlspecialchars($searchtext, ENT_QUOTES, 'UTF-8');
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('../db.php');
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-search" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Search results for : <?php echo $searchtext; ?></h1>
                </div>
            </div>
<?php
$searchtext= "%".$searchtext."%";
$stmt = $conn->prepare('SELECT * FROM `login` WHERE roll like ? or name like ? or email like ? order by roll');
$stmt->bind_param('sss', $searchtext, $searchtext, $searchtext);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
	   $name=$row['name'];
	   $roll=$row['roll'];
	   $image=$row['image'];
?>			
			<div onclick="gotoprofile('<?php echo $roll; ?>');" class="family" style="width:100%;margin:0px">
			<div style="display:inline-block;vertical-align:middle">
			<img src="img/<?php echo $image; ?>" style="width:40px">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $name; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $roll; ?></span>
			</div>
			</div>
<?php } }else {?>
			<div class="family">
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No match found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please start other keyword.</span>
			</div>
			</div>			
<?php } ?>		
