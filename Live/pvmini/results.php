<?php
session_start();

require_once './vendor/autoload.php';

$parameters = array();

if(isset($_SESSION["useStashed"]) && isset($_SESSION["stashedPost"]))
{
   $stashedFormResults = unserialize($_SESSION["stashedPost"]);
   foreach($stashedFormResults as $key=>$val)
   {
      $_SESSION[$key] = $val;
   }
}


// Inputs
$parameters["cellType"]            = ($_SESSION["cellType"] == '60') ? 60 : 72;
$parameters["moduleWidth"]         = (int) $_SESSION["moduleWidth"];
$parameters["moduleThickness"]     = (float) $_SESSION["moduleThickness"];
$parameters["tilt"]                = (int) $_SESSION["tilt"];
$parameters["moduleColumns"]       = (int) $_SESSION["moduleColumns"];
$parameters["numberRacks"]         = (int) $_SESSION["numberRacks"];
$parameters["codeVersion"]         = (int) $_SESSION["codeVersion"];
$parameters["seismic"]             = (bool) $_SESSION["seismic"];
$parameters["wind"]                = (int) $_SESSION["wind"];
$parameters["snow"]                = (int) $_SESSION["snow"];

// Hard-coded per Hugo and John at Schletter.
$parameters["orientation"]         = 'portrait';
$parameters["moduleHeight"]        = 1700;
$parameters["moduleRows"]          = 1;
$parameters["moduleClampLocation"] = .25; 
$parameters["tolerance"]           = 40;
$parameters["maxRail"]             = 6200;
$parameters["splicePercentage"]    = .25;
$parameters["minRail"]             = 4200;

$parameters["moduleCount"]         = $parameters["moduleRows"] * $parameters["moduleColumns"];

$_SESSION["stashedPost"] = serialize($_SESSION);
   
$calcError = false;
try {
    $calculator = new Schletter\GroundMount\Calculator($parameters);
    $results = $calculator->getResultsWithLoadTables();
    $partsCalculator = new Schletter\GroundMount\PartsCalculator($results);
    $parts = $partsCalculator->getParts();
} catch (\Exception $e) {
    $calcError = $e->getMessage();
}

$results["codeVersion"] = (10 == $_SESSION["codeVersion"]) ? 'ASCE7-10' : 'ASCE7-05';
$results["systemLength"] = round($results["systemLength"] / 304.8, 2);

ob_start();

?>

