<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');
   
?>
<div class="profileCard1" style="margin-bottom:50px">
                <div class="pImg">
                    <span class="fa fa-bar-chart" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Manage Students</h1>
                <div class="daytime">
				<a class="itsatte" data-toggle="modal" data-target="#admit_stu">Admit Students</a>
				<a class="itsatte" onclick="reg_stu()">Register Students</a>
				<a class="itsatte" onclick="reg_stu()">Export Excel Sheet</a>
				<a class="itsatte" onclick="reg_stu()">Upload Picture</a>
				</div>
				</div>
            </div>
						  <div class="modal fade" id="admit_stu" role="dialog">
    <div class="modal-dialog" style="margin-top:20px">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
          <h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800">Admit Students</h4>
		  <button type="button" class="btn btn-default" onclick="closedownmodal()" data-dismiss="modal" aria-label="Close" style="display: inline-block;font-family: Titillium Web;letter-spacing: 0;padding: 2px 10px;vertical-align: middle;margin-top: 0px;float: right;">Close</button>
        </div>
        <div class="modal-body" id="notes_up_sub_submit">
          <header class="codrops-header" style="padding:0 10px;margin-bottom:0px;text-align:justify">
		  <form id="admitstudents" style="display:initial" action="" autocomplete="off">
		  <div class="row">
		  <div class="col-sm-6">
		  		<p style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Course</span>
				<select name="admit_course" id="admit_course" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
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
				<p id="admin_psub" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				</p></div>
				</div>
				<p id="admit_pbranch" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				</p>
			</header>
        </div>
		<div class="modal-footer" style="padding: 10px;color: #fff;background: #30302d;"><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;"></span>
        </div>
      </div>
      
    </div>
  </div>	
<script type="text/javascript">
$(document).ready(function() {
	$('select[name=admit_course]').change(function() {
		var combo = $(this).val();
		admitnobranch(combo);
    });
			  $("#admitstudents").submit(function(event){
        event.preventDefault();
    admit_students_n();
  });
});
</script>