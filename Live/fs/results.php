<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
//$(function(){
//$("#tabs").tabs();
//});

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
<div role="tabpanel" class="row section">


			<ul class="nav nav-tabs" role="tablist">
         		<li role="presentation" class="active"><a href='#parts-list' aria-controls="parts-list" role="tab" data-toggle="tab">Parts List</a></li>
		 		<li role="presentation"><a href='#calcs' aria-controls="calcs" role="tab" data-toggle="tab">Calculations</a></li>
         		<li role="presentation"><a href='#docs' aria-controls="docs" role="tab" data-toggle="tab">Documentation</a></li>
			</ul>


    <div class="tab-content">
		<div role="tabpanel" class='tab-pane active' id='parts-list'>
        <div class="row">
    	<div class="col-sm-7">
        	<div class="row">
            	<div class="col-sm-12">
                <table id="parts" class="parts-list">
                   <tr>
                      <th>Part No.</th>
                      <th>Item Name</th>
                      <th class="Qty">Qty.</th>

                   </tr>

                <?php
             		//echo "<pre>",print_r($bestresults["stockRailQuantity"][6200],1),"</pre>";
                	//echo $bestresults["railsShipping"];
                if($bestresults["stockRailQuantity"][4200] != 0 ){
                		//echo $bestresults["stockRailQuantity"][6200] ;
                		//echo $bestresults["stockRailQuantity"][4200] ;
				echo "<tr>";
                echo "<td class='product-code'>124303-06200</td>";
                echo "<td>S1.5 Rail 6200 mm</td>";
                echo "<td class='qty'>".$bestresults["stockRailQuantity"][6200]."</td>";
                echo "</tr>";

				echo "<tr>";
                echo "<td class='product-code'>124303-04200</td>";
                echo "<td>S1.5 Rail 4200 mm</td>";
                echo "<td class='qty'>".$bestresults["stockRailQuantity"][4200]."</td>";
                echo "</tr>";

                }else{
                	   echo "<tr>";
               		   echo "<td class='product-code'>124303-06200</td>";
               		   echo "<td>S1.5  Rail 6200 mm</td>";
                       echo "<td class='qty'>".$bestresults["railsShipping"]."</td>";
                	   echo "</tr>";
                }

               // echo "<tr>";
               // echo "<td class='product-code'>124303-06200</td>";
               // echo "<td>S 1.5 Rail</td>";
               // echo "<td class='qty'>".$bestresults["railsShipping"]."</td>";
                //echo "</tr>";

                echo "<tr>";

                  //echo  "<td class='product-code'>".$triangleItem."</td>";
                  // echo "<td>Standard FS Triangle ".$tilt." degrees</td>";
                  //echo  "<td class='qty'>".$supportTriCount."</td>";

                  $tempTri="";
                  if($type_of_rack == 'concrete-pillar' && $tilt == 15 && $module_cell == 60) {
                  	     $tempTri = "140004-001";
                         echo "<td class='product-code'>140004-001</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'rammed-post' && $tilt == 15 && $module_cell == 60){
                      	$tempTri = "140003-001";
                         echo "<td class='product-code'>140003-001</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'concrete-pillar' && $tilt == 20 && $module_cell == 60){
                      	$tempTri = "140004-002";
                         echo "<td class='product-code'>140004-002</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'rammed-post' && $tilt == 20 && $module_cell == 60){
                      	$tempTri = "140003-002";
                         echo "<td class='product-code'>140003-002</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'concrete-pillar' && $tilt == 25 && $module_cell == 60){
                      	$tempTri = "140004-003";
                         echo "<td class='product-code'>140004-003</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'rammed-post' && $tilt == 25 && $module_cell == 60){
                      	$tempTri = "140003-003";
                         echo "<td class='product-code'>140003-003</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo " <td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'concrete-pillar' && $tilt == 30 && $module_cell == 60){
                      	$tempTri = "140004-004";
                         echo "<td class='product-code'>140004-004</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'rammed-post' && $tilt == 30 && $module_cell == 60){
                      	$tempTri = "140003-004";
                         echo "<td class='product-code'>140003-004</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'rammed-post' && $tilt == 35 && $module_cell == 60){
                      	$tempTri = "140003-005";
                         echo "<td class='product-code'>140003-005</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }elseif($type_of_rack == 'concrete-pillar' && $tilt == 35 && $module_cell == 60){
                      	$tempTri = "140004-005";
                         echo "<td class='product-code'>140004-005</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }else if($type_of_rack == 'rammed-post' && $tilt == 20 && $module_cell == 72){
                      	$tempTri = "140003-006";
                         echo "<td class='product-code'>140003-006</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }elseif($type_of_rack == 'concrete-pillar' && $tilt == 20 && $module_cell == 72){
                      	$tempTri = "140004-006";
                         echo "<td class='product-code'>140004-006</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";

                      }elseif($type_of_rack == 'concrete-pillar' && $tilt == 25 && $module_cell == 72){
                      	$tempTri = "140004-007";
                         echo "<td class='product-code'>140004-007</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }elseif($type_of_rack == 'rammed-post' && $tilt == 25 && $module_cell == 72){
                      	$tempTri = "140003-008";
                           echo "<td class='product-code'>140003-008</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }elseif($type_of_rack == 'rammed-post' && $tilt == 30 && $module_cell == 72){
                      	$tempTri = "140003-008";
                         echo "<td class='product-code'>140003-008</td>";
                         echo "<td>Standard FS Ram Post ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }elseif($type_of_rack == 'concrete-pillar' && $tilt == 30 && $module_cell == 72){
                      	$tempTri = "140004-008";
                         echo "<td class='product-code'>140004-008</td>";
                         echo "<td>Standard FS Foundation ".$tilt." degrees</td>";
                         echo "<td class='qty'>".$supportTriCount."</td>";
                      }
                      echo "</tr>";
                      echo "</tr>";

                if ($spliceCountTotal > 0 || $spliceCountTotal >  4){ //Don't display row if array is small and doesn't need splices
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
                <span class="description">No overage is provided. Add items to basket, then modify quantities.</span>

                </div>
            </div>
        </div>


    	<div class="col-sm-5">
        	<div class="row">
            	<div class="col-sm-12">
				<?php
                if($sysLengthft >= 1200){
                echo "<p class='custom'>Rails need to be custom cut</p>";
                }
                ?>

   <table class="parts-list">
    <tr>
     <th>Location</th>
     <th>Rails Row</th>
     <th>Cut</th>
     <th>Rail Length</th>
     <th>Total</th>
</tr>
<tr><td>Center</td>
<td><?php
//if($RailColumnTF  || $support == 2){
	// echo $bestresults["centerRailCount"];
//}else{
	 	echo $bestresults["centerRailCount"];
//};
?>
</td>

<td>&commat;</td>
<td>
<?php
echo round($bestresults["centerRailLength"],-1);
/*if($sysLength <= $stockLen){
echo $sysLength;
}elseif($support == 2 && $sysLength > $stockLen){
echo round($onespanrail[0],-1);
}else if( $support == 2 && $sysLength <= $stockLen){
echo $sysLength;
}else if($RailColumnTF  || $support == 2){
echo round($center,-1);}else{ echo 0;}*/
?>
</td>

<td>
<?php
if($sysLength <= $stockLen){
echo $sysLength * $bestresults["centerRailCount"];
}elseif($support == 2 && $sysLength > $stockLen){
echo round($onespanrail[0],-1) * $bestresults["centerRailCount"];
}else if( $support == 2 && $sysLength <= $stockLen){
echo $sysLength * $bestresults["centerRailCount"];
}else if($RailColumnTF  || $support == 2){
echo round($center,-1) * $bestresults["centerRailCount"];}else{echo  0;}
?>
</td>

</tr>
<tr>
<td>Intermediate</td>
<td><?php
echo $bestresults["intermediateRailCount"];
/*if($support == 2 && $sysLength > $stockLen){
	echo 1;}elseif($support ==2 && $sysLength <= $stockLen){
	echo $IntermediateRailRow = 0;}else{echo $IntermediateRailRow ;
	} */
?></td>
<td>&commat;</td>

<td>
<?php
 if($IntermediateRailRow == 0 ){echo 0;}else if($support == 2 && $sysLength > $stockLen){
echo round($onespanrail[1],-1);
}else{
echo round($bestresults["intermediateRailLength"],-1);
}
?>
</td>

<td>
<?php
if($support == 2 && $sysLength > $stockLen){
echo round($onespanrail[1],-1);
}else{
echo $bestresults["intermediateRailCount"] *  round($bestresults["intermediateRailLength"],-1);

}

/*if($sysLength <= $stockLen){
	echo 0;
}else if($support == 2 && $sysLength > $stockLen){
	echo round($onespanrail[1],-1) ;
}elseif($support == 2 && $sysLength<= $stockLen){
	echo 0;
}else{
 echo $roundIntercut = round($IntermediateRailCut,-1) * $IntermediateRailRow;
}*/
  ?>
</td>
</tr>

<tr>
<td>End</td>
<td>
<?php
/*if($support == 2 || $RailColumnTF ){echo 0;
}else{echo $EndRailRow;}*/
echo $bestresults["endRailCount"];
?>
</td>
<td>&commat;</td>
<td>
<?php if($sysLength<= $stockLen){echo 0 ;}elseif($support == 2){echo 0;}else{echo $roundendcut= round($bestresults["endRailLength"],-1);}?>
</td>
<td>
<?php if($support == 2 && $RailColumnTF == "false"){
echo 0;
}else{
echo $EndRowTotal = $bestresults["endRailCount"] * round($bestresults["endRailLength"],-1);
}
?>
</td>
</tr>

</table>

 <?php
//echo $simpleCutDesc;$coversheet .= '<p>'.   $_SESSION['fscutdesc'] .'</p>';
$tempDesc = "";
echo "<p>";
foreach ($bestresults["instructions"]as $key => $value) {
	echo  $value . "<br>";
}
echo "</p>";

 ?>

<!--<p><strong>Total Rail Length: </strong>-->
<?php $totalRailLen =   $roundcenter + $IntermRowTotal + $EndRowTotal ;  round($totalRailLen,-1)?>
<!--</p>-->
<!--<p><strong>Total Rails Row: </strong>-->
<?php   $centerrowcount + $IntermediateRailRow + $EndRailRow; ?>
<!--</p>-->
<?php  $totalRailRow = $centerrowcount + $IntermediateRailRow + $EndRailRow;

?>
 <?php
 ?>
        </div>
        </div>
        </div>
        </div>

<div class="row col-margin-top">
    	<div class="col-sm-7">
        	<div class="row">
            	<div class="col-sm-12">

			<?php
            if($_SESSION["user_id"] == -1){?>
            <div class='alert alert-error'>
            <!--<p>Place your order online; sign in or create a Schletter store account and then click the <em>Add to Basket</em> button to the right.</p> use this when add to basket is enabled-->
           <!-- <p>We're sorry, the <em>add to basket</em> feature is not currently available in the beta release of PV Powersite.</p>-->
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

                </div>
            </div>
        </div>




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
	parts.push({'Category_Code' : 'STAND', 'Product_Code' : cellText, 'Quantity' : qtyText});

});
}

