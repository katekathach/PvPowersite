<?php
//ini_set('display_errors',1);
require_once('includes/session.php');
session_start();
$warningMessage = "";   
if($_SESSION["user_id"] == -1)
   {
      $warningMessage .= "<a href='#' class='popLogin navbar-link '>Sign in or Create an account</a>.";
      if(isset($warnings))
         $warnings[] = $warningMessage;
      else
         $warnings = array($warningMessage);
   }else{
   	    //echo $_SESSION["user_id"];
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

require_once './vendor/autoload.php';


use Schletter\GroundMount\FormData;

$formData = new FormData();
$windSpeeds = $formData->getWindSpeeds();
$snowLoads = $formData->getSnowLoads();
$tilts = $formData->getTilts();

if (isset($_POST['calculate-submit']) && $_POST['calculate-submit']) {
    
    foreach($_POST as $name => $value) {
        $_SESSION[$name] = $value;
    }
    
    $requiredFields = array('moduleWidth', 'cellType', 'moduleThickness', 'tilt', 'codeVersion', 'seismic', 'wind', 'snow');
    
    $errors = array();
    foreach ($requiredFields as $field) {
        if(!isset($_POST[$field]) || "" === $_POST[$field]) {
            $errors[] = "Please specify a valid ".strtolower(join(preg_split('/(?=[A-Z])/', $field), " "))." value.";
        }
    }
    if (!empty($_POST['moduleWidth']) && ($_POST['moduleWidth'] < 970 || $_POST['moduleWidth'] > 1050)) {
        $errors[] = "Please enter a module width between 970 and 1050mm.";
    }
    $cellTypes = array(60, 75);
    if (!empty($_POST['cellType']) && (!in_array($_POST['cellType'], $cellTypes))) {
        $errors[] = "Please enter a valid cell type.";
    } 
    $moduleThicknesses = array(6.8, 8);
    for ($i = 30; $i <= 50; $i++) {
        $moduleThicknesses[] = $i;
    }
    if (!empty($_POST['moduleThickness']) && (!in_array($_POST['moduleThickness'], $moduleThicknesses))) {
        $errors[] = "Please enter a valid module thickness.";
    }
    
    if (!empty($_POST['tilt']) && (!in_array($_POST['tilt'], $tilts))) {
        $errors[] = "Please enter a valid tilt.";
    }
    
    if (!empty($_POST['moduleColumns']) && ($_POST['moduleColumns'] < 1 || $_POST['moduleColumns'] > 40)) {
        $errors[] = "Please enter between 1 and 40 module columns.";
    }
    
    $codeVersions = array(5, 10);
    if (!empty($_POST['codeVersion']) && (!in_array($_POST['codeVersion'], $codeVersions))) {
        $errors[] = "Please enter a valid code.";
    }

    if (!empty($_POST['seismic']) && ($_POST['seismic'] !== "0" && $_POST['seismic'] !== "1")) {
        $errors[] = "Please enter a valid seismic value.";
    }
    
    if (!empty($_POST['wind']) && isset($windSpeeds[$_POST['wind']]) && !in_array('code-version-'.$_POST['codeVersion'], $windSpeeds[$_POST['wind']])) {
        $errors[] = "Please enter a valid wind value.";
    }
    
    if (!empty($_POST['snow']) && (!in_array($_POST['snow'], $snowLoads))) {
        $errors[] = "Please enter a valid snow load.";
    }
    
    if (!empty($_POST['numberRacks']) && ($_POST['numberRacks'] < 1 || $_POST['numberRacks'] > 40)) {
        $errors[] = "Please enter between 1 and 40 racks.";
    }
    
    if (empty($errors)) {
        die(header('Location: results.php'));
    }
}

require_once 'includes/header.php';

// echo '<pre>'.print_r($_SESSION, true).'</pre>';

?>
<div class="row">
<div class="form container">
	<input type="hidden" name="userid"  value='<?php echo $_SESSION['user_id'] ;?>' >
<?php if($_SESSION["user_id"] == -1){ $showProject = false; }else{$showProject = true; ?>
<? }?>
      <!--<div id='header'> removed for styling. if ID is not needed for any Javascript, delete! -->
      <div class="system-header">
      <h1>
      <img src="img/pvmini-icon.png" class="no-margin">
      PvMini</h1>
		<p class="sub-head">Create a PvMini System: build a parts list, view drawings, and purchase.</p>
      </div>

    <?php if(isset($errors) && !empty($errors)): ?>
        <div class='alert alert-error'>
            <?php echo implode("<br />", $errors) ?>
        </div>
    <?php endif ?>
      
<form action="index.php" method="post" id="projectform" data-persist="garlic">
<div class="row section">

			
    <div class="col-sm-3">
		<div class="row">
			<label>Project Information</label>
		<div class="col-sm-12 form-field">
            <input type="text" placeholder="Project Name" name="projectname" id="projectname" 
              value="<?php //echo isset($_SESSION['projectname']) ? $_SESSION['projectname'] : '' ?>"
            >
        </div>
		<div class="col-sm-12 form-field">
            <input type="text" placeholder="Project Address" name="projectaddress" id="projectaddress" 
              value="<?php //echo isset($_SESSION['projectaddress']) ? $_SESSION['projectaddress'] : '' ?>"
            >
        </div>
        <div class="col-sm-12 form-field">
            <input type="text" placeholder="Project Zip Code" id="projzip" name="projzip" 
              value="<?php //echo isset($_SESSION['projzip']) ? $_SESSION['projzip'] : '' ?>"
            >
        </div>
        <div class="col-sm-12 form-field">
            <input type="hidden" placeholder="City" name="City" id="City" 
              value="<?php //echo isset($_SESSION['City']) ? $_SESSION['City'] : '' ?>"
            >
        </div>
         <div class="col-sm-12 form-field">
            <input type="hidden" placeholder="State " name="State" id="State"
              value="<?php //echo isset($_SESSION['State']) ? $_SESSION['State'] : '' ?>"
            >
        </div>
   	</div>
</div>
    
<div class="col-sm-3">
    <div class="row">
	<label>Module Data</label>
    
      <div id="cellval" class="col-sm-12 form-field ">
         <select id="cellType" name="cellType" required aria-required="true">
            <option value="60" <?php echo (isset($_SESSION['cellType']) && 60 == $_SESSION['cellType']) ? 'selected' : '' ?>>60 cell</option>

        </select>
      </div>
        
		<div class="col-sm-12 ff-less-padding ">
        <input type="number" name="moduleWidth" maxlength="4" min="970" max="1050" required aria-required="true" placeholder="Module Width (mm)" class="input-text modulewidth" id="moduleWidth" 
           value="<?php //echo isset($_SESSION['moduleWidth']) ? $_SESSION['moduleWidth'] : '' ?>"
        >
            <br/><span class="description">970 - 1050 mm</span>
        </div>
        
		<div class="col-sm-12 ff-less-padding ">
        <input type="number"  required name="moduleThickness" placeholder="Module Thickness (mm)" class="input-text modulethickness" id="moduleThickness" 
           value="<?php //echo isset($_SESSION['moduleThickness']) ? $_SESSION['moduleThickness'] : '' ?>"
        >
            <br/><span class="description">6.8, 8 or 30-50 mm</span>
		</div>
	</div>
</div>

<div class="col-sm-3">
    <div class="row">
    <label>Rack Preferences</label>
        <div class="col-sm-12 form-field">
            <select id="tilt" name="tilt" autocomplete="off" required>
                <option value="">Tilt Angle</option>
                <?php foreach($tilts as $tilt): ?>
                    <option value="<?php echo $tilt ?>" <?php echo (isset($_SESSION['tilt']) && $tilt == $_SESSION['tilt']) ? 'selected' : '' ?>><?php echo $tilt ?>&deg;</option>
                <?php endforeach ?>
            </select>
        </div>
   
        <div class="col-sm-12 ff-less-padding ">
            <input type="number" required min="1"  max="40" id="moduleColumns" name="moduleColumns" placeholder="Number of Module Columns" class="input-text"
                value="<?php //echo isset($_SESSION['moduleColumns']) ? $_SESSION['moduleColumns'] : '' ?>"
            > 
            <br/><span class="description">Max = 40</span>
        </div>
    </div>
</div>
 
<div class="col-sm-3">
	<div class="row">
    <label>Site Details</label>
    	<div class="col-sm-12 form-field ">
        <select id="codeVersion" name="codeVersion" autocomplete="off" required>
            <option value="">Building Code</option>
            <option value="5" <?php echo (isset($_SESSION['codeVersion']) && 5 == $_SESSION['codeVersion']) ? 'selected' : '' ?>>ASCE 7-05 (2003, 2006, 2009 IBC)</option>
            <option value="10" <?php echo (isset($_SESSION['codeVersion']) && 10 == $_SESSION['codeVersion']) ? 'selected' : '' ?>>ASCE 7-10 (2012, 2015 IBC)</option>
        </select>
      </div>

        <div class="col-sm-12 form-field">
            <select id="seismic" name="seismic" autocomplete="off" required>
                <option value="">Include Seismic Design?</option>
                <option value="1" <?php echo (isset($_SESSION['seismic']) && 1 == $_SESSION['seismic']) ? 'selected' : '' ?>>Yes, include</option>
                <option value="0" <?php echo (isset($_SESSION['seismic']) && 0 == $_SESSION['seismic']) ? 'selected' : '' ?>>No seismic</option>
            </select>
        </div>

        <div class="col-sm-12 form-field">
            <select id="wind" name="wind" autocomplete="off" required>
                <option value="">Maximum Wind Load</option>
                <?php foreach($windSpeeds as $wind => $codes): ?>
                    <option value="<?php echo $wind ?>" class="<?php echo implode(' ', $codes) ?>"
                        <?php echo (isset($_SESSION['wind']) && $wind == $_SESSION['wind']) ? 'selected' : '' ?>
                    >
                        <?php echo $wind ?> mph
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="col-sm-12 ff-less-padding">
            <select id="snow" name="snow" autocomplete="off" required>
                <option value="">Maximum Snow Load</option>
                <?php foreach ($snowLoads as $snowLoad): ?>
                    <option value="<?php echo $snowLoad ?>" <?php echo (isset($_SESSION['snow']) && $snowLoad == $_SESSION['snow']) ? 'selected' : '' ?>>
                        <?php echo $snowLoad ?> psf
                    </option>
                <?php endforeach ?>
            </select>
        </div>    
	</div>
</div>
</div>

<div class="row col-margin-top">
		<div class="col-sm-3">
    	
        	
		<?php if($_SESSION["user_id"] == -1){ $showPoject = false;}else{$showProject = true;?>
		<!--<input type="submit" class="action-button savedprojects" value="Show Projects"/>-->
		<button id="savedprojects" class='action-button btn' type="button">Show Projects</button>
			<table class="datatable" id="table_projects">
        	
        	<tbody>
        	</tbody>
     		</table>
			
	    <?php	}?>
        	
        
    </div>
    <div class="col-sm-3 col-sm-offset-3">
    	
    	<div class="row">
    		
        	<div class="col-sm-12 form-field">
                <input type="number" id="numberRacks" name="numberRacks" placeholder="Quantity of Racks" class="input-text" required min="1" max="40"
                    value="<?php //echo isset($_SESSION['numberRacks']) ? $_SESSION['numberRacks'] : '' ?>"
                > 
                <br><span class="description">1 - 40</span>
            </div>
    	</div>
    </div>
     <div class="col-xs-3">
    	  <div id="message_container">
      	  <div id="message" class="success">
          
          </div>
          </div>
        <div class="row">
        	 <div class="col-xs-5">
            	<?php if($_SESSION["user_id"] == -1){ $showPoject = false;}else{$showProject = true;?>
				<!--<button class='action-button savedprojects projects col-sm-3'>Show Projects</button>';-->
				<button class="btn action-save" type="button " value="save" id="saveProjectBtn">
 <i class="glyphicon glyphicon-floppy-disk glyphicon-globe pull-left"></i>Save</button>
				
				<!--<span class="glyphicon glyphicon-floppy-disk"></span>-->
		<?php }?>
                  
                    <button type="btn btn-info" class="glyphicon glyphicon-refresh update glyphicon-globe " id="update"  value="" style="display: none" /></button>
                    <input type="hidden" class="update_id" id="update_id"  value=""/>
  			</div>
            <div class="col-xs-7 form-field">
             <input class="action-button" type="submit" value="Calculate Parts" name="calculate-submit" id="calculate-submit" />
            <br/><span class="description"><a id="dialog-button">Project Assumptions</a></span>
            </div>
     
        </div>
    </div> 
</div>
  </div> 
  
       
 <div class="modal fade" id="projectAssump" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Project Assumptions</h4>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
      	<div class="row">
  <p><strong>For complete project details, view the <a href="files/">FS Standard drawing &raquo;</a></strong></p>
  <div class="col-sm-4">
    <h3>DESIGN CRITERIA:</h3>
   <ul>
 <li>2003, 2006, 2009 (ASCE 7-05) & 2012 (ASCE 7-10) EDITIONS OF
THE INTERNATIONAL BUILDING CODE, WITH LOCAL AMENDMENTS</li>
  </ul> 
  </div>
    <div class="col-sm-4">
      <h3>LOADS:</h3>
      	<ul>
  <li>MODULE DEAD LOAD = MAXIMUM 3.6 PSF, MINIMUM 1.75 PSF</li>
  <li>SNOW LOAD = SEE TABLE FOR SPECIFIC SNOW LOAD (Is = 1.00, Ct= 1.20, Ce = 0.90, Cs = SEE TABLE)</li>
  </ul>
  </div>
  <div class="col-sm-4">
        <h3>WIND DESIGN:</h3>
        	<ul>
  <li>BASIC WIND SPEED = SEE TABLE FOR SPECIFIC WIND SPEED</li>
  <li>EXPOSURE: C</li>
  <li>RISK CATEGORY = II (ASCE 7-10)</li>
  <li>Iw = 1.0 (ASCE 7-05)</li>
  </ul>
  </div>
  <div class="col-sm-5">
<h3>ARRAY:</h3>
<ul>
<li>ARRAY LENGTH NOT TO EXCEED 150 FT</li>
<li>MODULES MUST BE CENTERED ON ARRAY</li>
</ul>
</div>

<div class="col-sm-5">
<h3>MODULE:</h3>
<ul>  
<li>RACKING SYSTEM DESIGNED FOR MODULE SIZE: MINIMUM = 1550 X 970 mm, MAXIMUM = 1700 X 1050 mm</li>
<li>VERTICAL MODULE GAP: 23 mm</li>
<li>HORIZONTAL MODULE GAP: 5 mm</li>
<li>ORIENTATION: PORTRAIT (2V)</li>

</ul>
</div>
<div class="col-sm-10">
<h3>CONCRETE:</h3>
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
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
//debug: true,
success: "valid",
required: "Required field."
});

