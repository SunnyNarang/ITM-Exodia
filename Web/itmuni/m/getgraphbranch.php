<script type="text/javascript" src="js/fusioncharts.js"></script>
<?php
  include("fusioncharts.php");
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['course'] or !$_POST['branch'] or !$_POST['sem']){echo '<script>window.parent.location = "index.php"</script>';}
$postedcourse=$_POST['course'];
$postedcourse=htmlspecialchars($postedcourse, ENT_QUOTES, 'UTF-8');
$postedbranch=$_POST['branch'];
$postedbranch=htmlspecialchars($postedbranch, ENT_QUOTES, 'UTF-8');
$postedsem=$_POST['sem'];
$postedsem=htmlspecialchars($postedsem, ENT_QUOTES, 'UTF-8');
  	if(!$_POST['day']){$postedday=10;} else{$postedday=$_POST['day'];}
	if(!$_POST['datee']){$posteddate=date("Y-m-d");} else{$posteddate=$_POST['datee'];}
	$stmt = $conn->prepare('select cnt,
        c.name, c.id
from (select attendance.class_id, class.course, count(distinct roll, att_date) as cnt 
      from attendance inner join class on class.id=attendance.class_id
      where status = 1 and course=? and branch =? and sem=? and att_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
      group by class_id
     ) a join
     class c
     on a.class_id = c.id;');
	 $stmt->bind_param('ssss', $postedcourse, $postedbranch, $postedsem, $postedday);
$stmt->execute();
$result = $stmt->get_result();
  // If the query returns a valid response, prepare the JSON string
  if ($result->num_rows > 0) {
    // The `$arrData` array holds the chart attributes and data
    $arrData = array(
      "chart" => array(
          "caption" => $postedcourse." | ".$postedbranch." | Sem". $postedsem,
		  "subCaption" => "Approximate number of students present per day",
          "paletteColors" => "#0075c2",
          "bgColor" => "#ffffff",
          "borderAlpha"=> "20",
          "canvasBorderAlpha"=> "0",
          "usePlotGradientColor"=> "0",
          "plotBorderAlpha"=> "10",
          "showXAxisLine"=> "1",
          "xAxisLineColor" => "#999999",
          "showValues" => "1",
          "divlineColor" => "#999999",
          "divLineIsDashed" => "1",
		  "exportenabled" => "1",
        "exportatclient" => "0",
        "exporthandler" => "https://export.api3.fusioncharts.com/",
        "html5exporthandler" => "https://export.api3.fusioncharts.com/",
          "showAlternateHGridColor" => "0"
        )
    );

    $arrData["data"] = array();

    // Push the data into the array
    while($row = $result->fetch_assoc()) {
$class_id_new=$row['id'];
$class_count=$row['cnt'];
$class_name=$row['name'];
			$stmt1 = $conn->prepare('SELECT count(distinct att_date) as number FROM `attendance` WHERE class_id= ? and att_date >= DATE_SUB(NOW(), INTERVAL ? DAY);');
$stmt1->bind_param('ss', $class_id_new, $postedday);
$stmt1->execute();
$result1 = $stmt1->get_result();
while($row1 = $result1->fetch_assoc()) {
	$number_date= $row1['number'];
}
$class_count=$class_count/$number_date;
      array_push($arrData["data"], array(
          "label" => $class_name,
          "value" => $class_count
          )
      );
    }

    /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

    $jsonEncodedData = json_encode($arrData);

    /*Create an object for the column chart using the FusionCharts PHP class constructor. Syntax for the constructor is ` FusionCharts("type of chart", "unique chart id", width of the chart, height of the chart, "div id to render the chart", "data format", "data source")`. Because we are using JSON data to render the chart, the data format will be `json`. The variable `$jsonEncodeData` holds all the JSON data for the chart, and will be passed as the value for the data source parameter of the constructor.*/

    $columnChart = new FusionCharts("column2D", time() , '100%', 300, "chart-3", "json", $jsonEncodedData);

    // Render the chart
  $columnChart->render(); }else{echo "No data to display";}

  	$stmt = $conn->prepare('select cnt,
        c.name, c.id
from (select attendance.class_id, class.course, count(distinct roll, att_date) as cnt 
      from attendance inner join class on class.id=attendance.class_id
      where status = 1 and course=? and branch =? and sem=? and att_date = ?
      group by class_id
     ) a join
     class c
     on a.class_id = c.id;');
	 $stmt->bind_param('ssss', $postedcourse, $postedbranch, $postedsem, $posteddate);
$stmt->execute();
$result = $stmt->get_result();
  // If the query returns a valid response, prepare the JSON string
  if ($result->num_rows > 0) {
    // The `$arrData` array holds the chart attributes and data
    $arrData = array(
      "chart" => array(
          "caption" => $postedcourse." | ".$postedbranch." | Sem". $postedsem,
		  "subCaption" => "Number of students present on ".$posteddate,
          "paletteColors" => "#0075c2",
          "bgColor" => "#ffffff",
          "borderAlpha"=> "20",
          "canvasBorderAlpha"=> "0",
          "usePlotGradientColor"=> "0",
          "plotBorderAlpha"=> "10",
          "showXAxisLine"=> "1",
          "xAxisLineColor" => "#999999",
          "showValues" => "1",
          "divlineColor" => "#999999",
          "divLineIsDashed" => "1",
		  "exportenabled" => "1",
        "exportatclient" => "0",
        "exporthandler" => "https://export.api3.fusioncharts.com/",
        "html5exporthandler" => "https://export.api3.fusioncharts.com/",
          "showAlternateHGridColor" => "0"
        )
    );

    $arrData["data"] = array();

    // Push the data into the array
    while($row = $result->fetch_assoc()) {
$class_id_new=$row['id'];
$class_count=$row['cnt'];
$class_name=$row['name'];
      array_push($arrData["data"], array(
          "label" => $class_name,
          "value" => $class_count
          )
      );
    }

    /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

    $jsonEncodedData = json_encode($arrData);

    /*Create an object for the column chart using the FusionCharts PHP class constructor. Syntax for the constructor is ` FusionCharts("type of chart", "unique chart id", width of the chart, height of the chart, "div id to render the chart", "data format", "data source")`. Because we are using JSON data to render the chart, the data format will be `json`. The variable `$jsonEncodeData` holds all the JSON data for the chart, and will be passed as the value for the data source parameter of the constructor.*/

    $columnChart = new FusionCharts("column2D", time().$posteddate , '100%', 300, $posteddate, "json", $jsonEncodedData);

    // Render the chart
  $columnChart->render(); }else{echo "";}
    // Close the database connection
    $conn->close();
  

?>
<div class="row family" style="margin:0;background:#fff;width:100%">
<span style="text-align: left;font-size: 30px;font-family: Oswald;font-weight: 600;color: #585858;margin-bottom: 10px;">Attendance Statistics</span>
<div class="col-sm-4" style="padding:0">
<link rel="stylesheet" type="text/css"  href="css/bootstrap-datetimepicker.css">
<div class='input-group date date-input' id='datetimepickergraph'  data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="display:-webkit-box">
	<input type='text' name="date" id="dategraphinput" class="form-control" placeholder="Search by Date" value="<?php echo $posteddate; ?>"  style="font-family: 'Titillium Web';font-weight: 600;" />
	<span class="input-group-addon" style="width:inherit">
	<span class="glyphicon glyphicon-calendar"></span>
	</span>
</div></div>
<div id="<?php echo $posteddate; ?>" class="col-sm-12" style="padding:0"></div></div>

<div class="row family" style="margin:0;background:#fff;width:100%">
<span style="text-align: left;font-size: 30px;font-family: Oswald;font-weight: 600;color: #585858;margin-bottom: 10px;">Average per day</span>
<div class="col-sm-4" style="padding:0"><select name="graphday" id="graphday" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="10" <?php if($_POST['day']==10){echo "selected";} ?>>Last 10 day</option>
				<option value="15" <?php if($_POST['day']==15){echo "selected";} ?>>Last 15 day</option>
				<option value="30" <?php if($_POST['day']==30){echo "selected";} ?>>Last 30 day</option>
				<option value="60" <?php if($_POST['day']==60){echo "selected";} ?>>Last 60 day</option>
				<option value="90" <?php if($_POST['day']==90){echo "selected";} ?>>Last 90 day</option>
				<option value="120" <?php if($_POST['day']==120){echo "selected";} ?>>Last 120 day</option>
				</select></div>
<div id="chart-3" class="col-sm-12" style="padding:0"></div></div>
<script type="text/javascript">
$(document).ready(function() {
	$('select[name=graphday]').change(function() {
		var combo = $(this).val();
		graphday(combo, '<?php echo $postedcourse; ?>', '<?php echo $postedbranch; ?>', '<?php echo $postedsem; ?>');
    });
});
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
                $('#datetimepickergraph').datetimepicker('setEndDate', '<?php echo date('Y-m-d'); ?>');
            });
	
        </script>
<script type="text/javascript">
$(document).ready(function() {
    
	$("#datetimepickergraph").change(function() {
		var combo = $('#dategraphinput').val();
		graphdate(combo, '<?php echo $postedcourse; ?>', '<?php echo $postedbranch; ?>', '<?php echo $postedsem; ?>');
		});	
    });
</script>