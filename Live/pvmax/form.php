<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once('includes/session.php');
    $warningMessage = "";
if($_SESSION["user_id"] == -1)
   {
   // echo "warning" . $warnings;
   // echo $_SESSION["user_id"];
     // $warningMessage  = "No account is needed, however to save or purchase ";
      //$warningMessage .= "a project ";
      $warningMessage .= "<a href='#' class='popLogin navbar-link '>Sign in or Create an account</a>.";
      if(isset($warnings))
         $warnings[] = $warningMessage;
      else
         $warnings = array($warningMessage);
   }else{

   }
if(isset($_GET["timeout"]))
{
      $warningMessage  = "Your previous session expired.  ";
      $warningMessage .= "begin a new project by filling out the form below.";
      if(isset($warnings))
         $warnings[] = $warningMessage;
      else
         $warnings = array($warningMessage);

}

require_once('includes/header.php');
 //error_reporting(E_ALL);
?>
<script>
   $(function(){
                $('.navbar-link').click(function(){openLoginWindow();});
            });

            function openLoginWindow(){
               var margin  = 100;
               var wWidth  = parseInt(screen.availWidth - (margin*2));
               var wHeight = parseInt(screen.availHeight - (margin*2));
               loginWindow = window.open('login.php','','width='+wWidth+',height='+wHeight+',top='+margin+',left='+margin+',scrollbars=no,toolbar=no,status=no');
               loginWindow.title = "Login";
            }

            function closeLoginWindow()
            {
               loginWindow.close();
               document.location.reload(true);
            }
$(function(){

$('select[name=cell]').change(function(){
	var cell = $('select[name=cell]').val();
	var codeversion = $('select[name=codeversion]').val();
	if ((cell == '72') ){
	var option = '<option value="85">85 mph</option><option value="90">90 mph</option><option value="110">110 mph</option><option value="130">130 mph</option>';
	var tilt =  '<option value="">Tilt Angle</option><option value="20">20&deg;</option><option value="25">25&deg;</option><option value="30">30&deg;</option>';
	}else{
	var tilt =  '<option value="">Tilt Angle</option><option value="15">15&deg;</option><option value="20">20&deg;</option><option value="25">25&deg;</option><option value="30">30&deg;</option><option value="35">35&deg;</option>';
	}

	$('#wind-value').html(option);
	$('#tilt').html(tilt);
})
});


//script for showing seismic option for 72 cell
$(function(){
	//$('.seismic').hide();
	//$('select[name=cell]').change(function(){
	//	var cell = $('select[name=cell]').val();
	////	if($(this).val() == 60 || $(this).val() == 72){
		//	$('.seismic').show();
	//		}else{ $('.seismic').hide();}
 // }).triggerHandler('change');
});
</script>



<div class="row">
<div class="form container">
            <input type="hidden" name="userid"  value='<?php echo $_SESSION['user_id'] ;?>' >
<?php if($_SESSION["user_id"] == -1){ $showProject = false; }else{$showProject = true; ?>
<? }?>
      <!--<div id='header'> removed for styling. if ID is not needed for any Javascript, delete! -->
      <div class="system-header">
		<h1><img src="img/pvmax-icon.png" class="no-margin"> PvMax System</h1>
		<p class="sub-head">Create a 2V PvMax System: build a parts list, view drawings, and purchase.</p>
      </div>

<div class="row section">

<form action="results.php" method="post" id="projectform" >
	<div class="col-sm-3">
	<div class="row">
	<label>Project Information</label>
		<div class="col-sm-12 form-field">
            <input type="text" placeholder="Project Name" name="projectname">
        </div>
		<div class="col-sm-12 form-field">
            <input type="text" placeholder="Project Address" name="projectaddress">
        </div>
        <div class="col-sm-12 form-field">
            <input type="number" placeholder="Project Zipcode"  id="projzip" name="projzip">
        </div>
        <div class="col-sm-12 form-field">
            <input type="hidden" placeholder="City " name="City">
        </div>
         <div class="col-sm-12 form-field">
            <input type="hidden" placeholder="State " name="State">
        </div>
   	</div>
	</div>
    <div class="col-sm-3">
    <div class="row">

    <label>Module Data</label>
       <div  id="cellval" class="col-sm-12 form-field ">
		  <select id="cell" name="cell" required>
            <option value="">Cell Type</option>
            <option value="60">60 cell</option>
            <option value="72">72 cell</option>
          </select>
        </div>

		<div class="col-sm-12 ff-less-padding ">
        <input type="number"  required name="modulewidth"   maxlength="4" min="970"  max="1050"  placeholder="Module Width (mm)" class="input-text modulewidth" id="modulewidth"/> <br/><span class="description">970 - 1050 mm</span>
		</div>

      <div class="col-sm-12 ff-less-padding ">
		<input type="number" required id="modulethickness" name="modulethickness" placeholder="Module Thickness (mm)" class="input-text" /> <br/><span class="description">6.8, 8 or 30-50 mm</span>
	 </div>

	</div>


	<!--<div id="comment" class="error"></div>-->
    <!--<div class="seismic "> not needed for new styling-->

