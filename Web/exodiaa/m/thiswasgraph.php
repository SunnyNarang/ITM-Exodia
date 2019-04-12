<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
  include("fusioncharts.php");
if(!$_POST['roll_id']){echo '<script>window.parent.location = "index.php"</script>';}
$postedroll_id=$_POST['roll_id'];
$postedroll_id=htmlspecialchars($postedroll_id, ENT_QUOTES, 'UTF-8');
$postedclass_id=$_POST['class_id'];
$postedclass_id=htmlspecialchars($postedclass_id, ENT_QUOTES, 'UTF-8');
$stu_att=$_POST['att'];
$stu_att=htmlspecialchars($stu_att, ENT_QUOTES, 'UTF-8');
$stu_name=$_POST['name'];
$stu_name=htmlspecialchars($stu_name, ENT_QUOTES, 'UTF-8');
$stmt32 = $conn->prepare("SELECT
  a.roll, 
  a.sub_id, 
  b.name, 
  SUM(Case when status=0 then 1 else 0 end) as 'status with 0',
  SUM(Case when status=1 then 1 else 0 end) as 'status with 1'
FROM
  attendance a inner join subject b on
  a.sub_id = b.id  where roll=?
  group by a.roll, a.sub_id;");
  $stmt32->bind_param("s", $postedroll_id);
$stmt32->execute();
$result32 = $stmt32->get_result();
  // If the query returns a valid response, prepare the JSON string
  if ($result32) {
    // The `$arrData` array holds the chart attributes and data
    $arrData = array(
      "chart" => array(
          "caption" => $postedroll_id,
        "subcaption" => "Attendance Statistics of all Subjects",
        "startingangle" => "120",
        "showlabels" => "0",
        "showlegend" => "1",
        "enablemultislicing" => "0",
        "slicingdistance" => "15",
        "showpercentvalues" => "0",
        "showpercentintooltip" => "1",
		  "exportenabled" => "1",
        "exportatclient" => "0",
        "exporthandler" => "http://export.api3.fusioncharts.com/",
        "html5exporthandler" => "http://export.api3.fusioncharts.com/",
          "showAlternateHGridColor" => "0"
        )
    );

    $arrData["data"] = array();

    // Push the data into the array
    while($row32 = $result32->fetch_assoc()) {
      array_push($arrData["data"], array(
          "label" => $row32["name"],
          "value" => $row32["status with 1"]
          )
      );
    }

    /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

    $jsonEncodedData = json_encode($arrData);

    /*Create an object for the column chart using the FusionCharts PHP class constructor. Syntax for the constructor is ` FusionCharts("type of chart", "unique chart id", width of the chart, height of the chart, "div id to render the chart", "data format", "data source")`. Because we are using JSON data to render the chart, the data format will be `json`. The variable `$jsonEncodeData` holds all the JSON data for the chart, and will be passed as the value for the data source parameter of the constructor.*/

    $columnChart = new FusionCharts("pie3d", $postedroll_id.rand(1,1000000000) , '100%', 250, $postedroll_id."new", "json", $jsonEncodedData);

    // Render the chart
  $columnChart->render(); }
?>
<div class="family" onclick="getgraphlist('<?php echo $postedclass_id; ?>')" style="width:100%;margin:0;border-left:8px solid <?php if($stu_att>="75"){echo "#0a5f09";} else {echo "#800c0c";} ?>;padding:10px;border-right:8px solid <?php if($stu_att>="75"){echo "#0a5f09";} else {echo "#800c0c";} ?>;border-bottom: 1px solid #e6e6e6;">
			<div style="display:inline-block;vertical-align:middle">
			<i style="vertical-align: middle;font-size: 30px;margin-right: 10px;" class="fa fa-arrow-left"></i><img src="img/<?php echo $postedroll_id; ?>.jpg" style="width:40px;border-radius:100%">
			</div>
			<div style="display:inline-block;vertical-align:middle;margin-left:4px">
			<span style="font-family: 'Titillium Web', sans-serif;font-size: 18px;color:#00baff;font-weight: 800;"><?php echo $stu_name; ?></span>
			<span style="font-family: 'Oswald', sans-serif;color:#868686"><?php echo $postedroll_id; ?></span>
			</div>
			<div style="display:inline-block;float:right;vertical-align:middle">
			<span style="font-family: 'Oswald', sans-serif;color:<?php if($stu_att>="75"){echo "#0a5f09";} else {echo "#800c0c";} ?>;font-size: 25px;margin-top: 3px;"><?php echo $stu_att; ?> %</span>
			</div>
			</div>
<div id="<?php echo $postedroll_id."new"; ?>" style="margin-top:1px"></div>	
<script type="text/javascript" src="js/fusioncharts.js" defer="defer"></script>