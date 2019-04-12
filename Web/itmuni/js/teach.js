
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
//reload teacher attendance on click
function reloadteaatt() {
$.ajax({
type:'POST',
url: 'tea_attendance.php',
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
//get branch				
function getbranch(alt) {
$('#hellofcourse').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'markattbranch.php',
data:{today:alt},
success: function(data){
$('#hellofcourse').html(data);
},
error:function (){}
});
}

function getnbranch(alt) {
$('#hellofncourse').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'viewnotesbranch.php',
data:{today:alt},
success: function(data){
$('#hellofncourse').html(data);
},
error:function (){}
});
}

//get sem				
function getsem(alt, course, sem) {
$('#hellofsem').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'markattclass.php',
data:{today:alt, course:course, sem:sem},
success: function(data){
$('#hellofsem').html(data);
},
error:function (){}
});
}
function getnsem(alt, course, sem) {
$('#hellofnsem').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'viewnotesclass.php',
data:{today:alt, course:course, sem:sem},
success: function(data){
$('#hellofnsem').html(data);
},
error:function (){}
});
}
//get class				
function getclass(alt, course) {
$('#hellofbranch').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'markattsem.php',
data:{today:alt, course:course},
success: function(data){
$('#hellofbranch').html(data);
},
error:function (){}
});
}
function getnclass(alt, course) {
$('#hellofnbranch').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'viewnotessem.php',
data:{today:alt, course:course},
success: function(data){
$('#hellofnbranch').html(data);
},
error:function (){}
});
}
//get list				
function getlist(alt) {
$('#helloflist').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'markattlist.php',
data:{today:alt},
success: function(data){
$('#helloflist').html(data);
},
error:function (){}
});
}	
function getnlist(alt) {
$('#hellofnlist').html('<img src=img/loader.gif style="">');
$.ajax({
type:'POST',
url: 'viewnlist.php',
data:{today:alt},
success: function(data){
$('#hellofnlist').html(data);
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

function textCounter(field,field2,maxlimit)
{
 var countfield = document.getElementById(field2);
 if ( field.value.length > maxlimit ) {
  field.value = field.value.substring( 0, maxlimit );
  return false;
 } else {
  countfield.value = maxlimit - field.value.length;
 }
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
function getnobranch(course) {
	$('#notes_pbranch').html('');
$('#notes_psem').html('');	 $('#notes_pdate').html('');$('#notes_det').html('');
if(course != null && course != undefined && course !== "" ){
	$('#notes_psub').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/getnbranch.php',
		data:{course:course},
		success: function(data){ $('#notes_psub').html(data);
	},
		error:function (){}
		}); } else{$('#notes_psub').html("");}
}
function admitnobranch(course) {
	$('#admin_pbranch').html(''); $('#admin_psub').html('');
if(course != null && course != undefined && course !== "" ){
	$('#admin_psub').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/admitnbranch.php',
		data:{course:course},
		success: function(data){ $('#admin_psub').html(data); $('#admin_pbranch').load('m/notes_det.php');
	},
		error:function (){}
		}); } else{$('#admin_psub').html("");}
}

function getaddbranch(course) {
	$('#add_pbranch').html('');
$('#add_psem').html('');	 $('#add_pdate').html('');$('#add_det').html('');
if(course != null && course != undefined && course !== "" ){
	$('#add_psub').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/addnbranch.php',
		data:{course:course},
		success: function(data){ $('#add_psub').html(data);
	},
		error:function (){}
		}); } else{$('#add_psub').html("");}
}

function admitnosem(course, branch) {
	$('#admit_pbranch').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" ){
	$('#admit_pbranch').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/admitdetails.php',
		data:{course:course, branch:branch},
		success: function(data){ $('#admit_pbranch').html(data);
},
		error:function (){}
		}); } else{$('#admit_pbranch').html("");}
}

function getnosem(course, branch) {
	$('#notes_psem').html('');	$('#notes_pdate').html('');$('#notes_det').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" ){
	$('#notes_pbranch').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/getnsem.php',
		data:{course:course, branch:branch},
		success: function(data){ $('#notes_pbranch').html(data);
},
		error:function (){}
		}); } else{$('#notes_pbranch').html("");}
}

