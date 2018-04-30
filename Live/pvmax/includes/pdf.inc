<!DOCTYPE html>
<html>
<head>
<title>PVMax - Project Calculations</title>
<style type="text/css" rel="stylesheet">
         body
         {
            margin: .75in;
            line-height:115%;
            font-family: Arial,Helvetica,Verdana;
            font-size:12px;
            color:#333;
         }

         h1
         {
            font-size:150%;
            margin-top:1.5em;
            padding-top:1.5em;
             color:#004628;
            font-weight:bold;
            border-bottom: 1px solid #000;
         	padding-bottom: 2px;
         }
         
         
         h1 img
         {
            width: 25%; 
         }
         
         h2 
         {
            font-size: 100%;
            margin-top:1.3em;
            padding-top:1.3em;
            /*border-top:1px solid #bbb;*/
            color:#004628;
            font-weight:bold;
            border-bottom: 1px solid #000;
         	padding-bottom: 2px;
         }
         
         h3
         {
            font-size: 100%;
            margin-top:1.3em;
            margin-left:1.3em;
            color:#004628;
            font-weight:bold;
         }
         
         dt 
         {
            font-weight: bold;
         }
         
         p
         {
            margin: 0;
         }
         
         div.notes p
         {
            margin: 1.2em;
         }
         
         span.label 
         {
            display: inline-block;
            width: 13em;
         }
         
         table
         {
            margin-left:auto;
            margin-right:auto;
            margin-bottom:1.3em;
            border-spacing: 0;
            border-collapse: collapse;
         }
         
         td
         {
            padding:3px 6px;
            border:1px solid #aaa;
           
         }
         
         th
         {
            text-align:right;
            background-color:#efefef;
            border:1px solid #aaa;
            color:white;
            font-weight:bold;
            padding:5px;
         }
         
         #zoneData,
         #zoneData tr,
         #zoneData td
         {
            border:0;
            border:2px solid white;
         }
         
         #zoneData td
         {
            border:0;
            vertical-align: top;
            padding:5px 20px;
         }
         
         table.calcTable 
         {
            margin-top:1in;
            font-size:75%;
            width:6in;
         }
         table.calcTable th
         {
            text-align: center;
         }
         
         table.calcTable th.caption{
            background-color:black;
            text-align:left;
         }
         
         table td.emptyCol
         {
            border:0;
         }
         
         div.pagebreak
         {
            page-break-after: before;
         }

         div.partsDisclaimer,
         div.thermalExpansionDisclaimer
         {
            font-size:75%;
            font-style:italic;
            width:100%;
            text-align:left;
            line-height:130%;
         }
         
         .pageHeader
         {
            text-align: right;
            font-size:70%;
         }
         
         .pageFooter
         {
            margin:0px auto;
            font-size: 80%;
            line-height:120%;
            text-align: right;
            border-top: 1px solid #666;
         }
         
         .description,
         #navigationList,
         #onlineOrderLink,
         #docs,
         #footer
         {
            display: none;
         }
         
         table#projectDetails,
         table#projectDetails th,
         table#projectDetails td,
         table#engineeringReport,
         table#engineeringReport th,
         table#engineeringReport td,
         /**table#billingMaterial td,
         table#billingMaterial
         table#billingMaterial th,
         table#billingMaterial td,**/
         {
            border: 0;
            background-color: none;
            vertical-align: top;
         }

         table#projectDetails th,table#engineeringReport th, table#billingMaterial th, table#installDetails th, table#railArrangement th
         {
            font-weight: bold;
            text-align: left;
            color: #000;
         }

         table#projectDetails td, table#engineeringReport td, table#billingMaterial td, table#installDetails td
         {
            text-align: left;
            padding-left: 1em;
            padding-right: 4em;
         }
         table#engineeringReport thead th{
         	/*border-bottom: 1px solid #000;*/
         	padding-bottom:1px;
         }
     </style>
   </head>
   <body>

   <p>
       <img src="img/PV Powersite logo.jpg" title="PVMax" />
   </p>

   <h1>Project Information</h1>
   <table id="projectDetails">
   	
     <tr>
      			<th>Project Name:</th><td> <?php echo $_SESSION['pvmaxprojectname'];  ?></td>
      			<th>Design By:</th><td><?php echo isset($_POST['cname']) ? $_POST['cname'] : ''; ?></td>
     </tr>
      
     <tr>
				<th> Project Address: </th>
				<td><?php
				echo isset($_SESSION['projectAddress']) ? $_SESSION['projectAddress'] : '';
              	//echo $_POST["projectAddress"] ;
              	//echo $_POST["projectCity"] . ", ". $_POST["projectState"]." " . $_POST["projectZip"] . "<br />";
				?></td>
				<th>Email:</th>
				<td><?php
				echo $_POST['email'];
				?></td>

	</tr>      
      
     <tr>
				<th> City,State,Zip: </th>
				<td><?php				
            	echo $_SESSION["projectCity"] . ", ". $_SESSION["projectState"];
                //echo " - ";
                echo isset($_SESSION['projectZip']) ? $_SESSION['projectZip'] : '';
				?></td>
				<th> Date: </th>
				<td><?php
				//$today = date("F j, Y");
				$day = date('l ,F j, Y');
				echo $day;
				?></td>

	</tr>
      
    <tr>
				<th> Module Size: </th><td><?php  echo $_SESSION['moduleCell'] ?> Cell</td>
    </tr>
	<tr>
				<th> System Type: </th><td>Ground Mount , PvMax</td>
	</tr>
	<!--<tr>
				<th> Roof Type: </th>
	</tr>-->
	<tr>
				<!--<th> Building Height: </th>
				<td> &le; 40ft </td>-->
				<th> Schletter Sales Associate: </th>
				<td><?php echo $_POST["sales"];
				?></td>
				<td></td>
				<td></td>

	</tr>
  
   </table>
  
   <h1>Engineering Report</h1> 
   <table id="engineeringReport">  
  	    <!--<tr>
        <td>Design Specfications</td>
        <td>System Configuration</td>
        </tr> -->	  
      	<tr><th>Building Code:</th><td><?php echo $_SESSION['codeVersion']; ?></td><th>Rack Setup:</th><td> 2V X <?php echo $_SESSION['moduleCount'] ?></td></tr>
      	<tr><th>Wind Speed: </th><td><?php   echo $_SESSION['pvmaxwind'] ?> mph</td><th>Vertical Count:</th><td> 2V</td></tr>
      	<tr><th>Snow Load: </th><td><?php    echo $_SESSION['pvmaxsnow'] ?> psf</td><th>Horizontal Count:</th><td> <?php echo $_SESSION['moduleCount']?></td></tr>
      	<tr><th>Tilt:</th><td><?php echo $_SESSION['pvmaxtilt'] ;?> degrees</td></tr>
      	<tr><th>Module Thickness</th><td><?php echo $_SESSION['pvmaxmodule_thickness'];?> mm</td><th>Rack Count:</th><td><?php echo   $_SESSION['pvmaxrack_quantity']?></td></tr>
      	<tr><th></th><td></td><th>Module Count:</th><td><?php echo $_SESSION['moduleWidth'] ?> mm</td></tr>
      	<tr><th></th><td></td><th>Total Wattage:</th><td><?php echo $_SESSION['kwatts'];?></td></tr>
   	</table>
   <h1>Installation Details</h1>
   
   <table id="installDetails">
	<tr><th>Max Span:</th>
	<td><?php echo $_SESSION['code'][0]['max_span']?> ft</td><th>Ballast Width</th><td><?php echo $_SESSION['code'][0]['ballast_width']?> in</td><th>Rebar Qty:</th><td><?php echo $_SESSION['code'][0]['rebar']?></td></tr>
    <tr><th>FCT:</th><td><?php echo $_SESSION['code'][0]['front_conne_tension']?> kip</td><th>FCC:</th><td><?php echo $_SESSION['code'][0]['front_conne_compression']?> kip</td>
    	<th>FCS:</th><td><?php echo $_SESSION['code'][0]['front_conne_shear']?> kip</td></tr>
    	<tr><th>RCT:</th><td><?php echo $_SESSION['code'][0]['rear_conne_tension']?> kip</td><th>RCC:</th><td><?php echo $_SESSION['code'][0]['rear_conne_compression']?> kip</td> 
    	<th>RCS:</th><td><?php echo $_SESSION['code'][0]['rear_conne_shear']?> kip</td>	
    	</tr>
   	</table>   	
   <h1>Billing Material</h1> 
   <table id="billingMaterial">   
   	<tr><th>Part Number</th><th>Description</th><th>Quantity</th></tr>	
   <?php    
   $partsList = $_SESSION["partslist"];
  // print_r($partsList);
   foreach ($partsList as $items => $item) {
   	 	if($item['Quantity'] == 0){}else{
         echo "<tr><td>".$item['partNumber']."</td><td>".$item['Description']."</td><td>".$item['Quantity']."</td></tr>";   
	    //echo "<tr><td>".."</td></tr>"; 
		}
   }
   ?>
   </table>
  <h1>Module Rail Arrangement & Cuts</h1>
   <table id="railArrangement">
    <tr>
    	
     <th>Location of Rail</th>
     <th>Rails Per Row</th>     
     <th>Required Rail Length</th>
     
	</tr>