$( "#projectform" ).validate({
   errorPlacement: function(error,element) {
      console.debug(element.attr('id'));
      return true;
 },
	success: function(label) {
    //label.addClass("valid").text("Ok!")
    label.remove();
    return true;
  },
	onkeyup: false, //don't validate on each keyup (only onclick, onsubmit, onfocusout)
	rules: {
      orientation:{
      required:true
      },
      modulewidth: {
      required: true,
      range: [970, 1050],
      number:true
      },
      moduleheight: {
      required: true,
      range: [1550, 1700],
      number:true
      },
      moduleCount:{
      required:true,
      number:true
      },
      moduleClampLocation:{
      required:true,
      number:true
      },
      splicePercentage:{
      required:true,
      number:true
      },
      maxRail:{
      required:true,
      number:true
      },
      minRail:{
      required:true,
      number:true
      },
      codeversion:{
      required:true
      },
      span: {
      required: true,
      range: [6, 48],
      number:true
      },
      tolerance:{
      required:true,
      number:true
      },
      projectaddress:{
      required:true	
      },
      projzip:{
      required:true	
      },
      projectname:{
      required:true	
      },
   }
});
	  
});
</script>
<script>
$(document).ready(function(){
	// get zipcode googel api
function getZip(zip){
	
	var states = ["AL", "AZ", "CA", "CT","CO", "DE" , "FL" , "GA" , "MD","MA", "ME" ,"MN" ,"MI" , "NC" , "NE" , "NH" , "NJ" , "NM", "NY" ,"OH", "PA" , "SC" , "TX" , "UT" , "VT", "WA" , "WI"];
	
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
</script>

<?php
require_once 'includes/footer.php';
?>
