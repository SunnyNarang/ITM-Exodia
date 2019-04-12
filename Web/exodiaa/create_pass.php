<?php
$roll=$_POST['roll'];
include('db.php');
$stmt = $conn->prepare('SELECT * FROM login where roll = ? or email = ?');
$stmt->bind_param('ss', $roll, $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$rolll=$row['roll'];
       $email=$row['email'];
}}
$random=rand(100000,99999999);
$stmt = $conn->prepare('update login set otp=? where roll = ?');
$stmt->bind_param('ss', $random, $rolll);
$stmt->execute();
?>
<script>
setTimeout(function(){
sendemail('<?php echo $email; ?>', '<?php echo $random; ?>', '<?php echo $roll; ?>');
}, 100);
</script>