function getaddsem(course, branch) {
	$('#add_psem').html('');	$('#add_pdate').html('');$('#add_det').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" ){
	$('#add_pbranch').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/addnsem.php',
		data:{course:course, branch:branch},
		success: function(data){ $('#add_pbranch').html(data);
},
		error:function (){}
		}); } else{$('#add_pbranch').html("");}
}

function getaddclasss(sem) {
	$('#add_pdate').html('');$('#add_det').html('');
if(sem != null && sem != undefined && sem !== "" ){
	$('#add_psem').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/addnclass.php',
		data:{sem:sem},
		success: function(data){ $('#add_psem').html(data); },
		error:function (){}
		}); } else{$('#add_psem').html("");}
}

function getnoclasss(branch, course, sem) {
	$('#notes_pdate').html('');$('#notes_det').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" && sem != null && sem != undefined && sem !== "" ){
	$('#notes_psem').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/getnclass.php',
		data:{course:course, branch:branch, sem:sem},
		success: function(data){ $('#notes_psem').html(data); },
		error:function (){}
		}); } else{$('#notes_psem').html("");}
}
function getnodate(classs) {
	$('#notes_pclasss').html('');$('#notes_det').html('');
if(classs != null && classs != undefined && classs !== ""){
	$('#notes_pdate').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/getnsub.php',
		data:{classs:classs},
		success: function(data){ $('#notes_pdate').html(data); },
		error:function (){}
		}); } else{$('#notes_pdate').html("");}
}

function getnosubb(sub) {
	if(sub != null && sub != undefined && sub !== ""){
$('#notes_det').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#notes_det').load('m/notes_det.php');
} else{$('#notes_det').html("");}
}
			
//getstudent list
function getstudent(date,sub,time,class_id,batch) {
if(date != null && sub != null  && class_id!= null && date != undefined && sub != undefined  && class_id!= undefined && sub !== "" ){
	$('#hellofbabes').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'studentlist.php',
		data:{date:date, sub:sub, class_id:class_id, att_time:time,stu_batch:batch},
		success: function(data){
			$('#hellofbabes').html(data);
		},
		error:function (){}
		});
}
else{$('#hellofbabes').html("");}

}
function getnotes(sub) {
if(sub != null  && sub != undefined  && sub !== "" ){
	$('#hellofnbabes').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'noteslist.php',
		data:{sub:sub},
		success: function(data){
			$('#hellofnbabes').html(data);
		},
		error:function (){}
		});
}
else{$('#hellofnbabes').html("");}

}

function delaclass(class_id) {
if(class_id != null  && class_id != undefined  && class_id !== "" ){
	var r = confirm("Deleting will un-register all the students of this class and remove all attendance and routines!");
    if (r == true) {    
		$.ajax({
		type:'POST',
		url: 'm/delaclass.php',
		data:{class_id:class_id},
		success: function(data){
			$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_class.php');
		},
		error:function (){}
		});
}}
else{$('#hellofnbabes').html("");}

}

function delnotice(class_id) {
if(class_id != null  && class_id != undefined  && class_id !== "" ){
	var r = confirm("Delete this Notice ?");
    if (r == true) {    
		$.ajax({
		type:'POST',
		url: 'm/delnotice.php',
		data:{class_id:class_id},
		success: function(data){
			$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('notice.php');
		},
		error:function (){}
		});
}}

}


function unregister_stu(roll) {
if(roll != null  && roll != undefined  && roll !== "" ){
	var r = confirm("Un-register "+roll+"?");
    if (r == true) {    
		$.ajax({
		type:'POST',
		url: 'm/delastu.php',
		data:{roll:roll},
		success: function(data){
			$('#fucking_'+roll).css('display','none');
$('#edit_'+roll).modal('toggle'); 
		},
		error:function (){}
		});
}}

}

