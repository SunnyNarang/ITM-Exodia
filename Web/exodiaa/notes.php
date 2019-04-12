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
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Notes</h1>
                <div class="daytime">
				<a class="itsatte" onclick="gotonotes()">View Notes</a>
				<a class="itsatte" data-toggle="modal" data-target="#up_notes" >Upload Notes</a>
				<a class="itsatte" onclick="gotoyournotes()">Your Notes</a>
				</div>
				</div>
            </div>
						  <div class="modal fade" id="up_notes" role="dialog">
    <div class="modal-dialog" style="margin-top:60px">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
          <h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800">Upload Notes</h4><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;"><?php echo $n_date; ?></span>
        </div>
        <div class="modal-body" id="notes_up_sub_submit">
          <header class="codrops-header" style="padding:0 10px;margin-bottom:0px;text-align:justify">
		  <form id="notesupload" style="display:initial" action="" autocomplete="off">
		  <div class="row">
		  <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Course</span>
				<select name="notes_course" id="notes_course" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Course</option>
<?php
			$stmt = $conn->prepare('SELECT distinct course from class');
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $course=$row['course'];
?>
<option value="<?php echo $course; ?>"><?php echo $course; ?></option>
<?php }}?>
				</select>
				</p>
				</div>
				<div class="col-sm-6">
				<p id="notes_psub" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				</p></div>
				<div class="col-sm-6">
				<p id="notes_pbranch" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				</p>
				</div>
				<div class="col-sm-6">
				<p id="notes_psem" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				</p>
				</div>
				</div>
				<div class="row">
				  <div class="col-sm-12">
				  <p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				  </p>
				  </div>
				  </div>
				  <div class="row" id="notes_det">
				  </div>
			</header>
        </div>
		<div class="modal-footer" style="padding: 10px;color: #fff;background: #30302d;"><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;"></span>
        </div>
      </div>
      
    </div>
  </div>	
<script type="text/javascript">
$(document).ready(function() {
	$('select[name=notes_course]').change(function() {
		var combo = $(this).val();
		getnobranch(combo);
    });
			  $("#notesupload").submit(function(event){
        event.preventDefault();
    notes_up_sub();
  });
});
</script>