<?php
error_reporting(0);
$user=$_POST['username'];
$user=htmlspecialchars($user, ENT_QUOTES, 'UTF-8');
// Create connection
include('db.php');
$stmt = $conn->prepare('SELECT * FROM login where roll = ? or email = ?');
$stmt->bind_param('ss', $user, $user);

$stmt->execute();

$result = $stmt->get_result();

//$sql = "SELECT * FROM login where roll='$user' or email='$user'";
//$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$rolll=$row['roll'];
       $image=$row['image'];
    }
?>
<form id="forpass" style="display:initial" action="" autocomplete="off">
<img class="fa-user" src="img/<?php if(!$image){echo 'user.png';}else {echo $image;}; ?>" style="background:none;padding:0;margin: -115px 100px;position: fixed;border:4px solid #fff;opacity:1"><span style="margin-top:40px" class="input input--nariko">
<input style="display:none" id="use" value='<?php echo $user; ?>'>
					<input class="input__field input__field--nariko" type="text" id="input-21" autofocus />
					<label class="input__label input__label--nariko" for="input-21">
						<span class="input__label-content input__label-content--nariko"><i class="fa fa-lock" style="font-size: 18px;padding-right: 10px;padding-top: 10px;"></i>ENTER YOUR PASSWORD</span>
					</label>
				</span>
					<button type="submit" class="submitb" style="margin-bottom:0" onclick="password()">SUBMIT</button>
					<span id="forg_message" style="padding: 10px;float: right;font-size: 14px;cursor:pointer" onclick="forgot_pass('<?php echo $rolll; ?>')">Forgot Password ?</span>
					</form>
					  <script type="text/javascript"> 
      $(document).ready(function(){
		  $("#forpass").submit(function(event){
        event.preventDefault();
    password();
  });  	  
	  });
	  </script>
<?php
} else {
?>
<div style="box-shadow:1px 1px 5px #292928;width: 350px;word-spacing: 2px;text-align: center;padding:10px;text-transform:uppercase;background:#d41414;;color:#fff;position:fixed;top:55px">Incorrect Email / Roll</div>
<form id="foruser" style="display:initial" action="" autocomplete="off">
<i class="fa fa-user"></i><span style="margin-top:40px" class="input input--nariko">
					<input class="input__field input__field--nariko" type="text" id="input-21" />
					<label class="input__label input__label--nariko" for="input-21">
						<span class="input__label-content input__label-content--nariko"><i class="fa fa-snapchat-ghost" style="font-size: 18px;padding-right: 10px;padding-top: 10px;"></i>ENTER YOUR EMAIL/ROLL</span>
					</label>
				</span>
					<button class="submitb" onclick="username()">SUBMIT</button>
					</form>
					<script src="js/new.js"></script>
  <script type="text/javascript"> 
      $(document).ready(function(){
		  $("#foruser").submit(function(event){
        event.preventDefault();
    username();
  });
  	  
	  });
	  </script>
<?php
}
$conn->close();
?>