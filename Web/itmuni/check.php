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
<style>
body {
  background-color: #eee;
}

.showbox {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 5%;
}

.loader {
  position: relative;
  margin: 0 auto;
  width: 50px;
}
.loader:before {
  content: '';
  display: block;
  padding-top: 100%;
}

.circular {
  -webkit-animation: rotate 2s linear infinite;
          animation: rotate 2s linear infinite;
  height: 100%;
  -webkit-transform-origin: center center;
          transform-origin: center center;
  width: 100%;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}

.path {
  stroke-dasharray: 1, 200;
  stroke-dashoffset: 0;
  -webkit-animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
          animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
  stroke-linecap: round;
}

@-webkit-keyframes rotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}

@keyframes rotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
@-webkit-keyframes dash {
  0% {
    stroke-dasharray: 1, 200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 89, 200;
    stroke-dashoffset: -35px;
  }
  100% {
    stroke-dasharray: 89, 200;
    stroke-dashoffset: -124px;
  }
}
@keyframes dash {
  0% {
    stroke-dasharray: 1, 200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 89, 200;
    stroke-dashoffset: -35px;
  }
  100% {
    stroke-dasharray: 89, 200;
    stroke-dashoffset: -124px;
  }
}
@-webkit-keyframes color {
  100%,
  0% {
    stroke: #e33e2b;
  }
  40% {
    stroke: #f1b500;
  }
  66% {
    stroke: #2ba14b;
  }
  80%,
  90% {
    stroke: #3a7cec;
  }
}
@keyframes color {
  100%,
  0% {
    stroke: #e33e2b;
  }
  40% {
    stroke: #f1b500;
  }
  66% {
    stroke: #2ba14b;
  }
  80%,
  90% {
    stroke: #3a7cec;
  }
}

</style>
<div class="showbox">
  <div class="loader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"/>
    </svg>
  </div>
</div>
<form action='index.php' method='post' name='frm'>
<?php
session_start();
$_SESSION['roll']=$roll;
?>
</form>

<script>
setTimeout(function(){
document.frm.submit();
}, 6000);
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