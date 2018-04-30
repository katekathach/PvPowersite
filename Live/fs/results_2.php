<?php
include('process.php');
require_once('includes/header.php');

if($_SESSION["user_id"] == -1)
{
   $loggedIn = false;
   
   $warningMessage  = "Please note that since you are not logged in, ";
   $warningMessage .= "you are unable to save project information or purchase your system online. ";
   $warningMessage .= "<a href='#' class='popLogin'>Sign In or Create an Account</a>.";
   
   if(!isset($warnings))
      $warnings = array($warningMessage);
   else
      $warnings[] = $warningMessage;
	 //echo "false";
}
else
{
   $loggedIn = true;
   //echo "true";   
}
?>
<script type="text/javascript">
$(function(){
$("#tabs").tabs();
});

$(function(){
var systemLengthft;
systemLengthft = '<?php echo $sysLengthft; ?>'
if(systemLengthft >= 1200){
//alert("Rails need to be custom cut");
}
console.log('rail length ' + Math.floor(systemLengthft) + ' ft');

//rails 
var system = '<?php echo $sys?>'
var systemlength = '<?php echo $sysLength ?>'
var railcount = '<?php echo $railCount ?>'
var railcut = (systemlength / railcount) * 4 ;

console.log("rail count " +  railcount + " rail cut" + " " + Math.ceil(railcut)  + " mm");
});
</script>
<!--Results-->

