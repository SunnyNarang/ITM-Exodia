
//reload attendance on click
function reloadatt() {
$.ajax({
type:'POST',
url: 'attendance.php',
data:{},
success: function(data){
$('#no').html(data);
},
error:function (){}
});
}
//go back to home
function backtohome() {
$.ajax({
type:'POST',
url: 'backtohome.php',
data:{},
success: function(data){
$('#menu-12').html(data);
},
error:function (){}
});
}			

//goto any profile
function gotoprofile(roll) {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$.ajax({
type:'GET',
url: 'profile.php',
data:{roll2:roll},
success: function(data){
$('#no').html(data);
},
error:function (){}
});
}
//go to dat for routine				
function gotoday(alt) {
$('#hellofday').html('<img src=img/loader.gif style="margin-top: 25%;">');
$.ajax({
type:'POST',
url: 'routineday.php',
data:{today:alt},
success: function(data){
$('#hellofday').html(data);
},
error:function (){}
});
}
//goto exam 				
function gotoexam(alt) {
$('#hellofday').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'resultall.php',
data:{today:alt},
success: function(data){
$('#hellofday').html(data);
},
error:function (){}
});
}				
			
function searchbtn()
{
var valid;	
valid = searchval();
if(valid){
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$("#profilesee").addClass("hideme");
	$.ajax({
	type:'POST',
	url: 'm/searchbtn.php',
	data:{searchtext:$('#search').val()},
	success: function(data){
	$('#no').html(data);
	},
	error:function (){}
	});
}
}

function searchval() {
var valid = true;	

if($('#search').val().length > "4") {
$('#spanforsearch').html('');
valid = true;}
else{
	valid = false;}				
return valid;
}

function setStyleSheet(url){
var stylesheet = document.getElementById("stylesheet");
stylesheet.setAttribute('href', url);
$.ajax({
type:'POST',
url: 'm/colorchange.php',
data:{color:url},
success: function(data){
},
error:function (){}
});
}
				
function restartnotice() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('notice.php');
}

function username() {
var valid;	
valid = checkroll();
if(valid) {
$('.submitb').attr('disabled','disabled');	
$('.submitb').html('<i style="font-size:20px" class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
setTimeout(function(){
$.ajax({
type:'POST',
url: 'password.php',
data:{username:$('#input-21').val()},
success: function(data){
$('.center').html(data);
},
error:function (){}
});
}, 1000);
}
}

function checkroll() {
var valid = true;	

if(!$('#input-21').val()) {
$('#input-21').css('border','1px solid #F00');
valid = false;
}					
return valid;
}
				
function password() {
var valid;	
valid = checkpass();
if(valid) {
	$('.submitb').attr('disabled','disabled');
$('.submitb').html('<i style="font-size:20px" class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
setTimeout(function(){
$.ajax({
type:'POST',
url: 'check.php',
data:{use:$('#use').val(), password:$('#input-21').val()},
success: function(data){
$('.center').html(data);
},
error:function (){}
});
}, 1000);
}
}

function checkpass() {
var valid = true;	

if(!$('#input-21').val()) {
$('#input-21').css('border','1px solid #F00');
valid = false;
}					
return valid;
}	

function simongoback() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('subjects.php');
}

function subjects(id) {
$.ajax({
type:'POST',
url: 'm/sub.php',
data:{subid:$('#hideid'+id+'').val()},
success: function(data){
$('#no').html(data);
},
error:function (){}
});
}

function change_pass() {
var valid;	
valid = val_pass();
if(valid) {
	$('#ch_pass_btn').attr('disabled','disabled');
$.ajax({
type:'POST',
url: 'm/ch_pass.php',
data:{old_pass:$('#ch_old_pass').val(), new_pass:$('#ch_new_pass').val(), ver_pass:$('#ch_ver_pass').val()},
success: function(data){
$('#ch_pass_note').html(data);
	$('#ch_old_pass').val('');
	$('#ch_new_pass').val('');
	$('#ch_ver_pass').val('');
$('#ch_pass_btn').removeAttr('disabled','disabled');
},
error:function (){}
});
}
}

function val_pass() {
var valid = true;	

if(!$('#ch_old_pass').val()) {
$('#ch_pass_note').html('Please enter your old password !');
$('#ch_pass_note').css('color','red');
valid = false;
} else if(!$('#ch_new_pass').val()) {
$('#ch_pass_note').html('Please enter your new password !');
$('#ch_pass_note').css('color','red');
valid = false;
} else if(!$('#ch_ver_pass').val()) {
$('#ch_pass_note').html('Please verify your new password !');
$('#ch_pass_note').css('color','red');
valid = false;
}					
return valid;
}
function forgot_pass(roll) {
		$.ajax({
		type:'POST',
		url: 'create_pass.php',
		data:{roll:roll},
		success: function(data){
			$('#forg_message').html(data);
		},
		error:function (){}
		});
}
function sendemail(email,id,roll) {
		$.ajax({
		type:'POST',
		url: 'gadar.php',
		data:{roll:roll, email:email, id:id},
		success: function(data){
			$('#forg_message').html(data);
		},
		error:function (){}
		});
}