</div>

<div class="col-sm-3">
	<div class="row">
	<label>Rack Preferences</label>
        <div  class="col-sm-12 form-field ">
        <select id="tilt" name="tilt" required>
            <option value="">Tilt Angle</option>
            <option value="15">15&deg;</option>
            <option value="20">20&deg;</option>
            <option value="25">25&deg;</option>
            <option value="30">30&deg;</option>
            <option value="35">35&deg;</option>
		</select>
        </div>

        <div class="col-sm-12 ff-less-padding modulecount">
            <input type="number" required name="modulecount" placeholder="Number of Module Columns" min="0"  max="46"class="input-text" maxlength="3"/> <br/><span class="description">Max = 46</span>
        </div>
	</div>
</div>

<div class="col-sm-3">
	<div class="row">
    <label>Site Details</label>
    	<div class="col-sm-12 form-field ">
        <select  id="codeversion" name="codeversion" autocomplete="off" required>
            <option value="">Building Code</option>
            <option value="ASCE7-10"> ASCE 7-10  (2012, 2015 IBC)</option>
            <option value="ASCE7-05"> ASCE 7-05 (2003, 2006, 2009 IBC)</option>
        </select>
</div>

          <div class="col-sm-12 form-field seismic">
    	<select id="seismic" name="seismic" required>
            <option value="">Include Seismic Design?</option>
            <option value="seismic">Yes, include</option>
            <option value="non-seismic">No seismic</option>
        </select>
   		</div>

		<div class="col-sm-12 form-field windvalue">
       	<select name="windvalue" id="wind-value" >
            <option value="">Maximum Wind Load</option>
            <?php if(isset($_SESSION['pvmaxwind']	)){echo "<option value=".$_SESSION['pvmaxwind'].">".$_SESSION['pvmaxwind']." mph </option>";}?>
            <!--<option value="110">110 mph</option><option value="115">115 mph</option>
            <option value="140">140 mph</option><option value="160">160 mph</option>-->
       	</select>
     	</div>

        <div class="col-sm-12 form-field snow">
       	<select name="snow" id="snow" >
            <option value="">Maximum Snow Load</option>
            <?php if(isset($_SESSION['pvmaxsnow']	)){echo "<option value=".$_SESSION['pvmaxsnow'].">".$_SESSION['pvmaxsnow']." psf </option>";}?>
            <!--<option value="0">0 psf</option> <option value="20">20 psf</option>  <option value="40">40 psf</option>  <option value="50">50 psf</option>
            <option value="60">60 psf</option> -->
  	   	</select>
        </div>
	</div>
</div>
</div>

<div class="row col-margin-top">
    <div class="colsm-3">
        <div class="">
            <div class="col-sm-3">
        <?php if($_SESSION["user_id"] == -1){ $showPoject = false;}else{$showProject = true;?>
        <!--<input type="submit" class="action-button savedprojects" value="Show Projects"/>-->
        <button id="savedprojects" class='action-button btn' type="button">Show Projects</button>
            <table class="datatable" id="table_projects">

            <tbody>
            </tbody>
            </table>

        <?php   }?>
            </div>
        </div>
    </div>

     <div class="col-sm-3 col-sm-offset-3">
        <div class="row">
            <div class="col-sm-12 form-field">
            <input type="number" name="racksqty" placeholder="Quantity of Racks" class="input-text" /> <br/><span class="description">1 - 40</span>
            </div>
        </div>
    </div>

     <div class="col-xs-3">
          <div id="message_container">
          <div id="message" class="success">
          <p>This is a success message.</p>
          </div>
          </div>
        <div class="row">
             <div class="col-xs-5">
                <?php if($_SESSION["user_id"] == -1){ $showPoject = false;}else{$showProject = true;?>
                <!--<button class='action-button savedprojects projects col-sm-3'>Show Projects</button>';-->
                <button class="action-save btn" type="button" value="save" id="saveProjectBtn">
 <i class="glyphicon glyphicon-floppy-disk glyphicon-globe pull-left"></i>Save</button>

                <!--<span class="glyphicon glyphicon-floppy-disk"></span>-->
        <?php }?>

                    <button type="btn btn-info" class="glyphicon glyphicon-refresh update glyphicon-globe " id="update"  value="" style="display: none" /></button>
                    <input type="hidden" class="update_id" id="update_id"  value=""/>
            </div>

