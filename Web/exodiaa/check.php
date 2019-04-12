<?php
error_reporting(0);
$use=$_POST['use'];
$pass=$_POST['password'];
$use=htmlspecialchars($use, ENT_QUOTES, 'UTF-8');
$pass=htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');
// Create connection
include('db.php');
$stmt = $conn->prepare('SELECT * FROM login where (roll = ? or email = ?) and password = ?');
$stmt->bind_param('sss', $use, $use, $pass);

$stmt->execute();

$result = $stmt->get_result();

//$sql = "SELECT * FROM login where (roll='$use' or email='$use') and password='$pass'";
//$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $image=$row['image'];
	   $roll=$row['roll'];
    }
?>
<div style="box-shadow:1px 1px 5px #292928;width: 350px;word-spacing: 2px;text-align: center;padding:10px;text-transform:uppercase;background:#125f0d;color:#fff;position:fixed;top:45%"><i style="margin-right:10px;font-size:20px" class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
<form action='index.php' method='post' name='frm'>
<?php
session_start();
$_SESSION['roll']=$roll;
?>
</form>

<script>
setTimeout(function(){
document.frm.submit();
}, 3000);
</script>
<?php
} else {
?>
<div style="box-shadow:1px 1px 5px #292928;width: 350px;word-spacing: 2px;text-align: center;padding:10px;text-transform:uppercase;background:#d41414;;color:#fff;position:fixed;top:55px">Incorrect Password</div>
<i class="fa fa-user"></i><span style="margin-top:40px" class="input input--nariko">
					<input class="input__field input__field--nariko" type="text" id="input-21"  autofocus/>
					<label class="input__label input__label--nariko" for="input-21">
						<span class="input__label-content input__label-content--nariko"><i class="fa fa-snapchat-ghost" style="font-size: 18px;padding-right: 10px;padding-top: 10px;"></i>ENTER YOUR EMAIL/ROLL</span>
					</label>
				</span>
					<button class="submitb" onclick="username()">SUBMIT</button>
<?php
}
$conn->close();
?>