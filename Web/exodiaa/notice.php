<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');
$stmt = $conn->prepare('SELECT notice.id as id, notice.title as title, notice.body as body, notice.notice_date as n_date, teacher.id as tea_id, teacher.name as t_name FROM notice inner join teacher on teacher.id=notice.t_id Order by notice.notice_date DESC LIMIT 10');
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-clipboard" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Notice Board</h1>
					<link rel="stylesheet" type="text/css"  href="css/bootstrap-datetimepicker.css">

					<div class='input-group date date-input' id='datetimepicker1'  data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
								<input type='text' name="date" id="date" class="form-control" placeholder="Search by Date" style="font-family: 'Titillium Web';font-weight: 600;" />
								<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
								</span>
					</div>
                </div>
            </div>
			<div id="loadnotice">
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $id=$row['id'];
	   $title=$row['title'];
	   $body=$row['body'];
	   $n_date=$row['n_date'];
	   $t_id=$row['tea_id'];
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
<?php }}?></div>
  <div class="family-bottom">		<a class="btn btn-info btn-md" onclick="restartnotice();">See all<i class="fa fa-arrow-circle-o-right" style="font-size: 20px;vertical-align: middle;margin-left: 10px;"></i></a> </div>
  <script>
	
				</script>
    <script type="text/javascript" src="js/jquery.isotope.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
				
				<script type="text/javascript">

	$('.date-input').datetimepicker({
        language:  'en',
		format: 'yyyy-mm-dd',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
$(function () {
                $('#datetimepicker1').datetimepicker();
            });
	
        </script>
<script type="text/javascript">
$(document).ready(function() {
    
	$("#datetimepicker1").change(function() {
		$('#loadnotice').html('<img src=img/loader.gif style="margin-top: 25%;">');
		$.get('searchnotice.php?parent=' + $('#date').val(), function(data) {
			$("#loadnotice").html(data);
		});	
    });

});
</script>