<div class="row">
<div class="form container"> 
      <div class="system-header">
		<h1><img src="img/fs-icon.png" class="no-margin"> FS System</h1>
		<p class="sub-head">Create a 2V FS System: build a parts list, view drawings, and purchase.</p>
      </div>
      
	<div id="resultsData">
    	<div id="tabs">
			
			<?php 
            if($_SESSION["user_id"] == -1){?>
            <div class='alert alert-error '>Purchase your system online by signing in or create an account. Click add to basket below to proceed.
            <script>
            $(function(){
                $('a.openLogin').click(function(){openLoginWindow();});
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
            </div>
            <?php }?>
		
        <div class="row">
        <div class="col-sm-8 section">
			<ul>
         		<li><a href='#tabs-1'>Parts</a></li>
		 		<li><a href='#tabs-2'>Calculations</a></li>
         		<li><a href='#tabs-3'>Documentation</a></li>
			</ul>
        </div>
        </div>
<div class='ui-tabs-panel' id='tabs-1'>
<?php 
if($sysLengthft >= 1200){
echo "<p class='custom'>Rails need to be custom cut</p>";
}
?>
<?php 

//lowest Rail variations 
//$center =  $lowestRailLenCut[0];
//$IntermediateRailRow = $lowestRailLenCut[1];
//$IntermediateRailCut = $lowestRailLenCut[2];
//$EndRailRow = $lowestRailLenCut[3];
//$EndRailCut = $lowestRailLenCut[4];
//$RailColumnTF = $lowestRailLenCut[5];
//echo $center;
?>
<h2>Rails Location and Cuts</h2>
<table class="parts-list">
<tr>
<th>Location</th>
<th>Rails Row</th>
<th>Cut</th>
<th>Rail Length</th>
<th>Total</th>
</tr>
<tr><td>Center</td>
<td><?php  if($RailColumnTF == "true" || $support == 2){echo $centerrowcount = 1;}else{echo $centerrowcount = 0;};?></td><td>&commat;</td>
<td><?php if($support == 2 && $sysLength <= $stockLen){ echo $sysLength; }else{echo round($center,-1);} ?></td>
<td><?php  if($RailColumnTF == "false" || $support == 2){echo 0;}else{ $centerTotal = 1 * $center;echo $roundcenter = round($centerTotal,-1);}?></td>
</tr>
<tr>
<td>Intermediate</td>
<td><?php if($support == 2 && $sysLength > $stockLen){echo $IntermediateRailRow;}elseif($support ==2 && $sysLength <= $stockLen){echo 0;}else{echo $IntermediateRailRow ;} ?></td><td>&commat;</td>
<td><?php if($support == 2 && $sysLength <= $stockLen){echo 0;}else{echo $roundIntercut = round($IntermediateRailCut,-1);}?></td>
<td><?php if($support == 2 && $sysLength > $stockLen){echo 1;}elseif($support ==2 && $sysLength <= $stockLen){echo 0;}else{echo $IntermRowTotal = $IntermediateRailRow * $roundIntercut; } ?></td>
</tr>
<tr><td>End</td><td><?php if($support == 2 || $RailColumnTF == "false"){echo 0;}else{echo $EndRailRow;}?></td><td>&commat;</td><td><?php echo $roundendcut= round($EndRailCut,-1);?></td><td><?php if($support == 2 ||$RailColumnTF == "false"){echo 0;}else{ echo $EndRowTotal = $EndRailRow * $roundendcut;  }?></td></tr>

</table>
<p><strong>Total Rail Length: </strong><?php $totalRailLen =   $centerTotal + $IntermRowTotal + $EndRowTotal ; echo round($totalRailLen,-1)?></p>
<p><strong>Total Rails Row: </strong><?php echo $rrowtotal;//echo  $centerrowcount + $IntermediateRailRow + $EndRailRow; ?></p>
<?php $totalRailRow = $centerrowcount + $IntermediateRailRow + $EndRailRow;?>

<?php

?>

<h2>Parts List</h2>
<table id="parts" class="parts-list">
   <tr>
      <th>Part No.</th>
      <th>Item Name</th>
      <th class="Qty">Qty.</th>
 
   </tr>
   
<?php
//echo $type_of_rack;
//echo $tilt;
//echo $module_cell;
echo "<tr>";
echo "<td class='product-code'>124303-06200</td>";
echo "<td>S 1.5 Rail </td>";
echo "<td class='qty'>".$railCount."</td>";
echo "</tr>";

echo "<tr>";

  //echo  "<td class='product-code'>".$triangleItem."</td>";
  // echo "<td>Standard FS Triangle ".$tilt." degrees</td>";
  //echo  "<td class='qty'>".$supportTriCount."</td>";

  if($type_of_rack == 'concrete-pillar' && $tilt == 15 && $module_cell == 60) {
	     echo "<td class='product-code'>140004-001</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }else if($type_of_rack == 'rammed-post' && $tilt == 15 && $module_cell == 60){ 
	     echo "<td class='product-code'>140003-001</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }else if($type_of_rack == 'concrete-pillar' && $tilt == 20 && $module_cell == 60){
	  	 echo "<td class='product-code'>140004-002</td>";
	  	 echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }else if($type_of_rack == 'rammed-post' && $tilt == 20 && $module_cell == 60){
		 echo "<td class='product-code'>140003-002</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }else if($type_of_rack == 'concrete-pillar' && $tilt == 25 && $module_cell == 60){
		 echo "<td class='product-code'>140004-003</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";	  
	  }else if($type_of_rack == 'rammed-post' && $tilt == 25 && $module_cell == 60){
		 echo "<td class='product-code'>140003-003</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";	
		 echo " <td class='qty'>".$supportTriCount."</td>";  
	  }else if($type_of_rack == 'concrete-pillar' && $tilt == 30 && $module_cell == 60){
		 echo "<td class='product-code'>140004-004</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }else if($type_of_rack == 'rammed-post' && $tilt == 30 && $module_cell == 60){
		 echo "<td class='product-code'>140003-004</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }else if($type_of_rack == 'rammed-post' && $tilt == 35 && $module_cell == 60){
		 echo "<td class='product-code'>140003-005</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>"; 
	  }elseif($type_of_rack == 'concrete-pillar' && $tilt == 35 && $module_cell == 60){
		 echo "<td class='product-code'>140004-005</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }else if($type_of_rack == 'rammed-post' && $tilt == 20 && $module_cell == 72){
		 echo "<td class='product-code'>140003-006</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }elseif($type_of_rack == 'concrete-pillar' && $tilt == 20 && $module_cell == 72){
		 echo "<td class='product-code'>140004-006</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }elseif($type_of_rack == 'concrete-pillar' && $tilt == 25 && $module_cell == 72){
		 echo "<td class='product-code'>140003-007</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }elseif($type_of_rack == 'concrete-pillar' && $tilt == 25 && $module_cell == 72){
		 echo "<td class='product-code'>140004-007</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }elseif($type_of_rack == 'rammed-post' && $tilt == 25 && $module_cell == 72){
		   echo "<td class='product-code'>140003-008</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }elseif($type_of_rack == 'rammed-post' && $tilt == 30 && $module_cell == 72){
		 echo "<td class='product-code'>140003-008</td>";
	     echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }elseif($type_of_rack == 'concrete-pillar' && $tilt == 30 && $module_cell == 72){
		 echo "<td class='product-code'>140004-008</td>";
	     echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
		 echo "<td class='qty'>".$supportTriCount."</td>";
	  }
      echo "</tr>"; 

if ($spliceCountTotal > 0){ //Don't display row if array is small and doesn't need splices
echo "   <tr>";
   echo "      <td class='product-code'>129303-000</td>";
   echo "      <td>S 1.5 Splice Kit</td>";
   echo "      <td class='qty'>".$spliceCountTotal."</td>"; 
   
echo "</tr>";
};

/******************** End & Mid Clamp list *****************************/
echo "<tr >";
   echo "      <td class='product-code'>".$endClamp['item_number']."</td>";
   echo "      <td>". $endClamp['description']."</td>";
   echo "      <td class='qty'>".$endclampqty."</td>";  
echo "</tr>";

echo "<tr >";
   echo "<td class='product-code'>".$middleClamp['item_number']."</td>";
   echo "<td>". $middleClamp['description']."</td>";
   echo "<td class='qty'>".$middleClampqty."</td>";   
echo "</tr>";

if($module_thickness == 6.8 || $module_thickness == 8){
echo "<tr>";
echo "<td class='product-code'>".$laminatehook['item_number']."</td>";
echo "<td>".$laminatehook['description']."</td>";
echo "<td class='qty'>".$laminatehookqty."</td>";
echo"</tr>";
}
?>
</table>

<script type="application/javascript">  
var parts = [];
//get the current quantity
//$('#parts td.qty').each(function(){currentqty.push($(this).html());});

/***************add to basket ***********************/
function addtoBasket(){
	console.log("add basket call");
//get current current qty push to array of parts. 
$('#parts > tbody > tr ').each(function() {
    var cellText = $(this).find('td.product-code').html(); 
	var qtyText = $(this).find('td.qty').html(); 
	console.log("item number" + cellText + "qty " +  qtyText);
	parts.push({'Category_Code' : 11, 'Product_Code' : cellText, 'Quantity' : qtyText});

});
}

//console.log(parts);
 $(document).ready(function() {
      <?php if($loggedIn) { ?>
	 $('#addPartsBtn').removeAttr('disabled');
      var store_url = window.location.protocol + '//' + document.domain + '/mm5/merchant.mvc?Screen=BASK'
      var done = false;
      $('#basket-add').submit(function() {
		 parts.length = 0;
		 addtoBasket();
         $.each(parts, function(index, part) {
            part.Action = 'ADPR';
            part.Store_Code = 'S';
            $.ajax({
               type: 'POST',
               url: store_url,
               data: part,
               async: false,
               beforeSend: function (request)
               { 
                 request.setRequestHeader('Accept','text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
               },
			  success: function(msg) {
       		 
    		},
   			 error: function(msg) {
        	
    		},
			complete: function(msg){
			 done = true;
			
			}
            });
         });
        console.log(parts);
		var store = store_url;
 		if(done && window.chrome){
			window.location = store;
		}
		else{
		window.open(store).focus();
        window.blur();	
	 	}
         return false;
      }); 
      <?php } else { ?>
		$('#addPartsBtn').addClass('disabled');
        $('#addPartsBtn').click( function(event) {
        // alert('Because you are not logged in, this feature is not available.');
		//openLoginWindow();
		
         event.preventDefault();
      });
      <?php } ?>
  

   });
</script>
<div id="dialogmsg" title="login to add to basket" style="display:none">
<iframe src="http://secure.schletter.us/mm5/merchant.mvc?Store_Code=S&Screen=LOGN"></iframe>
</div>

<p class="overageNote">No overage is provided. Add items to basket, then modify quantities.</p>

<form id="basket-add">
   <div class="right" >
   <input class="action-button<?php if(!$loggedIn) echo " disabled"; ?>" type="submit" id="addPartsBtn" value="Add to Basket" />
   </div>
</form>

</div>
<div class='ui-tabs-panel' id="tabs-2">
<h2>Calculations</h2>
<h3>Project Summary</h3>
<table class="parts-list" style='margin-left:auto;margin-right:auto; padding:20px;'>
   <tr>
      <th>Description</th>
      <th>Value</th>
      <th>Units</th>
   </tr>
   
<?php

echo "   <tr>";
   echo "      <td>Module Type</td>";
   echo "      <td>". $module_cell." cell</td>";
   echo "      <td></td>";
echo "</tr>";

echo "   <tr>";
   echo "      <td>Module Width</td>";
   echo "      <td>".$moduleWidth."</td>";
   echo "      <td>mm</td>";
echo "</tr>";

echo "   <tr>";
   echo "      <td>Type of Rack</td>";
   echo "      <td>";
   if($type_of_rack == 'rammed-post'){echo "Rammed";}else{echo "Foundation";};
   echo "</td>";
   echo "      <td></td>";
echo "</tr>";

echo "   <tr>";
   echo "      <td>Size of Rack</td>";
   echo "      <td>2V x ".$moduleCount."</td>";
   echo "      <td></td>";
echo "</tr>";
echo "   <tr>";
   echo "      <td>Tilt</td>";
   echo "      <td>".$tilt."</td>";
   echo "      <td>degrees</td>";
echo "</tr>";
echo "   <tr>";
   echo "      <td>Code Version</td>";
   echo "      <td>".$codeVersion."</td>";
   echo "      <td></td>";
echo "</tr>\n";

echo "   <tr>";
   echo "      <td>Wind</td>";
   echo "      <td>".$wind."</td>";
   echo "      <td>mph</td>";
echo "</tr>";

echo "   <tr>";
   echo "      <td>Ground Snow</td>";
  	echo "      <td>".$snow."</td>";
	echo "      <td>psf</td>";
echo "</tr>";

echo " <tr>";
   echo "      <td>System Length</td>";
   echo "      <td>".round(($sysLengthIn / 12), 2)."</td>";
   echo "      <td>feet</td>";
echo "</tr>";

?>
</table>


<?php echo "<br>"; ?>
<h3>Installation Details</h3>
<table class="parts-list" style='margin-left:auto;margin-right:auto; padding:20px;'>

<tr>
      <th>Max Span</th>
      <th>Tension</th>
      <th>Lateral</th>
      <th>Shaft depth</th>
     <!--<th>Rebar</th>-->
</tr>
<?php  

if( $codeVersion == 'ASCE7-10'){
foreach ($code_7_10  as $load => $key){
echo '<tr>';
if($key['max_span'] == 0){echo '<td>'. 0 .' ft</td>';}else{echo '<td>'. $key['max_span'].' ft</td>';}
echo '<td>'.$key['tension_force'].' kip</td>';
echo '<td>'.$key['shear_force'].'</td>';
if($type_of_rack == "ram_post"){echo "<td>*Geotechnical Testing Required</td>";}else{echo '<td>'.$key['drilled_shaft_depth'].' ft</td>';}
//if($key['star_item'] == 1){echo '<td>require</td>';}else{echo '<td>none</td>';}
echo '</tr>';

$_SESSION['fsmax_span'] = $key['max_span'];
$_SESSION['fstension_force'] = $key['tension_force'];
$_SESSION['fslateral_force'] = $key['shear_force'];
$_SESSION['fsdrilled_shaft_depth'] = $key['drilled_shaft_depth'];
//$_SESSION['fsstar_item'] = $key['star_item'];
 
}
}else if( $codeVersion == 'ASCE7-05'){

foreach ($code_7_05  as $load => $key){
echo '<tr>';
if($key['max_span'] == 0){echo '<td>'. 0 .' ft</td>';}else{echo '<td>'. $key['max_span'].' ft</td>';}
echo '<td>'.$key['tension_force'].' kip</td>';
echo '<td>'.$key['shear_force'].'</td>';
if($type_of_rack == "ram_post"){echo "<td>*Geotechnical Testing Required</td>";}else{echo '<td>'.$key['drilled_shaft_depth'].' ft</td>';}
//if($key['star_item'] == 1){echo '<td>require</td>';}else{echo '<td>none</td>';}
echo '</tr>';
} 

$_SESSION['fsmax_span'] = $key['max_span'];
$_SESSION['fstension_force'] = $key['tension_force'];
$_SESSION['fslateral_force'] = $key['shear_force'];
$_SESSION['fsdrilled_shaft_depth'] = $key['drilled_shaft_depth'];
//$_SESSION['fsstar_item'] = $key['star_item'];
}

?>
</table>
<?php 

if($type_of_rack == "ram_post"){echo "<p>&lowast; Geotechnical services are required for rammed post systems. Please contact a sales representative to discuss pricing and scheduling.</p>";}

?>

<?php
// check the star item

if( $codeVersion == 'ASCE7-10'){
foreach ($code_7_10  as $load => $key){
//if($key['star_item'] == 1){
	//echo "<h3>Rebar required per support</h3>";
    //echo '(6) #6 VERTICAL REBAR #3 TIEBAR @ 12" O.C. ALL REBAR 3" CLEAR (SEE DRAWINGS)';
//}
} 
}else if( $codeVersion == 'ASCE7-05'){
foreach ($code_7_05  as $load => $key){
//if($key['star_item'] == 1){
	//echo "<h3>Rebar required per support</h3>";
    //echo '(6) #6 VERTICAL REBAR #3 TIEBAR @ 12" O.C. ALL REBAR 3" CLEAR (SEE DRAWINGS)';
	//}
} 
}

?>   
</div>
<div class='ui-tabs-panel' id="tabs-3">
<h2>Documentation</h2>
<button class='action-button' id="pdf" name="cover-sheet"><span class=' glyphicon glyphicon-file'></span>Download Engineering Letter and All Drawings &raquo;</button>
<form  id="summary" target="_blank" method="post" action="pdf.php?pdf">
<p>Fill out the form below to download all docs plus an engineering letter for permitting purposes.</p>
<label for="cname">Client Name:</label>	<input type="text" name="cname"/>
<label for="project-address">Project Address</label>	<input type="text" name="projectaddress"/>
<label for="city">City</label>	<input type="text" name="city"/>
<label for="states">State</label>	
<select id="state" name='states' >
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select>				
<label for="zipcode">Zip code</label>	<input type="number" name="zipcode"/>
<label for="email">Email</label>        <input type="email" name="email"/>
<label>Schletter Sales Associate:</label>
<select id="sales" name='sales'>
<option value="New Customer">New Customer</option>	
<option value="Blaz Ruzic">Blaz Ruzic</option>	
<option value="Christian Savaia">Christian Savaia</option>	
<option value="Fernando Figueroa">Fernando Figueroa</option>	
<option value="Gene Bertsche">Gene Bertsche</option>	
<option value="Jim Fay">Jim Fay</option>	
<option value="Jorge Luque">Jorge Luque</option>	
<option value="Joshua Parmentier">Joshua Parmentier</option>	
<option value="Justin Smith">Justin Smith</option>	
<option value="Michael Mularski">Michael Mularski</option>	
<option value="Saul Soto">Saul Soto</option>	
<option value="Other">Other</option>
</select>
<input type="submit" value="Submit" class='action-button' />
</form>

<script type="text/javascript">
// Returns structural acceptance letter link for selected state
$(document).ready(function(){
$('select[name=state]').change(function(){
var state = $('select[name="state"]').val();
$('#letter-link').html("<h2>PDFs</h2><a class='pdf-icon' href='files/" + state + ".pdf'>" + state + " Structural Acceptance Letter &raquo;</a><br/><br/>" + 
"<a class='pdf-icon' href='files/PvMax-60cell-standard-drawings.pdf'>PvMax Drawings &raquo;</a><br/><br/>" + 
"<a class='pdf-icon' href='http://www.schletter.us/support/PvMax-Install-Manual.pdf'>PvMax Installation Manual &raquo;</a>")
}
)
});

</script>  
<script type="text/javascript">
$(function(){
	
$("#basket-add, #addPartsBtn").click(function(e) {
	
    e.preventDefault();
});	


$('#pdf').on('click', function(){
//$('#summary').show('fast');	
$('#summary').toggle('fast' , function(){
});
	});	
});

$(document).ready(function () {
jQuery.validator.setDefaults({
debug: true,
email: true,
success: "valid",
required: "Required field."
});
$( "#summary" ).validate({
	onkeyup: false, //don't validate on each keyup (only onclick, onsubmit, onfocusout)
rules: {
	cname:{
	required: true
	},
    projectaddress: {
  required: true,
   },
	city: {
	required: true,
	
  },
  state:{
	required:true,	  
},
   zipcode: {
   required: true,
  
},
email :{
	required:true,
},

},  submitHandler: function (form) {
 form.submit(); } });
});
</script>
</div>
</div></div></div></div>

<?php
	$_SESSION['fstype_of_rack'] 	   =      $type_of_rack;
	$_SESSION['fsrailCount']           =      $railCount;	
	$_SESSION['fstriangleItem']        =      $triangleItem;
	$_SESSION['fsSupportTriCount']     =      $supportTriCount;
	$_SESSION['fsSpliceCount']         = 	  $spliceCountTotal;
	$_SESSION['fsEndClampitemnum']     =      $endClamp['item_number'];
	$_SESSION['fsEndClampdesc']        =      $endClamp['description'];
	$_SESSION['fsEndClampqty']         =      $endclampqty;
	$_SESSION['fsMiddleClampitemnum']  =   	  $middleClamp['item_number'];
	$_SESSION['fsMiddleClampdesc']     =      $middleClamp['description'];
	$_SESSION['fsMiddleClampqty']      =      $middleClampqty;
	$_SESSION['fsLaminateHookdesc']    =      $laminatehook['description'];	
	$_SESSION['fsLaminateHookItemNum'] =      $laminatehook['item_number'];	
	$_SESSION['fsLaminateHookqty'] 	   =      $laminatehookqty;
	$_SESSION['fsSystemlength']    	   =      $sysLengthIn;
	$_SESSION['stocklen'] 			   = 	  $stockLen;
	$_SESSION['sysLength'] 			   = 	  $sysLength;
	$_SESSION['support']			   = 	  $support;	  
	//session variable for pdf
	$_SESSION['centerCount']    	   = 	  $centerrowcount;
	$_SESSION['center']         	   =      $center;
	$_SESSION['IntermRailRow']  	   =      $IntermediateRailRow;
	$_SESSION['IntermRailCut']  	   = 	  $IntermediateRailCut;
	$_SESSION['EndRailRow']     	   = 	  $EndRailRow;
	$_SESSION['EndRailCut']     	   = 	  $EndRailCut;
	$_SESSION['RailColumnTF']  	   	   = 	  $RailColumnTF;
	$_SESSION['totalRailLen']          = 	  $totalRailLen;
	$_SESSION['totalRailRow']          = 	  $totalRailRow;
	$_SESSION['IntermRowtotal']        = 	  $IntermRowTotal;
	$_SESSION['roundendcut'] 	       = 	  $roundendcut;
	$_SESSION['roundIntercut']         = 	  $roundIntercut;
	$_SESSION['roundcenter']           = 	  $roundcenter;
	$_SESSION['centertotal']		   = 	  $centerTotal;
	$_SESSION['endrowtotal'] 		   = 	  $EndRowTotal;
	
	//var_dump($_SESSION);
?>
<?php
 require_once('includes/footer.php');
?>

<script type="text/javascript">
var span = '<?php echo $span; ?>';
var support = '<?php echo $support; ?>';
var checkarr = '<?php echo json_encode($checkArr)?>';
$(document).ready(function(){
$.each(checkarr, function(index, value){
		console.log("INDEX: " + index + " VALUE: " + value);
	});
});
console.log("span " + span + " , " + " support "  + support );
</script>