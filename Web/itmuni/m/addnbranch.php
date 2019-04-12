<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['course']){echo '<script>window.parent.location = "index.php"</script>';}
$postedcourse=$_POST['course'];
$postedcourse=htmlspecialchars($postedcourse, ENT_QUOTES, 'UTF-8');
?>
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Select Branch</span>
				<select name="add_branch" id="" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 2px;margin-top: 2px;color: #555;border-color: #ccc;border-radius: 3px;">
				<option value="">Select a Branch</option>
<?php
	$stmt = $conn->prepare('SELECT distinct branch from class where course=?');
		$stmt->bind_param("s", $postedcourse);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	   $branch=$row['branch'];
?>
<option value="<?php echo $branch; ?>"><?php echo $branch; ?></option>
<?php }}?>
<option value="">Add branch</option>
				</select>
				
	  <script type="text/javascript"> 
      $(document).ready(function(){
$(function() {
    $('select[name=add_branch]').change( function() {
        var value = $(this).val();
        if (!value || value == '') {
           var other = prompt( "Please enter branch name" );
           if (!other) return false;
           $(this).append('<option value="'
                             + other
                             + '" selected="selected">'
                             + other
                             + '</option>');
							
        } else {other=value;} 
		console.log(other);
		var course = $('select[name=add_course]').val();
		getaddsem(other, course);
    });
});
	  });
	  </script>	