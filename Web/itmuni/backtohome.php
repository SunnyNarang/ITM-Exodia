<?php
ob_start();
define('IN_SITE', true, true);
session_start();
if(!$_SESSION['ITM Exodia'] or !$_SESSION['roll']){session_destroy(); session_unset(); header('Location: ../login.php');};
$school=$_SESSION['ITM Exodia'];
$roll=$_SESSION['roll'];
include('db.php');
?>
<h2 class="fa fa-empire" style="font-weight:800">ITM <span style="text-transform: lowercase;font-size: 40px;">EXODIA</span></h2>
				<?php include("m/menu/".$_SESSION['file'].".php"); ?>
				  <script type="text/javascript"> 
      $(document).ready(function(){
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
          // Stop normal link behavior
          return false;
        });
      });
        </script>