function del_subject(roll) {
if(roll != null  && roll != undefined  && roll !== "" ){
	var r = confirm("Delete this subject? This will remove attendance and class routine for this subject !");
    if (r == true) {    
		$.ajax({
		type:'POST',
		url: 'm/delasubject.php',
		data:{roll:roll},
		success: function(data){
			$('#fucking_sub_'+roll).css('display','none');
$('#edit_sub_'+roll).modal('toggle'); 
		},
		error:function (){}
		});
}}

}

//att list
function getattlog(date,sub,time,class_id) {
if(date != null && sub != null  && class_id!= null && date != undefined && sub != undefined  && class_id!= undefined && sub !== "" ){
	$('#hellofattlog').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'attloglist.php',
		data:{date:date, sub:sub, class_id:class_id, att_time:time},
		success: function(data){
			$('#hellofattlog').html(data);
			$("#backtobutt").attr("onclick", "gotoattlog(1)");
		},
		error:function (){}
		});
}}

//del list
function delattlog(date,sub,time,class_id) {
if(date != null && sub != null  && class_id!= null && date != undefined && sub != undefined  && class_id!= undefined && sub !== "" ){
	$('#hellofattlog').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'delattloglist.php',
		data:{date:date, sub:sub, class_id:class_id, att_time:time},
		success: function(data){
			$('#hellofattlog').html(data);
			$("#backtobutt").attr("onclick", "gotoattlog(1)");
		},
		error:function (){}
		});
}}
function admin_class_get(class_id) {
	if(class_id!= null && class_id!= undefined && class_id !== "" ){
	$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
		$.ajax({
		type:'POST',
		url: 'admin_class_get.php',
		data:{class_id:class_id},
		success: function(data){
			$('#no').html(data);
		},
		error:function (){}
		});
}}
function admin_sub_get(class_id) {
	if(class_id!= null && class_id!= undefined && class_id !== "" ){
	$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
		$.ajax({
		type:'POST',
		url: 'admin_sub_get.php',
		data:{class_id:class_id},
		success: function(data){
			$('#no').html(data);
		},
		error:function (){}
		});
}}
function admin_rou_get(class_id) {
	if(class_id!= null && class_id!= undefined && class_id !== "" ){
	$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
		$.ajax({
		type:'POST',
		url: 'admin_rou_get.php',
		data:{class_id:class_id},
		success: function(data){
			$('#no').html(data);
		},
		error:function (){}
		});
}}
//sending attendance
 function sendinglist() {
	 $('#buttonofgod').html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
    type:'POST',
    url: 'sendinglist.php',
    data: $("#attendancemagic").serialize(),
    success: function(data){
        $('#hellofbabes').html(data);
    },
    error:function (){}
    });
}
 function notes_up_sub() {
	 $('#notes_upl_btn').css('border', '2px solid #fff !important');
	 $('#notes_upl_btn').css('box-shadow', '0px 0px 6px #000 !important');
   $.ajax({
url: "notes_up_sub.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#notesupload")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#notes_up_sub_submit").html(data);
setTimeout(function(){
$(".trigger").toggleClass("drawn")
}, 10);
}
});
}

 function adminstudetails(roll) {
	 $('#det_update_'+roll).css('border', '2px solid #fff !important');
	 $('#det_update_'+roll).css('box-shadow', '0px 0px 6px #000 !important');
	  $('#det_update_'+roll).html('<i class="fa fa-spinner fa-spin"></i>');
   $.ajax({
url: "m/adminstudetails.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#adminstudetails_"+roll)[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#det_update_msg_"+roll).html(data);
$('#det_update_'+roll).html('Update');
}
});
}

 function updatesubject(roll) {
	 $('#sub_update_'+roll).css('border', '2px solid #fff !important');
	 $('#sub_update_'+roll).css('box-shadow', '0px 0px 6px #000 !important');
	  $('#sub_update_'+roll).html('<i class="fa fa-spinner fa-spin"></i>');
   $.ajax({
url: "m/adminsubupdate.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#updatesub_"+roll)[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#sub_update_msg_"+roll).html(data);
$('#sub_update_'+roll).html('Update');
}
});
}


 function add_up_class() {
	 $('#add_upl_btn').css('border', '2px solid #fff !important');
	 $('#add_upl_btn').css('box-shadow', '0px 0px 6px #000 !important');
   $.ajax({
url: "add_class_sub.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#addclass")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#add_class_m").html(data);
}
});
}

 function add_up_teacher() {
	 $('#admit_tea_btn').css('border', '2px solid #fff !important');
	 $('#admit_tea_btn').css('box-shadow', '0px 0px 6px #000 !important');
   $.ajax({
url: "add_teacher.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#addteacher")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#admit_tea_btnm").html(data);
}
});
}

 function form_up_teacher(roll) {
	 $('#admit_tea_btn'+roll).css('border', '2px solid #fff !important');
	 $('#admit_tea_btn'+roll).css('box-shadow', '0px 0px 6px #000 !important');
   $.ajax({
url: "formedit_teacher.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#form_"+roll)[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#admit_tea_btnm"+roll).html(data);
}
});
}

 function upsendinglist() {
	 $('#buttonofgodupdate').html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
    type:'POST',
    url: 'upsendinglist.php',
    data: $("#attendanceupdate").serialize(),
    success: function(data){
        $('#hellofbabes').html(data);
    },
    error:function (){}
    });
}
 function submitreg() {
	 $('#buttonofreg').html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
    type:'POST',
    url: 'submit_reg.php',
    data: $("#submitreg").serialize(),
    success: function(data){
        $('#regstu_psem').html(data);
		$('#regstu_psem').css('color','#fff');
		$('#regstu_psem').css('font-family','titillium web');
		$('#regstu_psem').css('font-size','18px');
		$('#regstu_psem').css('padding','15px');
		$('#regstu_psem').css('background','#333');
    },
    error:function (){}
    });
}

 function upsendinglistforlog() {
	 $('#buttonofgodupdate').html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
    type:'POST',
    url: 'upsendinglist.php',
    data: $("#attendanceupdate").serialize(),
    success: function(data){
        $('#hellofattlog').html(data);
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

function backtoatt() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('att.php');
}
function backtoadmin_class() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_class.php');
}
function backtoadmin_sub() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_subject.php');
}
function backtoadmin_rou() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_routine.php');
}
function backtostat() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('statistics.php');
}
function backtonotes() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('notes.php');
}
function gotoatt() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('markatt.php');
}

