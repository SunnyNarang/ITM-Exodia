<?php
$stmt = $conn->prepare('SELECT notice.id as id, notice.title as title, notice.body as body, notice.notice_date as n_date, teacher.roll as tea_roll, teacher.name as t_name FROM notice inner join teacher on teacher.roll=notice.t_id where notice.type="1" or notice.type="3" Order by notice.notice_date DESC LIMIT 5');
if($_SESSION['type']=="2" or $_SESSION['type']=="3"){
$stmt = $conn->prepare('SELECT notice.id as id, notice.title as title, notice.body as body, notice.notice_date as n_date, teacher.roll as tea_roll, teacher.name as t_name FROM notice inner join teacher on teacher.roll=notice.t_id where notice.type="2" or notice.type="3" Order by notice.notice_date DESC LIMIT 5');	
}
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-clipboard" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Notice Board</h1>
					<?php if($_SESSION['type']=="2" or $_SESSION['type']=="3") echo "<span data-toggle='modal' data-target='#read_new_notice' style='cursor:pointer;display: inline-block;font-size: 14px;background: #212121;color: #fff;font-family: Titillium Web;padding: 6px 15px;box-shadow: 2px 2px 5px #000;margin-bottom: 15px;border-radius: 1px;margin-top: -10px;'>Add a Notice</span>"; ?>
					<link rel="stylesheet" type="text/css"  href="css/bootstrap-datetimepicker.css">

					<div class='input-group date date-input' id='datetimepicker'  data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
								<input type='text' name="date" id="date" class="form-control" placeholder="Search by Date"  style="font-family: 'Titillium Web';font-weight: 600;" />
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
			<?php if($_SESSION['type']=="3") { ?>
			<a class="btn btn-info btn-md" onclick="delnotice('<?php echo $id; ?>')">Delete</a>
	<?php } ?>
			</div>
			</div>
			
			  <div class="modal fade" id="n_<?php echo $id; ?>" role="dialog">
    <div class="modal-dialog" style="margin-top:120px">
    
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
  <?php if($_SESSION['type']=="2" or $_SESSION['type']=="3"){ ?>
			  <div class="modal fade" id="read_new_notice" role="dialog">
    <div class="modal-dialog" style="margin-top:80px">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding: 10px;color: #fff;background: #30302d;">
          <h4 class="modal-title" style="float: left;font-family: Titillium Web;font-size: 20px;font-weight:800">Add New Notice</h4><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;"><?php echo  date("Y/m/d"); ?></span>
        </div>
        <div class="modal-body">
          <header class="codrops-header" style="padding:10px;margin-bottom:0px;text-align:justify">
		  		<p style="color:#666;font-family: 'Open Sans', sans-serif;font-weight: 400;font-style: italic;font-size: 17px;margin-top: 0px;margin-bottom: 0px;">
				<form id="lol_notice" style="text-align:left;margin-bottom: 10px;margin-top: 8px;" action="" autocomplete="off">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;font-family:titillium web">Send notice to</span>
				<select required name="notice_type" id="" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 6px;margin-top: 2px;color: #555;border:1px solid #c0c0c0;border-radius: 2px;margin-bottom:10px">
				<option value="1">Students only</option>
				<option value="2">Teachers only</option>
				<option value="3">Both Students and Teachers</option>
				
				</select>
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;font-family:titillium web">Title</span>
				<input required name="notice_title" id="" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 6px;margin-top: 2px;color: #555;border:1px solid #c0c0c0;border-radius: 2px;margin-bottom:10px">
				<span style="padding:0;font-size:15px;font-weight:800;text-align: left;font-family:titillium web">Description</span>
				<textarea required name="notice_description" id="" style="height:100px;width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;"></textarea>
				<input type="submit" id="csv_btn" style="margin-top: 5px;margin-bottom:10px;color: #fff;background: #3c3c3b;border: none;font-size: 14px;font-family: titillium Web;padding: 5px 20px;box-shadow: 2px 2px 5px #696969;">
				</form>
				</p>
			</header>
        </div>
		<div class="modal-footer" style="padding: 10px;color: #fff;background: #30302d;"><span style="margin-top:4px;float: right;font-family: Oswald;font-size: 17px;">- <?php echo $roll; ?></span>
        </div>
      </div>
      
    </div>
  </div>
  <?php } ?>
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
    
	$("#datetimepicker").change(function() {
			console.log('2+3');
		$('#loadnotice').html('<img src=img/loader.gif style="margin-top: 25%;">');
		$.get('searchnotice.php?parent=' + $('#date').val(), function(data) {
			$("#loadnotice").html(data);
		});	
    });
	
	$("#lol_notice").submit(function(event){
        event.preventDefault();
    lol_notice();
  });

});
</script>