<div class="row">
<div class="form container">
   <div class="system-header">
      <h1>
      <img src="img/pvmini-icon.png" class="no-margin">
      PvMini</h1>
      <p class="sub-head">Create a 1V PvMini System: build a parts list, view drawings, and purchase.</p>
   </div>

 
   <div id="resultsData">
      <div role="tabpanel" class="row section">
			<ul class="nav nav-tabs" role="tablist" id="navigationList">
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
                           <?php foreach($parts as $partCategory): ?>
                               <?php foreach ($partCategory as $part): ?>
                                   <?php if(empty($part["quantity"])) continue; ?>
                                   <tr id="part-<?php echo $part['partNumber'] ?>">
                                       <td class='part-number'><?php echo $part["partNumber"] ?></td>
                                       <td class='name'><?php echo $part["name"] ?></td>
                                       <td class='quantity'><?php echo $part["quantity"] ?></td>
                                   </tr>
                               <?php endforeach ?>
                           <?php endforeach ?>
                           </table>
                           <span class="description">No overage is provided. Add items to basket, then modify quantities.</span>
                        </div>
                     </div>
                  </div>

                  <div class="col-sm-5">
                     <div class="row">
                        <div class="col-sm-12">
                           <table class="parts-list">
                              <tr>
                                 <th>Location</th>
                                 <th>Rails Row</th>
                                 <th>Cut</th>
                                 <th>Rail Length</th>
                                 <th>Total</th>
                              </tr>
                              <tr>
                                 <td>Center</td>
                                 <td id="center-rail-count"><?php echo $results["centerRailCount"]; ?></td>
                                 <td>&commat;</td>
                                 <td id="center-rail-length"><?php echo $results["centerRailLength"]; ?></td>
                                 <td><?php echo ($results["centerRailLength"] * $results["centerRailCount"]); ?></td>
                              </tr>
                              <tr>
                                 <td>Intermediate</td>
                                 <td id="intermediate-rail-count"><?php echo $results["intermediateRailCount"]; ?></td>
                                 <td>&commat;</td>
                                 <td id="intermediate-rail-length"><?php echo $results["intermediateRailLength"]; ?></td>
                                 <td><?php echo ($results["intermediateRailLength"] * $results["intermediateRailCount"]); ?></td>
                              </tr>
                              <tr>
                                 <td>End</td>
                                 <td id="end-rail-count"><?php echo $results["endRailCount"]; ?></td>
                                 <td>&commat;</td>
                                 <td id="end-rail-length"><?php echo $results["endRailLength"]; ?></td>
                                 <td><?php echo ($results["endRailLength"] * $results["endRailCount"]); ?></td>
                              </tr>
                           </table>
                           <!--<p>
                           <?php foreach ($results["instructions"] as $key => $instructionLine): ?>
                              <span id="instructions-<?php echo $key ?>"><?php echo $instructionLine ?></span><br>
                           <?php endforeach ?>
                           </p>-->
                           <p>
                           <?php foreach ($results["instructions"] as $key => $instructionLine): ?>
                              <!--<span id="instructions-<?php echo $key ?>"></span>-->
                               <?php if($instructionLine == ""){}else{echo $instructionLine ."<br>";}?>
                             <!--<p><?php echo $instructionLine ?></p>-->
                           <?php endforeach ?>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>


               <div class="row col-margin-top" id="onlineOrderLink">
                  <div class="col-sm-7">
                     <div class="row">
                        <div class="col-sm-12">
            <div class='alert alert-error '>
            <!--<p>Place your order online; sign in or create a Schletter store account and then click the <em>Add to Basket</em> button to the right.</p> use this when add to basket is enabled-->
            <!--<p>We're sorry, the <em>add to basket</em> feature is not currently available in the beta release of PV Powersite.</p>-->
                           <script type="text/javascript">
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
            		
                        </div>
                     </div>
                  </div>

      <div id="dialogmsg" title="login to add to basket" style="display:none">
            <iframe src="http://secure.schletter.us/mm5/merchant.mvc?Store_Code=S&Screen=LOGN"></iframe>
      </div>
        
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-12 form-field">
                    <form id="basket-add">
                       <input class="action-button disabled" type="submit" id="addPartsBtn" value="Add to Basket" />
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
                  <!--<tr>
                     <td>Project Name</td>
                     <td id="projectname"><?php echo $_SESSION["projectname"]; ?> </td>
                     <td>Project Address</td>
                     <td id="projectaddress"><?php echo $_SESSION["projectaddress"]." ".$_SESSION["projzip"]; ?></td>
                  </tr>-->
                  <tr>
                     <th>Module Type</th>
                     <td id="cell-type"><?php echo $parameters["cellType"]; ?> cell</td>
                     <th>Code Version</th>
                     <td id="code-version"><?php echo $results["codeVersion"]; ?></td>
                  </tr>
                  <tr>
                     <th>Module Width</th>
                     <td id="module-width"><?php echo $parameters["moduleWidth"]; ?> mm</td>
                     <th>Wind</th>
                     <td id="wind"><?php echo $results['wind'] ?> mph</td>
                  </tr>
                  <tr>
                     <th>Type of Rack</th>
                     <td><?php echo "Foundation"; ?></td>
                     <th>Ground Snow</th>
                     <td id="ground-snow"><?php echo $results['snow'] ?> psf</td>
                  </tr>
                  <tr>
                     <th>Size of Rack</th>
                     <td id="rack-size"><?php echo $results['moduleRows']."V x ".$results['moduleColumns'] ?> </td>
                     <th>System Length</th>
                     <td id="system-length"><?php echo $results['systemLength'] ?> ft</td>
                  </tr>
                  <tr>
                     <th>Tilt</th>
                     <td id="tilt"><?php echo $results["tilt"]; ?> degrees</td>
                     <th>Rack Quantity</th>
                     <td id="numberRacks"><?php echo $results["numberRacks"] ?></td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
                
    	<div class="col-sm-5">
         <div class="row">
            <div class="col-sm-12">
               <h3>Installation Details</h3>
               <table class="parts-list" style='margin-left:auto;margin-right:auto; padding:20px;'>
                  <tr>
                     <th>Max Span</th>
                     <td id="max-span"><?php echo $results["maxSpan"] ?> ft</td>
                     <th>Ballast Width</th>
                     <td id="ballast-width"><?php echo $results["ballastWidth"] ?> in</td>
                     <th>Rebar Qty</th>
                     <td id="rebar-qty"><?php echo $results["rebarCount"] ?></td>
                  </tr>
                  <tr>
                     <th>FCT</th>
                     <td id="FCT"><?php echo $results["FCT"] ?> kips</td>
                     <th>FCC</th>
                     <td id="FCC"><?php echo $results["FCC"] ?> kips</td>
                     <th>FCS</th>
                     <td id="FCS"><?php echo $results["FCS"] ?> kips</td>
                  </tr>
                  <tr>
                     <th>RCT</th>
                     <td id="RCT"><?php echo $results["RCT"] ?> kips</td>
                     <th>RCC</th>
                     <td id="RCC"><?php echo $results["RCC"] ?> kips</td>
                     <th>RCS</th>
                     <td id="RCS"><?php echo $results["RCS"] ?> kips</td>
                  </tr>
               </table>
               <p>FCT : Front Connection Tension<br/>
               FCC : Front Connection Compression<br/>
               FCS : Front Connection Shear<br/>
               RCT : Rear Connection Tension<br/>
               RCC : Rear Connection Compression<br/>
               RCS : Rear Connection Shear</p>
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
        <button class='action-button' id="pdf" name="cover-sheet"><span class=' glyphicon glyphicon-file' style="padding-right:5px;"></span>Download Engineering Letter and All Drawings &raquo;</button>
        		</div>
            </div>
        </div>
        <form id="summary" target="_blank" method="post" action="results.php?pdf">
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
           		<!--<input type="hidden" name="useStashed" id="useStashed" value="1" />-->
                <input type="text" name="cname" placeholder="Client Name" value="<?php if(isset($_SESSION['projectname']))echo $_SESSION['projectname']?>"/>
        		<input type="text" name="projectaddress" placeholder="Project Address" value="<?php if(isset($_SESSION['projectaddress'])) echo $_SESSION['projectaddress']?>"/>
        			<div class="row">
                    <div class="col-sm-4">
                    <input type="text" name="city" placeholder="City" value="<?php if(isset($_SESSION['projectaddress'])) echo $_SESSION['City']?>"/>
        			</div>
                
                    <div class="col-sm-4">			
                    <input type="number" name="zipcode" placeholder="Zip" disabled value="<?php if(isset($_SESSION['projzip'])) echo $_SESSION['projzip']?>"/>
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
        
        $('#pdf').on('click', function(){
         //$('#summary').show('fast');	
         $('#summary').toggle('fast' , function(){});
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

      <div id='footer' class="clear"> &copy; Schletter Store | <a href="http://www.secure.schletter.us">secure.schletter.us</a> | <a href="http://secure.schletter.us">Store</a> |
     <a href='files/PVPowerhouse-Terms-Of-Use.pdf' target='_blank'>Terms of Use</a> | <a href="../mm5/support/Schletter_ConditionsOfUse.pdf"> Conditions of Use</a> | <a href="../mm5/support/Schletter_Privacy_Policy.pdf">Privacy Policy</a>
      </div>
   </body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</html><script type="text/javascript">
jQuery(function(){
var trailarray = '[{"rackremain":4041,"tf":"true"},{"rackremain":5946,"tf":"true"},{"rackremain":0,"tf":"false"},{"rackremain":0,"tf":"false"}]';
var data = jQuery.parseJSON(trailarray);
$.each(data, function(i, item){
	//console.log("rack remain " + item.rackremain  +  " " +  "true/false val " + item.tf);
   if(item.tf == 'true'){console.log( "true value rack remain test " + item.rackremain );}
});	

var checksarray = '{"check1":[5715,0,3810,2,2136,"false"],"check2":[1905,2,3810,-0,231,"false"],"check3":[0,2,3810,-0,1183.5,"false"],"check4":[-1906,-2,3810,2,5946,"false"],"check5":[1904,0,3810,2,4041,"false"],"check6":[1905,0,3810,2,4041,"true"],"check7":[-1905,-2,3810,2,5946,"false"],"check8":[0,0,0,0,5946,"false"],"check9":[0,0,null,0,5946,"false"]}';
var checkdata = jQuery.parseJSON(checksarray);
$.each(checkdata, function(i, item){
	console.log("rack remain " + item.rackremain  +  " " +  "true/false val " + item.tf);
  // if(item.tf == 'true'){console.log( "true value rack remain test " + item.rackremain );}
});	
	
var testarr = '[5946,4041]';
var da = jQuery.parseJSON(testarr);
var first
$.each(da, function(i, item){
	//console.log('ideal ' + item.rackremain);
	//first = item.rackremain[0][1];
    //alert("Mine is " + i + "|" + item.title + "|" + item.key);
});

//console.log(first);	
var IntermRailCut = 'null'	
var das = jQuery.parseJSON(IntermRailCut);
$.each(das, function(i, item){
	console.log('Interm ' + item);
    //  alert("Mine is " + i + "|" + item.title + "|" + item.key);
    });
});

</script>

</div>
</div>
<?php
$results_output = ob_get_contents();
ob_end_clean();

if(isset($_GET["pdf"]))
{
   ob_start();
   require_once 'includes/pdf.inc';
   $html = ob_get_clean();
   require_once("includes/mpdf/mpdf.php");
   require_once("includes/PDFMerger/PDFMerger.php");
   //require_once('includes/class.phpmailer.php');
   
   if(empty($html))
      echo "We were unable to create your PDF for download.";

   $mpdf = new mPDF('','', 0, '', 15, 15, 16, 32, 9, 9, 'L');
   $mpdf->SetHTMLHeader('<p class="pageHeader">Page {PAGENO} of 6</p>');
   $mpdf->SetHTMLFooter('<p class="pageFooter"><br><img src="img/schletter-logo-small.png"><br><br>&copy;PVMini &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Schletter Inc.&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;(520) 289-8700&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="mailto:mail@schletter.us">mail@schletter.us</a></p>');

   @$mpdf->WriteHTML($html);
    if($parameters["seismic"] ){
   	 $seis = "";
   }else{
   	$seis = " NS";
   }
   if($parameters["codeVersion"] === 5){
 	$code = "05";
	}else{
	$code = "10";
	}
   //$additionalPDF = "includes/PVMini_60_Cell_Rev_10_10_2014_AutoCAD_Model.pdf"; 
   $additionalPDF = "includes/PVMini_60_Cell_Rev_12_14_2015_AutoCAD_Model.pdf";   
   $additionalPDFLetters = "../standard/letters/".$_SESSION['State']." - Standardized Racking System, Blessing Letter.pdf";
   $additionalPDFCalculations = "files/PVMini ".$parameters["cellType"]." Cell 1V ".$parameters["tilt"]." ".$parameters["wind"]."mph 30psf ".$results["maxSpan"]."ft "."7-".$code.$seis.".pdf";
   
   /*** Remove older PDF tmp files ***/
   $filetimeThreshold = 3600;
   $tmppath = "tmp/";
   if ($handle = opendir($tmppath)) {
      while (false !== ($file = readdir($handle))) {
         
         if(!is_file($tmppath.$file))
            continue;

         $timeDiff = time()-filectime($tmppath.$file);
         if ($timeDiff > $filetimeThreshold) {
            unlink($tmppath.$file);
         }
      }
   }
   
   $filename = tempnam("tmp/","");
   
   $mpdf->Output($filename, 'F');
   
  	$merger = new PDFMerger();
	$merger->addPDF($filename, 'all');
	if(file_exists($additionalPDFLetters)){
	$merger->addPDF($additionalPDFLetters, 'all');
	}else{

	}
	if(file_exists($additionalPDFCalculations)){
	$merger->addPDf($additionalPDFCalculations ,'all');
	}else{

	}

	$merger->addPDF($additionalPDF, 'all');

	$merger->merge('browser');
      
   unlink($filename);
}
else
{
   require_once 'includes/header.php';
   
   if ($calcError) {
      echo $calcError;
   } else {
   echo "<!--\n";
   print_r($_SESSION);
   print_r($_COOKIE);
   echo "-->";
   if( (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == -1))
   //&& (!isset($_COOKIE["mm5-S-customer-session"]) && !isset($_COOKIE["mm5-S-basket-id"])) && !isset($_GET["forceLogin"])
       $loggedIn = false;
   
   else
       $loggedIn = true;
?>
<script>
   var parts = [];
   <?php
   
   foreach($parts as $partCategory){
      foreach ($partCategory as $part){
         if(empty($part["quantity"]))
            continue;
         $tmpPart = array();
         $tmpPart['Category_Code'] = 11;
         $tmpPart['Product_Code'] = $part['partNumber'];
         $tmpPart['Quantity'] = $part['quantity'];
         echo "parts.push($.parseJSON('" . json_encode($tmpPart) . "'));\n";
      }
   }

   ?>
   $(document).ready(function() {
      <?php if($loggedIn) { ?>
      var store_url = window.location.protocol + '//' + document.domain + '/mm5/merchant.mvc?Screen=BASK'
      
      $('#basket-add').submit(function() {
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
       		  // window.open(store_url);
	   		  //alert(msg);
    		},
   			 error: function(msg) {
        	 //alert(error);
    		},
			complete: function(msg){
			 done = true;
			 console.log("done!");
			 //alert("done!");	
			}
            });
         });
         
         //window.open(store_url).focus();
         //window.blur();
		 //window.open(store_url).focus();
         //window.blur();
		
		var store = store_url;
 		if(done && window.chrome)
		{
			window.location = store;
		}
		else
		{
			 window.open(store).focus();
             window.blur();	
	 	}
         return false;
      });
      <?php } else { ?>

      $('#addPartsBtn').click( function() {
        // alert('Because you are not logged in, this feature is not available.');
          openLoginWindow();
         event.preventDefault();
      });
      <?php } ?>
   });
</script>
<?php
      echo $results_output;
   }
   
   require_once 'includes/footer.php';
}
?>