function reg_stu() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('reg_stu.php');
}
function import_excel() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('m/import_excel.php');
}
function backtoreg() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_stu.php');
}

function gotoattstat() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('attstat.php');
}
function gotoyournotes() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('yournotes.php');
}
function gotonotes() {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('viewnotes.php');
}
function gotoattlog(page) {
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('attlog.php?page='+page);
}
function closeupmodal() {
	$('#up_notes').modal('toggle'); 
	setTimeout(function(){
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('notes.php');
}, 1000);
}

function closedownmodal() {
	$('#admit_stu').modal('toggle'); 
	setTimeout(function(){
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_stu.php');
}, 1000);
}
function closedownmodaltea() {
	$('#add_a_tea').modal('toggle'); 
	setTimeout(function(){
$('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
$('#no').load('admin_tea.php');
}, 1000);
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
function delnoteslog(id) {
	var r = confirm("Delete this note ?");
    if (r == true) { 
$.ajax({
type:'POST',
url: 'm/delnoteslog.php',
data:{id:id},
success: function(data){
gotoyournotes();
},
error:function (){}
});
	}
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

function statgetnobranch(course) {
	$('#statnotes_pbranch').html('');$('#getgraph').html('');
$('#statnotes_psem').html('');	 $('#statnotes_pdate').html('');$('#statnotes_det').html('');
if(course != null && course != undefined && course !== "" ){
	$('#statnotes_psub').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/statgetnbranch.php',
		data:{course:course},
		success: function(data){ $('#statnotes_psub').html(data);
	},
		error:function (){}
		}); } else{$('#statnotes_psub').html("");}
}

function regstunobranch(course) {
	$('#regstu_pbranch').html('');
$('#regstu_psem').html('');	 $('#regstu_pdate').html('');$('#regstu_det').html('');
if(course != null && course != undefined && course !== "" ){
	$('#regstu_psub').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/regstubranch.php',
		data:{course:course},
		success: function(data){ $('#regstu_psub').html(data);
	},
		error:function (){}
		}); } else{$('#regstu_psub').html("");}
}