<!--<article>
    <h1>We&rsquo;ll be back soon!</h1>
    <div>
        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. If you need to you can always <a href="mailto:#">contact us</a>, otherwise we&rsquo;ll be back online shortly!</p>
        <p>&mdash; The Team</p>
    </div>
</article>-->
            <div class="col-xs-7 form-field">
           <input class="action-button btn" type="submit" value="Calculate Parts" name="flat-roof-submit" id="flat-roof-submit" />
            <br/><span class="description"><a id="dialog-button">Project Assumptions</a></span>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
$(function(){
	//$("#wind-value").prop("disabled", true);
	//$('#wind-value').empty();
	var cell,code,tilt,codetemp,seistemp;
	$(document).on('change', '#projectform', function(){
	//$("#wind-value").prop("disabled", false);
	 console.log('after all callbacks');
});

function ajaxcall(cell , code , tilt, seis){
	 $.ajax({
      type: "POST",
      url: "windsnow.php",
      data: {c : cell , co : code, t : tilt, s : seis},
	  dataType: "json",
      success: function( response ) {
        console.log( JSON.stringify(response) + " success");
		var data = JSON.stringify(response);
		 $.each($.parseJSON(data), function(index, obj) {
			if(obj.wind){
			$('#wind-value').append("<option value='" + obj.wind + " '> " + obj.wind +  " mph"  +  "</option>");
			}else{
			$('#snow').append("<option value='" + obj.ground_snow + " '> " + obj.ground_snow +  " psf"  +  "</option>");
			console.log(obj.ground_snow);
			}//console.log(data.ground_snow);
        });
	  },
	  fail: function(response){
	  console.log("fail");
	  }
    });
}

$('#cell, #tilt, #codeversion ,#seismic').change( function(){
    var cell = $("#cell").val();
	var code = $("#codeversion").val();
	var tilt = $("#tilt").val();
	var seis = $( "#seismic option:selected").val();
	if(code == "ASCE7-05"){codetemp = "05";}else{ codetemp = "10";}
	if(seis == "seismic"){seistemp = "_seis";}else{seistemp = "";}
	console.log("cell:" + cell + " " + "code:" + codetemp + " " + "tilt:" + tilt + " " + "seis:" + seis );
	$('#wind-value').empty();
	$('#snow').empty();
	$('#wind-value').html("<option value=''>Maximum Wind Load</option>")
	$('#snow').html("<option value=''>Maximum Snow Load</option>")
	if(cell != "" && code != "" && tilt != ""){
		//$('#wind-value').empty();
		ajaxcall(cell , codetemp , tilt, seistemp);
	}
});

});
</script>

  </div>

  <!--<div id="dialog" title="Project Assumptions" style="display:none;">
  <p><strong>For complete project details, view the <a href="files/">FS Standard drawing &raquo;</a></strong></p>
  <div style="width:340px; float:left; margin-right:40px;">
    <strong>DESIGN CRITERIA:</strong><ul>
  <li>2003, 2006, 2009 (ASCE 7-05) & 2012 (ASCE 7-10) EDITIONS OF
THE INTERNATIONAL BUILDING CODE, WITH LOCAL AMENDMENTS</li>
  </ul>
      <strong>LOADS:</strong><ul>
  <li>MODULE DEAD LOAD = MAXIMUM 3.6 PSF, MINIMUM 1.75 PSF</li>
  <li>SNOW LOAD = SEE TABLE FOR SPECIFIC SNOW LOAD (Is = 1.00, Ct= 1.20, Ce = 0.90, Cs = SEE TABLE)</li>
  </ul>

        <strong>WIND DESIGN:</strong><ul>
  <li>BASIC WIND SPEED = SEE TABLE FOR SPECIFIC WIND SPEED</li>
  <li>EXPOSURE: C</li>
  <li>RISK CATEGORY = II (ASCE 7-10)</li>
  <li>Iw = 1.0 (ASCE 7-05)</li>
  </ul>
<strong>ARRAY:</strong><ul>
<li>ARRAY LENGTH NOT TO EXCEED 150 FT</li>
<li>MODULES MUST BE CENTERED ON ARRAY</li>
</ul>
</div>
<div style="width:340px; float:left">
<strong>MODULE:</strong>
<ul>
<li>RACKING SYSTEM DESIGNED FOR MODULE SIZE: MINIMUM = 1550 X 970 mm, MAXIMUM = 1700 X 1050 mm</li>
<li>VERTICAL MODULE GAP: 23 mm</li>
<li>HORIZONTAL MODULE GAP: 5 mm</li>
<li>ORIENTATION: PORTRAIT (2V)</li>

</ul>