<tr><td>Center</td>
<td><?php 

echo $_SESSION['pvmacenterCount'];
 ?>
</td>


<!--<td>
<?php

echo round($bestresults['centerRailLength'],-1);
?>
</td>-->

<td>
<?php 
if($_SESSION['sysLength']  <=  $_SESSION['stocklen']){
echo  $_SESSION['sysLength']  * $_SESSION['pvmacenterCount'] ;
}elseif($_SESSION['support']== 2 && $_SESSION['sysLength']  > $_SESSION['stocklen']){ 
echo round($onespanrail[0],-1) * $_SESSION['pvmacenterCount'] ; 
}else if( $_SESSION['support'] == 2 && $_SESSION['sysLength'] <= $_SESSION['stocklen']){
echo  $_SESSION['sysLength']  * $_SESSION['pvmacenterCount'] ;	
}else if($_SESSION['pvmaRailColumnTF']   ||  $_SESSION['support']  == 2){ 
echo round($_SESSION['pvmacenter'],-1) * $_SESSION['pvmacenterCount'] ;}else{echo  0;}
?>
</td>

</tr>
<tr>
<td>Intermediate</td>
<td><?php 

 echo  $_SESSION['pvmaIntermRailRow'];
?></td>

<td>
<?php 
if($_SESSION['pvmaIntermRailRow'] == 0 ){echo 0;}else{
echo round($_SESSION["pvmaIntermRailCut"],-1);
}
?>
</td>
<!--<td>
<?php  if($IntermediateRailRow == 0 ){echo 0;}else if($support == 2 && $sysLength > $stockLen){
echo round($onespanrail[1],-1);
}else{
	echo round($bestresults["intermediateRailLength"],-1);

} ?>
</td>-->
</tr>

<tr>
<td>End</td>
<td><?php 
/*if($support == 2 || $RailColumnTF == "false"){echo 0;
}else{echo $EndRailRow;}*/
echo $_SESSION["pvmaEndRailRow"];
?>
</td>

<td><?php 
if($_SESSION['sysLength'] <= $_SESSION['stocklen']){echo 0 ;}elseif($_SESSION['support'] == 2){echo 0;
}else{echo round($_SESSION['pvmaEndRailCut'],-1);}?>
	
</td>
<!--<td><?php 
if($support == 2 && $RailColumnTF == "false"){
echo 0;
}else{
echo $EndRowTotal = $bestresults["endRailCount"] * round($bestresults["endRailLength"],-1);  
}
 ?>
</td>-->
</tr>

   </table>
<?php foreach ($_SESSION['pvmaxcutdesc'] as $key => $value) {
	echo $value ."\n";
} ?>
  <!-- <?php
   ob_start();  
   $projDetails = ob_get_contents();
   ob_end_clean();   
   $results_output = str_replace("&commat;", "@",  $projDetails);
  // echo $results_output;   
   ?>-->   
   </body>
</html>