function statgetnosem(course, branch) {
	$('#statnotes_psem').html('');	$('#statnotes_pdate').html('');$('#statnotes_det').html('');$('#getgraph').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" ){
	$('#statnotes_pbranch').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/statgetnsem.php',
		data:{course:course, branch:branch},
		success: function(data){ $('#statnotes_pbranch').html(data);
},
		error:function (){}
		}); } else{$('#statnotes_pbranch').html("");}
}

function regstunosem(course, branch) {
	$('#regstu_psem').html('');	$('#regstu_pdate').html('');$('#regstu_det').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" ){
	$('#regstu_pbranch').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/regstusem.php',
		data:{course:course, branch:branch},
		success: function(data){ $('#regstu_pbranch').html(data);
},
		error:function (){}
		}); } else{$('#regstu_pbranch').html("");}
}

function statgetnoclasss(branch, course, sem) {
	$('#statnotes_pdate').html('');$('#statnotes_det').html('');$('#getgraph').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" && sem != null && sem != undefined && sem !== "" ){
	$('#statnotes_psem').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/statgetnclass.php',
		data:{course:course, branch:branch, sem:sem},
		success: function(data){ $('#statnotes_psem').html(data); getgraphbranch(course,branch,sem); },
		error:function (){}
		}); } else{$('#statnotes_psem').html("");}
}
function regstunoclasss(branch, course, sem) {
	$('#regstu_pdate').html('');$('#regstu_det').html('');
if(course != null && course != undefined && course !== "" && branch != null && branch != undefined && branch !== "" && sem != null && sem != undefined && sem !== "" ){
	$('#regstu_psem').html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
		type:'POST',
		url: 'm/regstuclass.php',
		data:{course:course, branch:branch, sem:sem},
		success: function(data){ $('#regstu_psem').html(data);  },
		error:function (){}
		}); } else{$('#regstu_psem').html("");}
}
function getgraphbranch(course,branch,sem) {
	$('#getgraph').html('');
$('#getgraph').html('<img src=img/loader.gif style="margin-top: 25%;">');
$.ajax({
		type:'POST',
		url: 'm/getgraphbranch.php',
		data:{course:course, branch:branch, sem:sem},
		success: function(data){ $('#getgraph').html(data); },
		error:function (){}
		});
}
function graphday(day,course,branch,sem) {
	$('#getgraph').html('');
$('#getgraph').html('<img src=img/loader.gif style="margin-top: 25%;">');
$.ajax({
		type:'POST',
		url: 'm/getgraphbranch.php',
		data:{day:day, course:course, branch:branch, sem:sem},
		success: function(data){ $('#getgraph').html(data); },
		error:function (){}
		});
}
function graphdate(date,course,branch,sem) {
	$('#getgraph').html('');
$('#getgraph').html('<img src=img/loader.gif style="margin-top: 25%;">');
$.ajax({
		type:'POST',
		url: 'm/getgraphbranch.php',
		data:{datee:date, course:course, branch:branch, sem:sem},
		success: function(data){ $('#getgraph').html(data); },
		error:function (){}
		});
}
function getgraphlist(class_id) {
	if(class_id != null && class_id != undefined && class_id !== ""){
	$('#getgraph').html('');
$('#getgraph').html('<img src=img/loader.gif style="margin-top: 25%;">');
$.ajax({
		type:'POST',
		url: 'm/getgraphlist.php',
		data:{class_id:class_id},
		success: function(data){ $('#getgraph').html(data); },
		error:function (){}
	}); } else {$('#getgraph').html('');}
}
function gotodgraph(roll_id, class_id, att, name) {
	if(roll_id != null && roll_id != undefined && roll_id !== "" && class_id != null && class_id != undefined && class_id !== "" && att != null && att != undefined && att !== "" && name != null && name != undefined && name !== ""){
	$('#getgraph').html('');
$('#getgraph').html('<img src=img/loader.gif style="margin-top: 25%;">');
$.ajax({
		type:'POST',
		url: 'm/thiswasgraph.php',
		data:{roll_id:roll_id, class_id:class_id, att:att, name:name},
		success: function(data){ $('#getgraph').html(data); },
		error:function (){}
	}); } else {$('#getgraph').html('');}
}
function rollchecker() {
$.ajax({
type:'POST',
url: 'm/rollchecker.php',
data:{roll:$('#admit_roll').val()},
success: function(data){
$('#rollchecker').html(data);
},
error:function (){}
});
}

