<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
if(!$_GET['parent']){header('Location: index.php');}
$parent=$_GET['parent'];
include('db.php');
$stmt = $conn->prepare('SELECT notice.id as id, notice.title as title, notice.body as body, notice.notice_date as n_date, teacher.roll as tea_roll, teacher.name as t_name FROM notice inner join teacher on teacher.roll=notice.t_id where notice.notice_date = ? Order by notice.notice_date');
$stmt->bind_param('s', $parent);
$stmt->execute();
$result = $stmt->get_result();
?>
			<div id="loadnotice">
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $id=$row['id'];
	   $title=$row['title'];
	   $body=$row['body'];
	   $n_date=$row['n_date'];
	   $t_roll=$row['tea_roll'];
	   $t_name=$row['t_name'];
?>			
			<div data-toggle="modal" data-target="#n_<?php echo $id; ?>" class="family">
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;"><?php echo $title; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $n_date; ?></span>
			</div>
			<div style="display:inline-block;float:right">
			<a class="btn btn-info btn-md">View</a>
			</div>
			</div>
			
			  <div class="modal fade" id="n_<?php echo $id; ?>" role="dialog">
    <div id="draggable" class="modal-dialog" style="margin-top:120px">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
          <h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800"><?php echo $title; ?></h4><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;"><?php echo $n_date; ?></span>
        </div>
        <div class="modal-body">
          <header class="codrops-header" style="padding:10px;margin-bottom:0px;text-align:justify">
		  		<p style="color:#666;font-family: 'Open Sans', sans-serif;font-weight: 400;font-style: italic;font-size: 17px;margin-top: 0px;margin-bottom: 0px;"><?php echo $body; ?></p>
			</header>
        </div>
		<div class="modal-footer" style="padding: 10px;color: #fff;background: #30302d;"><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;">- <?php echo $t_name; ?></span>
        </div>
      </div>
      
    </div>
  </div>	
<?php }?></div>
<?php }else{?>
<div class="family">
			<div style="display:inline-block">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 23px;color:#8e8e8e;font-weight: 800;">No notice found !</span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686">Please search some other dates.</span>
			</div>
			</div>
<?php }?>