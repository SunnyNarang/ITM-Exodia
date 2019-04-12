
<?php

//if(!$_GET['roll']){echo '<script>window.parent.location = "index.php"</script>';}
$postedroll=$stu_roll;
$postedroll=htmlspecialchars($postedroll, ENT_QUOTES, 'UTF-8');
  // Form the SQL query that returns the top 10 most populous countries
//$stmt = $conn->prepare('select c.name,
//       (select count(*) from attendance a where a.status = 1 and a.class_id = c.id) as total
//from class c where branch="Computer Science";');
$stmt32 = $conn->prepare("SELECT
  a.roll, 
  a.sub_id, 
  b.name, 
  SUM(Case when status=0 then 1 else 0 end) as 'status with 0',
  SUM(Case when status=1 then 1 else 0 end) as 'status with 1'
FROM
  attendance a inner join subject b on
  a.sub_id = b.id  where roll='0905cs151023'
  group by a.roll, a.sub_id;");
$stmt32->execute();
$result32 = $stmt32->get_result();
  // If the query returns a valid response, prepare the JSON string
  if ($result32) {
    // The `$arrData` array holds the chart attributes and data
    $arrData = array(
      "chart" => array(
          "caption" => $postedroll,
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

    $columnChart = new FusionCharts("pie3d", $stu_roll.rand(1,1000000000) , '100%', 300, $stu_roll, "json", $jsonEncodedData);

    // Render the chart
  $columnChart->render(); }
    // Close the database connection

  

?>
<div id="<?php echo $stu_roll; ?>" style="display:inline-block"></div>