function emailchecker() {
$.ajax({
type:'POST',
url: 'm/emailchecker.php',
data:{email:$('#admit_email').val()},
success: function(data){
$('#emailchecker').html(data);
},
error:function (){}
});
}

 function admit_students_n() {
	 $('#admit_sub_btn').css('border', '2px solid #fff !important');
	 $('#admit_sub_btn').css('box-shadow', '0px 0px 6px #000 !important');
	 $('#admit_sub_btn').val('Please wait...');
   $.ajax({
url: "admit_submit.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#admitstudents")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#admit_sub_btnm").html(data);
 $('#admit_sub_btn').val('Submit');
}
});
}

 function insertsub() {
	 $('#sub_insert').css('border', '2px solid #fff !important');
	 $('#sub_insert').css('box-shadow', '0px 0px 6px #000 !important');
	 $('#sub_insert').val('Please wait...');
   $.ajax({
url: "m/sub_insert.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#insertsub")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#sub_insert_msg").html(data);
 $('#sub_insert').val('Submit');
}
});
}

 function import_submit() {
	 $('#csv_btn').css('border', '2px solid #fff !important');
	 $('#csv_btn').css('box-shadow', '0px 0px 6px #000 !important');
	 $('#csv_btn').val('Please wait...');
   $.ajax({
url: "m/import_csv.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#import_csv")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#imported_data").html(data);
 $('#csv_btn').val('Submit');
  $('#imported_data').css('padding','15px');
}
});
}

 function import_submit_det() {
	 $('#csv_btn-det').css('border', '2px solid #fff !important');
	 $('#csv_btn-det').css('box-shadow', '0px 0px 6px #000 !important');
	 $('#csv_btn-det').val('Please wait...');
   $.ajax({
url: "m/up_import_csv.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#import_csv_det")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#imported_data").html(data);
  $('#imported_data').css('padding','15px');
}
});
}


 function insertrou() {
	 $('#sub_rou').css('border', '2px solid #fff !important');
	 $('#sub_rou').css('box-shadow', '0px 0px 6px #000 !important');
	 $('#sub_rou').val('Please wait...');
   $.ajax({
url: "m/sub_rou.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#insertrou")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#sub_rou_msg").html(data);
 $('#sub_rou').val('Submit');
}
});
}

 function lol_notice() {
	 $('#lol_notice').val('Please wait...');
   $.ajax({
url: "m/add_notice.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData($("#lol_notice")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$("#lol_notice").html(data);
}
});
}

function del_fucker(id) {
	if(id != null && id != undefined && id !== ""){
		var r = confirm("Delete this Student ? This can't be undone !");
    if (r == true) {  
$.ajax({
		type:'POST',
		url: 'm/del_fucker.php',
		data:{id:id},
		success: function(data){ $('#family_'+id).css('display','none'); },
		error:function (){}
	}); }}
}
function closemodalsub(id) {
  $('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
      $.ajax({
    type:'POST',
    url: 'admin_sub_get.php',
    data: {class_id:id},
    success: function(data){
        $('#no').html(data);
    },
    error:function (){}
    });
}
function closemodalrou(id) {
  $('#no').html('<img src=img/loader.gif style="margin-top: 25%;">');
      $.ajax({
    type:'POST',
    url: 'admin_rou_get.php',
    data: {class_id:id},
    success: function(data){
        $('#no').html(data);
    },
    error:function (){}
    });
}