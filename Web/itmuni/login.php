<?php
error_reporting(0);
session_start();
$school="ITM Exodia";
$_SESSION[$school]=$school;
if($_SESSION['roll']){header('Location: index.php');};

$input = array("#44282f", "#EC4141", "#ff6138", "#2a2c2b", "#578a2a");
$rand_keys = array_rand($input, 2);
$color= $input[$rand_keys[0]];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="We create dreams, one pixel at a time">
<meta name="author" content="Webstone">
<title><?php echo $school; ?> - Login</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/simple-sidebar.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<style>
body{font-family:Lato !important;position: fixed;border: 7px solid rgb(23, 23, 23);background: <?php echo $color; ?>;color: #fff;height: 100%;width: 100%;}
.center {
    position: absolute;
	top:50%;
    left: 50%;
    width: 350px;
    height: 170px;
	margin-top:-60px;
	margin-left:-175px;
}
label{margin:0}
.input {
	position: relative;
	z-index: 1;
	display: inline-block;
	margin: 1em;
	max-width: 350px;
	width: calc(100% - 2em);
	vertical-align: top;
}

.input__field {
	position: relative;
	display: block;
	float: right;
	padding: 0.8em;
	width: 60%;
	border: none;
	border-radius: 0;
	background: #f0f0f0;
	color: #aaa;
	font-weight: 400;
	font-family: "Avenir Next", "Helvetica Neue", Helvetica, Arial, sans-serif;
	-webkit-appearance: none; /* for box shadows to show on iOS */
}

.input__field:focus {
	outline: none;
}

.input__label {
	display: inline-block;
	float: right;
	padding: 0 1em;
	width: 40%;
	color: #fff;
	font-weight: bold;
	-webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.input__label-content {
	position: relative;
	display: block;
	padding: 1.6em 0;
	width: 100%;
}

.graphic {
	position: absolute;
	top: 0;
	left: 0;
	fill: none;
}

.icon {
	color: #ddd;
	font-size: 150%;
}

/* Nariko */
.input--nariko {
	overflow: hidden;
	padding-top: 2em;
}

.input__field--nariko {
	width: 100%;
	background: transparent;
	opacity: 0;
	font-size:20px;
	padding: 0.35em;
	z-index: 100;
	color: #000;
}

.input__label--nariko {
	width: 100%;
	bottom: 0;
	position: absolute;
	pointer-events: none;
	text-align: left;
	color: rgba(0, 0, 0, 0.63);
	padding: 0 0.5em;
}

.input__label--nariko::before {
	content: '';
	position: absolute;
	width: 100%;
	height: 4em;
	top: 100%;
	left: 0;
	background: #fff;
	opacity:0.7;
	border-top: 3px solid rgb(0, 0, 0);
	-webkit-transform: translate3d(0, -3px, 0);
	transform: translate3d(0, -3px, 0);
	-webkit-transition: -webkit-transform 0.4s;
	transition: transform 0.4s;
	-webkit-transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
	transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
}

.input__label-content--nariko {
	padding: 0.5em 0;
	    word-spacing: 2px;
	-webkit-transform-origin: 0% 100%;
	transform-origin: 0% 100%;
	-webkit-transition: -webkit-transform 0.4s, color 0.4s;
	transition: transform 0.4s, color 0.4s;
	-webkit-transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
	transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
}

.input__field--nariko:focus,
.input--filled .input__field--nariko {
	cursor: text;
	opacity: 1;
	-webkit-transition: opacity 0s 0.4s;
	transition: opacity 0s 0.4s;
} 

.input__field--nariko:focus + .input__label--nariko::before,
.input--filled .input__label--nariko::before {
	-webkit-transition-delay: 0.05s;
	transition-delay: 0.05s;
	-webkit-transform: translate3d(0, -3.3em, 0);
	transform: translate3d(0, -3.3em, 0);
}

.input__field--nariko:focus + .input__label--nariko .input__label-content--nariko,
.input--filled .input__label-content--nariko {
	color: #fff;
	-webkit-transform: translate3d(0, -3.3em, 0) scale3d(0.81, 0.81, 1);
	transform: translate3d(0, -3.3em, 0) scale3d(0.81, 0.81, 1);
}
.head{background: #000;
opacity:0.7;
    margin: 7px;
	font-size:15px;
    padding: 10px;
    color: #fff;
    position: fixed;
    left: 0;
	z-index:999;
	text-align:center;word-spacing:2px;
    width: calc(100% - 14px);}
.submitb{    position: relative;
    z-index: 1;
    display: inline-block;
    margin: 1em;
    max-width: 350px;
    width: calc(100% - 2em);
    vertical-align: top;background:#000;opacity:0.7;color:#fff;padding:10px;border:none;margin-top:-5px;box-shadow:1px 1px 5px #000;
}
.submitb[disabled]{cursor:not-allowed;}
.submitb:hover{box-shadow:3px 3px 10px #000;background:#fff;color:#000; -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;    
    font-weight: 800;}
	.fa-user{    font-size: 100px;
    padding: 20px 34px;
    height: 150px;
	opacity:0.7;
    background: #000;
    margin: -100px 100px;
    width: 150px;
    border-radius: 100%;
    border: 2px #fff solid;}
</style>
</head>
<body>
<div class="head" style="top:0;text-align:left;text-transform:uppercase"><?php echo $school; ?><span style="float:right"> LOGIN</span></div>
<div class="head" style="bottom:0">&copy; EXODIA | 2016 | All Rights Reserved</div><div>

<form id="forusername" style="display:initial" action="" autocomplete="off">
<div class="center"><i class="fa fa-user" title="user image"></i><span style="margin-top:40px" class="input input--nariko">
					<input class="input__field input__field--nariko" type="text" id="input-21" autofocus />
					<label class="input__label input__label--nariko" for="input-21">
						<span class="input__label-content input__label-content--nariko"><i class="fa fa-snapchat-ghost" style="font-size: 18px;padding-right: 10px;padding-top: 10px;"></i>ENTER YOUR EMAIL/ROLL</span>
					</label>
				</span>
					<button type="submit" class="submitb" onclick="username()">SUBMIT</button>
					
					</form>
</div></div>
</body>
<script src="js/new.js"></script>
  <script type="text/javascript"> 
      $(document).ready(function(){
		  $("#forusername").submit(function(event){
        event.preventDefault();
    username();
  });
  	  
	  });
	  </script>
</html>
<?php echo""; ?>