<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');
?>
<div class="profileCard1">
                <div class="pImg">
                    <span class="fa fa-gear" style="font-size:25px"></span>
                </div>
                <div class="pDes">
                    <h1 class="text-center" style="font-family: 'Titillium Web', sans-serif;color: #63666a;font-weight:800">Account</h1>
					
                </div>
            </div>
	
			
<div class="family" style="margin:0;width:100%;cursor:initial">
			<div style="display:inline-block">
			<span style="display:block;font-size:30px;font-family:'Oswald', sans-serif;color:#585858;font-weight:800">Colour Scheme</span>
			<span style="cursor:pointer;margin-right:2px;display:inline;font-family: 'Oswald', sans-serif;color:#868686"><i style="color:#EC4141;font-size:40px" class="fa fa-square" onclick="setStyleSheet('css/color.php')"></i></span>
			<span style="cursor:pointer;margin-right:2px;display:inline;font-family: 'Oswald', sans-serif;color:#868686"><i style="color:#5bc0de;font-size:40px" class="fa fa-square" onclick="setStyleSheet('css/color2.php')"></i></span>
			<span style="cursor:pointer;margin-right:2px;display:inline;font-family: 'Oswald', sans-serif;color:#868686"><i style="color:#ff6138;font-size:40px" class="fa fa-square" onclick="setStyleSheet('css/color3.php')"></i></span>
			<span style="cursor:pointer;margin-right:2px;display:inline;font-family: 'Oswald', sans-serif;color:#868686"><i style="color:#2a2c2b;font-size:40px" class="fa fa-square" onclick="setStyleSheet('css/color4.php')"></i></span>
			<span style="cursor:pointer;margin-right:2px;display:inline;font-family: 'Oswald', sans-serif;color:#868686"><i style="color:#578a2a;font-size:40px" class="fa fa-square" onclick="setStyleSheet('css/color5.php')"></i></span>
			<span style="cursor:pointer;margin-right:2px;display:inline;font-family: 'Oswald', sans-serif;color:#868686"><i style="color:#44282f;font-size:40px" class="fa fa-square" onclick="setStyleSheet('css/color6.php')"></i></span>
			</div>
			</div>
<div class="family" style="margin:0;width:100%;cursor:initial">
			<span style="display:block;font-size:30px;font-family:'Oswald', sans-serif;color:#585858;font-weight:800">Change Password</span>
			<div class="row">
			<div class="col-sm-4">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Old Password</span>
				<input required name="ch_old_pass" id="ch_old_pass" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>

</div>
<div class="row">
			<div class="col-sm-4">
<p id="" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">New Password</span>
				<input minlength="6" required name="ch_new_pass" id="ch_new_pass" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
			<div class="col-sm-4">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
<span style="padding:0;font-size:15px;font-weight:800;text-align: left;">Confirm New Password</span>
				<input required name="ch_ver_pass" id="ch_ver_pass" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div></div>
<div class="row">
			<div class="col-sm-4">
<p id="notes_pdate" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<input type="submit" onclick="change_pass()" name="" id="ch_pass_btn" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 2px;color: #555;border:1px solid #ccc;border-radius: 2px;">
				</p>
</div>
			<div class="col-sm-4">
<p id="" style="color:#555555;font-family: 'Open Sans', sans-serif;font-weight: 400;font-size: 17px;margin-top: 10px;margin-bottom: 0px;">
				<span id="ch_pass_note" style="width: 100%;font-family: 'Titillium Web';font-size:15px;font-weight: 200;padding: 3px 4px;margin-top: 5px;"></span>
				</p>
</div>
</div>
			</div>			
