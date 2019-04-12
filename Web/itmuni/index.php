<?php
ob_start();
error_reporting(0);
define('IN_SITE', true, true);
session_start();
if(!$_SESSION['ITM Exodia'] or !$_SESSION['roll']){session_destroy(); session_unset(); header('Location: login.php');};
$school=$_SESSION['ITM Exodia'];
$roll=$_SESSION['roll'];
include('db.php');
$stmt = $conn->prepare('Update login set active=now() where roll = ?');
$stmt->bind_param('s', $roll);
$stmt->execute();

$stmt = $conn->prepare('SELECT * FROM login where roll = ? or email = ?');
$stmt->bind_param('ss', $roll, $roll);

$stmt->execute();

$result = $stmt->get_result();

//$sql = "SELECT * FROM login where (roll='$use' or email='$use') and password='$pass'";
//$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$cipherstatus=$row['roll'];
		$activebabe=$row['active'];
		//encrypt
		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
		$plaintext = $roll.$school.$activebabe.$cipherstatus;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	 $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
	 $ciphertext = $iv . $ciphertext;
	 $cipherurl = base64_encode($ciphertext);
		
       $type=$row['type'];
	   $image=$row['image'];
	   $color=$row['color'];
	   $_SESSION['image']=$image;
	   $_SESSION['color']=$color;
    }
}else {session_destroy(); session_unset(); header('Location: login.php');};
if($type=='1'){$file='stu';$_SESSION['type']="1";$_SESSION['file']=$file;}elseif($type=='2'){$file='tea';$_SESSION['type']="2";$_SESSION['file']=$file;}else{$file='adm';$_SESSION['type']="3";$_SESSION['file']=$file;};
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>ITM Exodia - Dashboard</title>
		<meta name="description" content="ITM Result Management" />
		<meta name="keywords" content="ITM Dybnamic Result Management" />
		<meta name="author" content="Saurav" />
		<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.css" />
		<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="favicon.ico">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/icons.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<link rel="stylesheet" type="text/css" href="css/new.css" />
		<link id="stylesheet" rel="stylesheet" type="text/css" href="<?php echo $color; ?>" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<script src="js/modernizr.custom.js"></script>
		
		<!--[if IE]>
  		<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
</head>
	<body>
	<div id="pagewrap" class="pagewrap">
	<div class="container show" id="page-1" style="padding:0;width:100%;">
		<div id="st-container" class="st-container">
			<nav class="st-menu st-effect-12 change-fa" id="menu-12" style="overflow-y:scroll">
				<h2 class="fa fa-empire" style="font-weight:800">ITM <span style="text-transform: lowercase;font-size: 40px;">EXODIA</span></h2>
				<?php include("m/menu/".$file.".php"); ?>
			</nav>
			<div class="st-pusher">
				<div class="st-content"><!-- this is the wrapper for the content -->
					<div class="st-content-inner" style="padding-bottom:70px"><!-- extra div for emulating position:fixed of the menu -->
						<!-- Top Navigation -->
				
						<?php include("m/top.php"); ?>
			<div class="family hidden-status" style="margin:0;width:100%;cursor:initial;background:#fff;padding:10px">
			<div style="display:block">
			<form id="searchchangee" style="display:initial" action="" autocomplete="off">			
			<div class="col-sm-12" style="padding:0">
			<input onkeyup="searchbtn();" placeholder="Search for a roll or name..." type="text" id="search" style="font-size:15px;border-radius:5px 0px 0px 5px;width:calc(100% - 50px);display:inline;padding:6px 10px;font-style:italic;font-weight:800;font-family:'Titillium Web', sans-serif;border:none;border-color: transparent;color:#585858;outline:none" autofocus>
			<button id="spanofsearch" type="submit" class="btn-md" style="box-shadow: 1px 1px 8px #a7a7a7;font-family:FontAwesome,Titillium Web;font-size: 18px;color: #fff;padding: 4px 12px;margin-top:-1px;border-radius: 0px 5px 5px 0px;display: inline;font-weight: 800;text-transform: uppercase;margin-left: -3px;display:none"><i class="fa fa-search" style="padding:4px 0px"></i></button>
			<span id="spanforsearch" style="color:red"></span>
			</div>
			</form>
			</div>
			</div>
						<div class="row">
							<div class="col-sm-3">
								<div id="profilesee"><?php include('m/'.$file.'_profile.php'); ?></div>
							</div>
							<div class="col-sm-9" id="no" style="margin-bottom:20%">
								<?php include('m/notice.php'); ?>
							</div> 
						</div>						
					</div>

						
					</div><!-- /st-content-inner -->
				</div><!-- /st-content -->
			</div><!-- /st-pusher -->
		</div><!-- /st-container -->
		</div><span id="shithappens"></span>

		<script src="js/classie.js"></script>
		<script src="js/sidebarEffects.js"></script>
		<script src="js/<?php if($type=='1'){echo "new.js";}else {echo "teach.js";}?>"></script>
		<script src="js/jquery.nicescroll.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type="text/javascript"> 
      $(document).ready(function(){
    $("#menu-12").niceScroll({cursorcolor:"#272727",cursorwidth:"6px"});
  
		  $("#searchchangee").submit(function(event){
        event.preventDefault();
    searchbtn();
  });
		  
		  $('#show-search').on('click', function(){
			  $(".hidden-status").slideToggle("linear");
		  });
        // Set trigger and container variables
        var trigger = $('.thelink'),
            container = $('#no');
        
        // Fire on click
        trigger.on('click', function(){
			 $("#profilesee").addClass("hideme");
			$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
          // Set $this for re-use. Set target from data attribute
          var $this = $(this),
            target = $this.data('target');       
          $("#st-container").removeClass("st-menu-open");
          // Load target page into container
          container.load(target + '.php');
		  $("title").html("ITM Exodia - "+target);
		  //history.replaceState(null, null, target);
          // Stop normal link behavior
          return false;
        });
      });
        </script><script>
history.pushState(null, null, '?<?php echo $cipherurl; ?>');
window.addEventListener('popstate', function () {
    history.pushState(null, null, '');
});
</script> 

	</body>
</html>