<strong>CONCRETE:</strong>
<ul>
<li>1. ALL CONCRETE WORK SHALL CONFORM WITH THE REQUIREMENTS OF ACI 301 AND ACI 318.
CEMENT PER ASTM C150, TYPE II. AGGREGATE PER ASTM C33. CONCRETE SHALL BE READY
MIXED IN ACCORDANCE WITH ASTM C94 AND SHALL BE DESIGNED FOR A MINIMUM 28 DAY
COMPRESSIVE STRENGTH AS FOLLOWS:
FOUNDATIONS..................3,000 PSI*
*DESIGNED FOR 2,500 PSI</li>
<li>2. FIBER REINFORCEMENT USED IN CONCRETE SHALL BE BASF MASTERFIBER MAC 100 OR
EQUIVALENT. THE AMOUNT TO BE MIXED IN CONCRETE IS 3LB/CU.YD</li>

</ul>


  </div>
  </div>-->
</form>
 </div>
 </div>
 </div>




<script>
$(function() {$( "#dialog-button" ).click(function(){
$( "#dialog" ).dialog({
modal: true,
width:800,
height:600
});
});
});
</script>
<script>
//just for the demos, avoids form submit
$(document).ready(function () {

jQuery.validator.setDefaults({
debug: true,
success: "valid",
required: "Required field."
});

$( "#projectform " ).validate({
	errorPlacement: function(error,element) {
    return true;
 },
	success: function(label) {

    label.remove();
  },
	onkeyup: false, //don't validate on each keyup (only onclick, onsubmit, onfocusout)
rules: {
	span: {
	required: true,
	range: [6, 48]
	},
	modulewidth: {
	required: true,
	range: [970, 1050]
	},
	cell:{
	required: true
	},
	foundation:{
	required: true
	},
	modulecount:{
	required:true
	},
	tilt:{
	required:true
	},
	codeversion:{
	required:true
	},
	windvalue:{
	required:true
	},
	snow:{
	required:true
	},
	modulethickness:{
	required:true
	},
	seismic:{
	required:true
	},
	projectaddress:{
	required:true
	},
	projzip:{
	required:true,
	number:true,
	maxlength: 5
	},
	projectname:{
	required:true
	},
},  submitHandler: function (form) {
	var modulethickness = $("#modulethickness").val();
   if( (modulethickness != 6.8 && modulethickness != 8) && !(modulethickness >= 30 && modulethickness <=50)){
   		alert("Please Enter a valid module thickness.");
	
	return false;
   }
       else form.submit(); } });

});
</script>
<script>
$(document).ready(function(){
		// get zipcode googel api
function getZip(zip){
		var states = ["AL", "AZ", "CA", "CO", "CT","DE" , "FL" , "GA" , "MD", "MA" ,"ME" , "MI" , "NC" , "MN" , "NE" , "NH" , "NJ" , "NM", "NY" ,"OH", "PA" , "SC" , "TX" , "UT" , "VT", "WA" , "WI" ];
	//console.log(projzip.val());
	//var zipAPI = "http://ziptasticapi.com/"+zip.val()+"";
	var zipGoogleAPI = "http://maps.googleapis.com/maps/api/geocode/json?address="+zip.val()+"&region=us&sensor=false";

	if(zip.val().length === 5  && $.isNumeric(zip.val())){
	$.ajax({
  	url: zipGoogleAPI ,
  	cache: false,
  	success: function(data,success){

  	var stateinfo = data;
 	var city = stateinfo.results[0].address_components[1].short_name;
  	//var state = stateinfo.results[0].address_components[3].short_name;
  	var lat = stateinfo.results[0].geometry.location.lat;
  	var lng = stateinfo.results[0].geometry.location.lng;
  	var state;
  	//$( stateinfo.result[0]. ).each(function() {
    //console.log($( this ).address_component.types);

  	 for (var i = 0; i < stateinfo.results[0].address_components.length; i++) {
  	 	 if(stateinfo.results[0].address_components[i].types[0] == "administrative_area_level_1"){
  	 	 	 state = stateinfo.results[0].address_components[i].short_name;
  	 	 	console.log(state);
  	 	 }
  	 			//console.log(stateinfo.results[0].address_components[i].types);
		}
  	if( states.indexOf(state) > -1){
  	}else{
  	alert("For this state, please send design to your Schletter sales representative who will obtain a stamped engineering letter. We apologize for the inconvenience.")
  	}

  	console.log("the data" +  lat + lng);
  	console.log ("state is " + state);
 	console.log (" city is " + city);
    $("input[name='City']").val(city);
    $("input[name='State']").val(state);
  	$("input[name='lat']").val(lat);
	$("input[name='lng']").val(lng);

	}

	});

	}
}


$("input[name='projzip']").on('keyup',function(){

	var zip = $(this);
	$("input[name=spacingzip]").val(zip.val())
	if(zip.length){
		//alert("yes");
	}
	console.log(zip.val());
    getZip(zip);

});
})


</script>
 <?php

require_once('includes/footer.php');

?>