function pdf(){

	      $.ajax({
               type: 'POST',
               url: "pdf.php?pdf",
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
}
//console.log(parts);
 $(document).ready(function() {
      <?php if($loggedIn) { ?>

	 $('#addPartsBtn').removeAttr('disabled');
     $('#addPartsBtn').removeClass( 'disabled' );
      var store_url = window.location.protocol + '//' + document.domain + '/mm5/merchant.mvc?Screen=BASK'
      var done = false;
      $('#basket-add').submit(function() {
      	// $(".loading").show();
		 parts.length = 0;
		 addtoBasket();
		 pdf();
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
                 $(".loading").html('<img class="loadImg" src="img/ajax-loader.gif" >');
               },
			  success: function(msg) {
       		    	//$(".loading").hide();
    		},
   			 error: function(msg) {

    		},
			complete: function(msg){
				   //	$(".loading").hide();
				   $(".loading").html();
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
		//$('div#addPartsBtn').addClass('disabled');
        $('input#addPartsBtn').click( function(event) {
         console.log('open login window');
        //alert('Because you are not logged in, this feature is not available.');
		    openLoginWindow();
		   event.preventDefault();
      });
      <?php } ?>



   });
</script>
      <div id="dialogmsg" title="login to add to basket" style="display:none">
            <iframe src="http://secure.schletter.us/mm5/merchant.mvc?Store_Code=S&Screen=LOGN"></iframe>
      </div>

            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-12 form-field">

                    <form id="basket-add">
                    	<div class="loading" style="display: none"></div>
                       <input class="action-button<?php if(!$loggedIn) echo " disabled"; ?>" type="submit" id="addPartsBtn" value="Add to Basket" />
                    </form>
                    </div>
                </div>
            </div>
        </div>
        </div>


		<div role="tabpanel" class='tab-pane' id='calcs'>
        <div class="row">
    	<div class="col-sm-7">
        	<div class="row">
            	<div class="col-sm-12">
                <h3>Project Summary</h3>
                <table class="parts-list" id="calcs-table">
                   <tr>
                      <th>Description</th>
                      <th>Value</th>
                      <th>Description</th>
                      <th>Value</th>
                   </tr>

                <?php

                   echo "   <tr>";
                   echo "      <td>Module Type</td>";
                   echo "      <td>". $module_cell." cell</td>";
                   echo "      <td>Code Version</td>";
                   echo "      <td>".$codeVersion."</td>";
                   echo "</tr>";

                   echo "   <tr>";
                   echo "      <td>Module Width</td>";
                   echo "      <td>".$moduleWidth." mm</td>";
                   echo "      <td>Wind</td>";
                   echo "      <td>".$wind." mph</td>";
                   echo "</tr>";

                   echo "   <tr>";
                   echo "      <td>Type of Rack</td>";
                   echo "      <td>";
                   if($type_of_rack == 'rammed-post'){echo "Rammed";}else{echo "Foundation";};
                   echo "</td>";
                   echo "      <td>Ground Snow</td>";
                   echo "      <td>".$snow." psf</td>";
                   echo "</tr>";

                   echo "   <tr>";
                   echo "      <td>Size of Rack</td>";
                   echo "      <td>2V x ".$moduleCount."</td>";
                   echo "      <td>System Length</td>";
                   echo "      <td>".round(($sysLengthIn / 12), 2)." feet</td>";
                   echo "</tr>";
                   echo "   <tr>";
                   echo "      <td>Tilt</td>";
                   echo "      <td>".$tilt." degrees</td>";
                   echo "      <td></td>";
                   echo "      <td></td>";
                   echo "</tr>";

                ?>
                </table>
                </div>
            </div>
        </div>

    	<div class="col-sm-5">
        	<div class="row">
            	<div class="col-sm-12">
                <h3>Installation Details</h3>
                <table class="parts-list">

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
                echo '<td>'.$key['shear_force'].' kip</td>';
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
                echo '<td>'.$key['shear_force'].' kip</td>';
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
            </div>
        </div>
        </div>
        </div>



		<div role="tabpanel" class='tab-pane' id='docs'>
        <div class="row">
    	<div class="col-sm-7">
        	<div class="row">
            	<div class="col-sm-12">
        <button class='action-button' id="pdf" name="cover-sheet"><span class='glyphicon glyphicon-file' style="padding-right:5px;"></span>Download Engineering Letter and All Drawings &raquo;</button>
        		</div>
            </div>
        </div>
        <form  id="summary" target="_blank" method="post" action="pdf2.php?pdf">
    	<div class="col-sm-7">
        	<div class="row">
            	<div class="col-sm-12">
        		<p>Fill out the form below to download all system documents and an engineering letter for permitting purposes.</p>
                </div>
            </div>
        </div>
    	<div class="col-sm-7">
        	<div class="row">
            	<div class="col-sm-12">
        <input type="text" name="cname" placeholder="Client Name"/>
        <input type="text" name="projectaddress" placeholder="Project Address" value="<?php if(isset($_SESSION['projectAddress'] )){echo  $_SESSION['projectAddress'];}?>"/>
        			<div class="row">
                    <div class="col-sm-4">
                    <input type="text" name="city" placeholder="City" value="<?php if(isset($_SESSION['projectAddress'] )){echo  $_SESSION['projectCity'];}?>"//>
        			</div>

                    <div class="col-sm-4">
                    <input type="number" name="zipcode" placeholder="Zip"  disabled value="<?php if(isset($_SESSION['projectZip'])){echo $_SESSION['projectZip'];}?>"/>
                    </div>
                    </div>
        <input type="email" name="email" placeholder="Email"/>
        		</div>
			</div>
		</div>
    	<div class="col-sm-5">
        	<div class="row">
            	<div class="col-sm-12">
        <select id="sales" name='sales'>
        <option value="">Schletter Sales Associate</option>
        <option value="New Customer">New Customer</option>
        <option value="Angela Kliever">Angela Kliever</option>
        <option value="Blaz Ruzic">Blaz Ruzic</option>
        <option value="Christian Savaia">Christian Savaia</option>
        <option value="Daniel Rodriguez">Daniel Rodriguez</option>
        <option value="David Johnson">David Johnson</option>
        <option value="Fernando Figueroa">Fernando Figueroa</option>
        <option value="George Varney">George Varney</option>
        <option value="Justin Smith">Justin Smith</option>

        <option value="Saul Soto">Saul Soto</option>
        <option value="Other">Other</option>
        </select>
        <input type="submit" value="Submit" class='action-button' />
        <div class="g-recaptcha" data-sitekey="6LciJxATAAAAAGzU-K6Fab7NxeebbyWuJo6H4rKT"></div>
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

           //e.preventDefault();
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
            </div>
        </div>
		</div>
		</div>
</div></div></div></div></div>

<?php

$_SESSION['fstype_of_rack'] = $type_of_rack;
$_SESSION['fsrailCount'] = $CuttingStockRail;
$_SESSION["minRail"] = $bestresults["stockRailQuantity"][4200] ;
$_SESSION["maxRail"]  = $bestresults["stockRailQuantity"][6200] ;
 $_SESSION["railsShipping"] = $bestresults["railsShipping"] ;
$_SESSION['fstriangleItem'] = $triangleItem;
$_SESSION['fsSupportTriCount'] = $supportTriCount;
$_SESSION['fsSpliceCount'] = $spliceCountTotal;
$_SESSION['fsEndClampitemnum'] = $endClamp['item_number'];
$_SESSION['fsEndClampdesc'] = $endClamp['description'];
$_SESSION['fsEndClampqty'] = $endclampqty;
$_SESSION['fsMiddleClampitemnum'] = $middleClamp['item_number'];
$_SESSION['fsMiddleClampdesc'] = $middleClamp['description'];
$_SESSION['fsMiddleClampqty'] = $middleClampqty;
$_SESSION['fsLaminateHookdesc'] = $laminatehook['description'];
$_SESSION['fsLaminateHookItemNum'] = $laminatehook['item_number'];
$_SESSION['fsLaminateHookqty'] = $laminatehookqty;
$_SESSION['fsSystemlength'] = $sysLengthIn;
$_SESSION['stocklen'] = $stockLen;
$_SESSION['sysLength'] = $sysLength;
$_SESSION['support'] = $support;

//session variable for pdf
$_SESSION['centerCount'] = $bestresults["centerRailCount"];
$_SESSION['center'] = round($bestresults["centerRailLength"],-1);
$_SESSION['IntermRailRow'] = $bestresults["intermediateRailCount"];
$_SESSION['IntermRailCut'] = round($bestresults["intermediateRailLength"],-1);
$_SESSION['EndRailRow'] = $bestresults["endRailCount"];
$_SESSION['EndRailCut'] = round($bestresults["endRailLength"],-1);
$_SESSION['RailColumnTF'] = $RailColumnTF;
$_SESSION['totalRailLen'] = $totalRailLen;
$_SESSION['totalRailRow'] = $totalRailRow;
$_SESSION['IntermRowtotal'] = $IntermRowTotal;
$_SESSION['roundendcut'] = $roundendcut;
$_SESSION['roundIntercut'] = $roundIntercut;
$_SESSION['roundcenter'] = $roundcenter;
$_SESSION['centertotal'] = $centerTotal;
$_SESSION['endrowtotal'] = $EndRowTotal;
$_SESSION['fsonespanrail1'] = $onespanrail[0];
$_SESSION['fsonespanrail2'] = $onespanrail[1];
$_SESSION['fscutdesc'] = $bestresults["instructions"];
$_SESSION['kwatts'] = $kWp;
//var_dump($_SESSION);
$partsListfs = array(0,1,2,3,4,5);
$partsListfs[0] = array("partNumber" => "124303-06200","Description" =>"S1.5 Rail 6200","Quantity" => $bestresults["stockRailQuantity"][6200] );
$partsListfs[1] = array("partNumber" => "124303-04200","Description" =>"S1.5 Rail 4200","Quantity" => $bestresults["stockRailQuantity"][4200] );
$partsListfs[2] = array("partNumber" => $tempTri ,"Description" =>"Standard FS $tilt degrees","Quantity" => $supportTriCount);
$partsListfs[3] = array("partNumber" => "129303-000","Description" =>"S1.5 Splice Kit","Quantity" => $spliceCountTotal);
$partsListfs[4] = array("partNumber" => $endClamp['item_number'],"Description" =>$endClamp['description'],"Quantity" => $endclampqty);
$partsListfs[5] = array("partNumber" => $middleClamp['item_number'],"Description" =>$middleClamp['description'],"Quantity" => $middleClampqty);


$_SESSION['partslistfs'] = $partsListfs;
?>

<?php
 require_once('includes/footer.php');
?>

<script type="text/javascript">
jQuery(function(){
var trailarray = '<?php   echo json_encode($trailsArr);?>';
var data = jQuery.parseJSON(trailarray);
$.each(data, function(i, item){
	//console.log("rack remain " + item.rackremain  +  " " +  "true/false val " + item.tf);
   if(item.tf == 'true'){console.log( "true value rack remain test " + item.rackremain );}
});

var checksarray = '<?php   echo json_encode($checkArr);?>';
var checkdata = jQuery.parseJSON(checksarray);
$.each(checkdata, function(i, item){
	console.log("rack remain " + item.rackremain  +  " " +  "true/false val " + item.tf);
  // if(item.tf == 'true'){console.log( "true value rack remain test " + item.rackremain );}
});

var testarr = '<?php echo  json_encode($intermralcut) ?>';
var da = jQuery.parseJSON(testarr);
var first
$.each(da, function(i, item){
	//console.log('ideal ' + item.rackremain);
	//first = item.rackremain[0][1];
    //alert("Mine is " + i + "|" + item.title + "|" + item.key);
});

//console.log(first);
var IntermRailCut = '<?php echo  json_encode($IntermRailCut); ?>'
var das = jQuery.parseJSON(IntermRailCut);
$.each(das, function(i, item){
	console.log('Interm ' + item);
    //  alert("Mine is " + i + "|" + item.title + "|" + item.key);
    });
});

</script>
