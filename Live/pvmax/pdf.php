<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once('includes/session.php');
set_include_path('../standard/tcpdf/');
require_once('../standard/tcpdf/tcpdf.php');
require_once('../standard/tcpdf/tcpdi.php');

 $client_name = $_POST['cname'];
 $email 	= $_POST['email'];
 $sales_name = $_POST['sales'];
 $projectaddress = $_POST['projectaddress'];
 $city = $_POST['city'];
// $state = $_POST['states'];
 $zipcode = $_POST['zipcode'];
 $cell = $_SESSION['moduleCell'];
 $code = $_SESSION['codeVersion'];
 $pvmaxtilt = $_SESSION['pvmaxtilt'];
 $pvmaxwind = $_SESSION['pvmaxwind'];
 $pvmaxsnow = $_SESSION['pvmaxsnow'];
 $span = $_SESSION['pvmaspan'];
 $seis = $_SESSION['pvmaxseismic'];
 $code_substr = substr($code, -2);
 $html = "";
 $coversheet= "";
 $seisTemp;
 $saleemail = " ";

$projectname = $_SESSION['projectname'];
if(isset($_SESSION['projectAddress']) && isset($_SESSION['projectZip'] ) && isset($_SESSION['projectCity'] ) && isset($_SESSION['projectState'] )){


$projectaddress 	 = $_SESSION['projectAddress'];
$city		 = $_SESSION['projectCity'] ;
$state		 = $_SESSION['projectState'] ;
$zipcode     = $_SESSION['projectZip'];

}else{

$address 	 = $_POST['projectaddress'];
$city 		 = $_POST['city'];//
$state  	 = $_POST['states'];
$zipcode     = $_POST['zipcode'];

}

switch($sales_name){
	case "Blaz Ruzic":
	$saleemail = "blaz.ruzic@schletter-group.com";
	break;
	case "Christian Savaia":
	$saleemail = "christian.savaia@schletter-group.com";
	break;
	case "Daniel Rodriguez":
	$saleemail = "daniel.rodriguez@schletter-group.com";
	break;
	case "Fernando Figueroa":
	$saleemail = "fernando.figueroa@schletter-group.com";
	break;
	case "Justin Smith":
	$saleemail = "justin.smith@schletter-group.com";
	break;
	case "Michael Mularski":
	$saleemail = "michael.mularski@schletter-group.com";
	break;
	default:
    $saleemail = "sales.us@schletter-group.com";
}

if($seis == "seismic"){ $seisTemp = ""; }else{ $seisTemp = " NS"; }
 //Original file with multiple pages
 $path = "files/PVMax ".$cell. " Cell/" . "ASCE 7-".$code_substr."/";

$fullPathToFile = $path.'PVM '.$cell.' '.$pvmaxtilt.' '. $pvmaxwind.' '.$code_substr.'.pdf';
//$fullPathToFile = $path.'PVMax '.$cell.' Cell 2V '.$pvmaxtilt.' '.$pvmaxwind.'mph '.$span.'ft 7-'.$code_substr.''.$seisTemp.'.pdf';

//echo $fullPathToFile;
class PDF extends TCPDI {
    var $_tplIdx;

    function Header() {

        //global $fullPathToFile;
		$image_file = '../standard/img/schletter-logo.png';
        $this->Image($image_file, 150, 5, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            //$this->numPages = $this->setSourceFile($fullPathToFile);
           // $this->_tplIdx = $this->importPage(1);

        }
       // $this->useTemplate($this->_tplIdx);

   }

function Footer() {
			 // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('Helvetica', 'I', 12);
        // Page number
        $this->Cell(0, 10, 'PvMax Summary | Schletter Inc. | (888) 608 - 0234', 0, false, 'C', 0, '', 0, false, 'T', 'M');
}

}

require_once('includes/class.phpmailer.php');//require_once 'includes/pdf.inc';;

// initiate PDF
// Create new PDF document.
$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setFontSubsetting(true);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//add font
$pdf->AddFont('dejavusans', '','dejavusans.php' );
// The new content
$pdf->SetFont("dejavusans", "R", 12,true);

// Add a page from a PDF by file path.
$pdf->SetTextColor(78,78,78);

$html .= '<style>
{
.list li{
	display:inline;
}
}
</style>';
//$pdf->Text(10,10,'Some text here');
// add a page

// THIS PUTS THE REMAINDER OF THE PAGES IN
//if($pdf->numPages>1) {
    //for($i=2;$i<=$pdf->numPages;$i++) {
       // $pdf->endPage();
	  // $pdf->_tplIdx = $pdf->importPage($i);
        //$pdf->AddPage();

   // }
//}
$html .= '<h1>PvMax &mdash; Summary</h1>';
$html .= ' <h2>Part List</h2>
<table border="1" cellspacing="2" cellpadding="3" class="parts-list" style="margin-left:auto;margin-right:auto; padding:20px;">
<tr>

<th  ><strong>Description</strong></th>
<th  ><strong>Value</strong></th>
<th  ><strong>Units</strong></th>

</tr>';

/*$html .= '<tr >
        <td class="product-code">124303-06200</td>
        <td>6.2 m S1.5 Rail</td>
        <td class="qty">'.$_SESSION['pvmaxRailCount'].'</td>

</tr>';*/


if($_SESSION["minRail"] != 0){
 $html .= "<tr>";
 $html .= "<td class='product-code'>124303-06200</td>";
 $html .= "<td>S 1.5 Rail 6200</td>";
 $html .= "<td class='qty'>".$_SESSION["maxRail"] ."</td>";
 $html .= "</tr>\n";
 $html .= "<tr>";
 $html .= "<td class='product-code'>124303-04200</td>";
 $html .= "<td>S 1.5 Rail 4200</td>";
 $html .= "<td class='qty'>".$_SESSION["minRail"] ."</td>";
 $html .= "</tr>\n";
}else{
 $html .= "<tr>";
 $html .= "<td class='product-code'>124303-06200</td>";
 $html .= "<td>S 1.5 Rail 6200</td>";
 $html .= "<td class='qty'>".$_SESSION['railsShipping'] ."</td>";
 $html .= "</tr>\n";
}

//$html .= '<tr >';

$html .= '<tr>
        <td class="product-code">'.$_SESSION['pvmaxTriangleItem'].'</td>
        <td>PvMax Support Triangle '.$_SESSION['pvmaxtilt'].' Degrees</td>
        <td class="qty">'.$_SESSION['pvmaxSuppTriCount'].'</td>
</tr>';

if ($_SESSION['pvmaxSpliceCount'] > 0){
//Don't display row if array is small and doesn't need splices
$html .= '<tr>
         <td class="product-code">129303-000</td>
         <td>S1.5 Splice Kit</td>
         <td class="qty">'. $_SESSION['pvmaxSpliceCount'].'</td>
		 </tr>';
};

/******************** End & Mid Clamp list *****************************/

$html .= '<tr>
         <td class="product-code">'.$_SESSION['pvmaxEndClampitemnum'].'</td>
         <td>'. $_SESSION['pvmaxEndClampdesc'] .'</td>
         <td class="qty">'.$_SESSION['pvmaxEndClampqty'].'</td>
		 </tr>';

$html .= '<tr>
         <td class="product-code">'.$_SESSION['pvmaxMiddleClampitemnum'] .'</td>
         <td>'. $_SESSION['pvmaxMiddleClampdesc'].'</td>
         <td class="qty">'.	$_SESSION['pvmaxMiddleClampqty'].'</td>
         </tr>';

if($_SESSION['pvmaxmodule_thickness'] == 6.8 || $_SESSION['pvmaxmodule_thickness']  == 8){
$html .= '<tr>
<td class="product-code">'.$_SESSION['pvmaxLaminateHookItemNum'].'</td>
<td>'.$_SESSION['pvmaxLaminateHookdesc'].'</td>
<td class="qty">'.$_SESSION['pvmaxLaminateHookqty'].'</td>
</tr>';

}
$html .= '</table>';

// Calculation Table
$html .= '<table>';

$html .= '<h2>Calculation</h2><table border="1" cellspacing="2" cellpadding="2" class ="parts-list" style="margin-left:auto;margin-right:auto; padding:20px;">
<tr>
      <th>Description</th>
      <th>Value</th>
      <th>Units</th>
   </tr>';

/*$html .= "<tr>
         <td>Design Type</td>
         <td>".$_SESSION['design']."</td>
         <td></td>
		 </tr>";*/
$html .= "<tr>
         <td>Design Type</td>
         <td>".$cell."</td>
         <td></td>
     </tr>";

$html .= "<tr>
         <td>Module Width</td>
         <td>".$_SESSION['moduleWidth']."</td>
         <td>mm</td>
		 </tr>";

$html .=  "<tr>
         <td>Size of Rack</td>
   <td>2V x ".$_SESSION['moduleCount']."</td>
        <td></td>
</tr>";

$html .= "<tr>
         <td>Tilt</td>
         <td>".$_SESSION['pvmaxtilt']."</td>
         <td>degrees</td>
		 </tr>";

$html .= "<tr>
   <td>Code Version</td>
   <td>".$_SESSION['codeVersion']."</td>
   <td></td>
   </tr>";

$html .= "<tr>
   <td>Wind</td>
   <td>".$_SESSION['pvmaxwind']."</td>
   <td>mph</td>
   </tr>";

$html .=  "<tr>
   <td>Ground Snow</td>";
   /*if($_SESSION['design'] == 'ballasted'){*/
	  /* $html .= " <td>".$_SESSION['ballastedsnow']."</td>";*/
   /*}else{ */
	    $html .=   " <td>".$_SESSION['pvmaxsnow']."</td>";
   /*}*/
$html .= "<td>psf</td></tr>";

$html .=  "<tr>
          <td>System Length</td>
          <td>". $_SESSION['sysLengthft'] ."</td>
          <td>feet</td>
          </tr>";
$html .= "</table>";


$html .= '<h2>Rails Location and Cuts</h2>
<table border="1" class="parts-list" cellspacing="2" cellpadding="3" style="margin-left:auto;margin-right:auto; padding:20px;">
<tr>
<th>Location</th><th>Rails Row</th><th>Cut</th><th>Rail length</th><th>Total</th>
</tr>
<tr>
<td>Center</td>';
if(( $_SESSION['pvmaRailColumnTF']  ) == "true" || $_SESSION['support'] == 2){$html .= '<td>'. $_SESSION['pvmacenterCount'] .'</td>';}else{$html .= '<td>'. 0 .'</td>';}
$html  .= '<td>@</td>';

if($_SESSION["sysLength"] <= $_SESSION["stocklen"]){ $html .= '<td>'.$_SESSION['sysLength'].'</td>';}elseif($_SESSION["support"] ==2 && $_SESSION["sysLength"] > $_SESSION["stocklen"]){ $html .= '<td>'.$_SESSION["pvmaxonespanrail1"] .'</td>';}elseif($_SESSION["support"] ==2 && $_SESSION["sysLength"] <= $_SESSION["stocklen"]) {$html .= '<td>'.$_SESSION["sysLength"].'</td>';}elseif(( $_SESSION['pvmaRailColumnTF']  ) == "true" || $_SESSION['support'] == 2){$html .= '<td>'. round($_SESSION['pvmacenter']) .'</td>';}

if($_SESSION["sysLength"] <= $_SESSION["stocklen"]){ $html .= '<td>'.$_SESSION['sysLength'] * $_SESSION['pvmacenterCount'] .'</td>';
}elseif($_SESSION["support"] ==2 && $_SESSION["sysLength"] > $_SESSION["stocklen"]){$html .= '<td>'.$_SESSION["pvmaxonespanrail1"] * $_SESSION['pvmacenterCount'] .'</td>';
}elseif($_SESSION["support"] ==2 && $_SESSION["sysLength"] <= $_SESSION["stocklen"]){$html .= '<td>'.$_SESSION['sysLength'] * $_SESSION['pvmacenterCount'] .'</td>';}elseif(( $_SESSION['pvmaRailColumnTF']  ) == "true" || $_SESSION['support'] == 2){ $html .= '<td>'. round($_SESSION['pvmacenter'] * $_SESSION['pvmacenterCount']).'</td>';
}else{$html .= '<td>'. 0 .'</td>';}
//$html .= '<td>'.$_SESSION['roundcenter'].'</td>';
$html .= '</tr>';

$html .= '<tr><td>Intermediate</td>';
if( $_SESSION['lowestRailLenCut'] >= $_SESSION['intermcheck']){$html .= '<td>'. 0 .'</td>';}elseif($_SESSION['support'] == 2 && $_SESSION['sysLength'] > $_SESSION['stocklen']){$html .= '<td>'. 1 .'</td>';}elseif($_SESSION['support'] == 2 && $_SESSION['sysLength'] <= $_SESSION['stocklen']){$html .= '<td>'. 0 .'</td>';}else{$html .= '<td>'.  $_SESSION['pvmaIntermRailRow'].'</td>';}
$html .= '<td>@</td>';

if($_SESSION['sysLength'] <= $_SESSION['stocklen'] ){$html .= '<td>'. 0 .'</td>';}elseif($_SESSION['pvmaIntermRailRow'] == 0 ){
$html .= '<td>'. 0 .'</td>';
}elseif($_SESSION['support'] == 2 && $_SESSION['sysLength'] > $_SESSION['stocklen']){
$html .= '<td>'.$_SESSION["pvmaxonespanrail2"] .'</td>';}elseif($_SESSION['support'] ==2 && $_SESSION['sysLength'] <= $_SESSION['stocklen']){$html .= '<td>'. 0 .'</td>';}else{$html .= '<td>'. round($_SESSION['pvmaIntermRailCut'],-1) .'</td>';}

if($_SESSION['sysLength'] <= $_SESSION['stocklen'] ){$html .= '<td>'. 0 .'</td>'; }elseif($_SESSION['support'] == 2 && $_SESSION['sysLength'] > $_SESSION['stocklen']){
$html .= '<td>'.$_SESSION["pvmaxonespanrail2"]  .'</td>';}elseif($_SESSION['support'] == 2 && $_SESSION['sysLength'] <= $_SESSION['stocklen']){ $html .= '<td>'. 0 .'</td>';}{$html .= '<td>'.  round($_SESSION['pvmaIntermRailCut']  * $_SESSION['pvmaIntermRailRow']) .'</td>';}
$html .= '</tr>';

$html .= '<tr><td>End</td>';
if(($_SESSION['pvmaRailColumnTF']) == "false" || $_SESSION['support'] == 2){$html .= '<td>'. 0 .'</td>';}else{$html .= '<td>'.$_SESSION['pvmaEndRailRow'] .'</td>';}
$html  .= '<td>@</td>';
$html .= '<td>'.$_SESSION['pvmaroundendcut'].'</td>';
if($_SESSION['pvmaRailColumnTF'] == "false" || $_SESSION['support']  == 2){ $html .= '<td>'. 0 .'</td>';}else{$html .= '<td>'.$_SESSION['pvmaendrowtotal']  .'</td>';}
$html .= '</tr></table>';


$pdf->AddPage('P', 'Letter');
//$pdf->AddPage('P', 'A4');
$pdf->writeHTML($html, true, false, true, false, '');

"<p>";
foreach ( $_SESSION['pvmaxcutdesc'] as $key => $value) {
	$coversheet .=  $value ;
}
 "</p>";


$coversheet .= '<h2>Installation Details</h2>';
$coversheet .= '<table border="1" cellspacing="2" cellpadding="4" style="margin-left:auto;margin-right:auto; padding:20px;">';
$coversheet .= '<tr>
<th>Max Span</th>
<th>Ballast Width</th>
<th>FCT</th>
<th>FCC</th>
<th>FCS</th>
<th>RCT</th>
<th>RCC</th>
<th>RCS</th>
<th>Rebar Qty</th>
</tr>';

if($cell == 60 && $code == 'ASCE7-10'){
$coversheet .= '<tr>
<td>'.$_SESSION['code710maxspan'].' ft</td>
<td>'.$_SESSION['code710blockwidth'].' in</td>

<td>'.round($_SESSION['code710front_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code710front_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code710front_conne_shear'],2).'kips</td>
<td>'.round($_SESSION['code710rear_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code710rear_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code710rear_conne_shear'],2).'kips</td>
<td>'.$_SESSION['code710rebar'].' </td>
</tr>';
}else if($cell == 60 && $code == 'ASCE7-05'){
$coversheet .= '<tr>
<td>'.$_SESSION['code705maxspan'].' ft</td>
<td>'.$_SESSION['code705blockwidth'].' in</td>

<td>'.round($_SESSION['code705front_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code705front_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code705front_conne_shear'],2).'kips</td>
<td>'.round($_SESSION['code705rear_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code705rear_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code705rear_conne_shear'],2).'kips</td>
<td>'.$_SESSION['code705rebar'].' </td>
</tr>';
} else if($cell == 72 && $code == 'ASCE7-05'){
$coversheet .= '<tr>
<td>'.$_SESSION['code705maxspan'].' ft</td>
<td>'.$_SESSION['code705blockwidth'].' in</td>

<td>'.round($_SESSION['code705front_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code705front_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code705front_conne_shear'],2).'kips</td>
<td>'.round($_SESSION['code705rear_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code705rear_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code705rear_conne_shear'],2).'kips</td>
<td>'.$_SESSION['code705rebar'].' </td>
</tr>';

}else if($cell == 72 && $code == 'ASCE7-10'){
$coversheet .= '<tr>
<td>'.$_SESSION['code710maxspan'].' ft</td>
<td>'.$_SESSION['code710blockwidth'].' in</td>
<td>'.round($_SESSION['code710front_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code710front_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code710front_conne_shear'],2).'kips</td>
<td>'.round($_SESSION['code710rear_conne_tension'],2).'kips</td>
<td>'.round($_SESSION['code710rear_conne_comp'],2).'kips</td>
<td>'.round($_SESSION['code710rear_conne_shear'],2).'kips</td>
<td>'.$_SESSION['code710rebar'].' </td>
</tr>';

}

$coversheet .= '</table>';


$coversheet .= '<h1>Client and Project Information</h1><table border="1" cellspacing="2" cellpadding="4">';

$coversheet .= "<tr>
    		   <td><strong>Client Name (Company)</strong></td>
    		   <td>".$client_name ."</td>
			   </tr>";
 $coversheet .= "<tr>
    		   <td><strong>Project Name</strong></td>
    		   <td>".$projectname ."</td>
			   </tr>";

$coversheet .= "<tr>
    <td><strong>Project Street Address:</strong></td>
    <td>". $projectaddress ."</td>
    </tr>";

$coversheet .="<tr>
    <td><strong>Project City:</strong></td>
    <td>". $city	 ."</td>
    </tr>";

$coversheet .='<tr>
    <td><strong>Project State:</strong></td>
    <td>'. $state .'</td>
    </tr>';

$coversheet .='<tr>
    <td><strong>Project Zip Code:</strong></td>
    <td>'. $zipcode .'</td>
    </tr>';

$coversheet .='<tr>
    <td><strong>Sales Associate:</strong></td>
    <td>'. $sales_name .'</td>
    </tr>';
$coversheet .='<tr>
    <td><strong>Client Email:</strong></td>
    <td>'. $email .'</td>
    </tr>';

$coversheet .='</table> ';
// design, snow, wind information
$coversheet .= '<br>';
$coversheet .= '<div class="design"><strong>Design Criteria: </strong> '. $_SESSION['codeVersion'].'<br/>' ;
$coversheet .= '<strong>Wind:</strong> '. $_SESSION['pvmaxwind'].' MPH <br/>';
$coversheet .= '<strong>Snow:</strong> '. $_SESSION['pvmaxsnow'].'</div><br/>';

if(isset( $seis) && $seis == "seismic"){
//seismic criteria
$coversheet .='<div><strong>Seismic Criteria</strong> : <span>Seismic category: E</span><br><table  border="1" cellspacing="2" cellpadding="3" class="parts-list" style="margin-left:auto;margin-right:auto; padding:20px;">';
$coversheet .='<tr><td>Sds</td><td>2.00</td><td>Sd1</td><td>1.40</td></tr>';
$coversheet .='<tr><td>Sds</td><td>3.00</td><td>S1</td><td>1.40</td></tr>';
$coversheet .='</table></div>';
}
//system includes information
$coversheet .= '<div><strong>Package Include:</strong>Drawing &amp; Calculation ';
$coversheet .= '<ol types="1"><li>State specific Stamped Letter of Blessing &amp; Calculation by P.E.</li><li>Representative Design Calculations</li><li>Structural Drawings</li></ol>';
$coversheet .= '<strong>System Type: </strong>PvMax<br>';
$coversheet .= '<strong>System Size: </strong>2V x '.$_SESSION['moduleCount'].'<br>';
$coversheet .= '<strong>System Location: </strong>Edge Zone<br>';
$coversheet .= '</div>';


//$pdf->writeHtml($coversheet, true, false, true, false, '');
$pdf->AddPage('P', 'Letter');
$pdf->writeHTML($coversheet, true, false, true, false, '');

//$pdf->writeHtml($coversheet, true, false, true, false, '');
//$pdf->AddPage('P', 'Letter');
//$pdf->writeHTML($coversheetpg2, true, false, true, false, '');

//Add Blessing letter
$letterpath = "../standard/letters/";

//var_dump(is_dir("../standard/letters/"));

$BlesssingLetter = $letterpath.$state." - Standardized Racking System, Blessing Letter.pdf";
//$letterpage = $pdf->setSourceFile($BlesssingLetter);

if(file_exists($BlesssingLetter)){
//Sealed Letter of Acceptance
$pdf->setSourceFile($BlesssingLetter);
$tplidxs = $pdf->importPage(1);
$pdf->AddPage('P', 'Letter');
$pdf->useTemplate($tplidxs);
}else{}


//$fullPathToFile = $path.'PVM '.$cell.' '.$pvmaxtilt.' '. $pvmaxwind.' '.$code_substr.'.pdf';
//echo $fullPathToFile = $path.'PVMax '.$cell.' Cell 2V '.$pvmaxtilt.' '.trim($pvmwindtemp).'mph 30 psf '.$spantemp.'ft 7-'.$code_substr.''.$seisTemp.'.pdf';
//$fullPathToFile = $path.'PVM '.$cell.' '.$pvmaxtilt.' '. $pvmaxwind.' '.$code_substr.'.pdf';
$fullPathToFile = $path.'PVMax '.$cell.' Cell 2V '.$pvmaxtilt.' '.$pvmaxwind.'mph '.$span.'ft 7-'.$code_substr.''.$seisTemp.'.pdf';

if(file_exists($fullPathToFile)){
$pageCount = $pdf->setSourceFile($fullPathToFile);
//$pdf->useTemplate($pdf->importPage(1),0,0);
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $tplIdx = $pdf->importPage($pageNo);
    $pdf->SetPrintHeader(false);
	//add a page
    $pdf->AddPage('P', 'Letter');
    $pdf->useTemplate($tplIdx);

	//font and color selection
    $pdf->SetFont('Helvetica');
    $pdf->SetTextColor(200, 0, 0);

	//now write some text above the imported page
    //$pdf->SetXY(40, 83);
    //$pdf->Write(2, 'THIS IS JUST A TEST');
}

}elseif(!file_exists($fullPathToFile)){
	$pvmwindtemp = trim($pvmaxwind);
	$spantemp= "";
	//if($code_substr == 05 && $cell == 60){ $pvmsnowtemp = 20;}else{ $pvmsnowtemp = 40;}
	//if($code_substr == 05 && $cell == 72){ $pvmsnowtemp = 20;}else{ $pvmsnowtemp = 40;}

	//if($code_substr == 10 && $cell == 60){ $pvmsnowtemp = 20;}else{ $pvmsnowtemp = 40;}
	//if($code_substr == 10 && $cell == 60){ $pvmsnowtemp = 20;}else{ $pvmsnowtemp = 40;}

	/**if($code_substr == 10 && $cell == 60){ $pvmwindtemp = 140;}elseif($code_substr == 05 && $cell == 60){$pvmwindtemp = 110;}
	if($code_substr == 10 && $cell == 72){ $pvmwindtemp = 140;}elseif($code_substr == 05 && $cell == 72){$pvmwindtemp = 110;}

	if($code_substr == 10 && $cell == 60 && $pvmaxtilt == 15){
	$span = 10;
	}elseif($code_substr == 10 && $cell == 60 && $pvmaxtilt == 20){
	$span = 9;
	}elseif($code_substr == 10 && $cell == 60 && $pvmaxtilt == 25){
	$span =8.5;}elseif($code_substr == 10 && $cell == 60 && $pvmaxtilt == 30){$span= 7.5;}elseif($code_substr == 10 && $cell == 60 && $pvmaxtilt == 35){$span = 7;}

	if($code_substr == 05 && $cell == 60 && $pvmaxtilt == 15){
	$span = 9.5;
	}elseif($code_substr == 05 && $cell == 60 && $pvmaxtilt == 20){
	$span = 9;
	}elseif($code_substr == 05 && $cell == 60 && $pvmaxtilt == 25){
	$span =8;}elseif($code_substr == 05 && $cell == 60 && $pvmaxtilt == 30){$span= 7.5;}elseif($code_substr == 05 && $cell == 60 && $pvmaxtilt == 35){$span = 7;}

	if($code_substr == 05 && $cell == 72 && $pvmaxtilt == 20){
	$span = 7.5;
	}elseif($code_substr == 05 && $cell == 72 && $pvmaxtilt == 25){
	$span =7.5;}elseif($code_substr == 05 && $cell == 72 && $pvmaxtilt == 30){$span= 6.5;}

	if($code_substr == 10 && $cell == 72 && $pvmaxtilt == 20){
	$span = 7.5;
	}elseif($code_substr == 10 && $cell == 72 && $pvmaxtilt == 25){
	$span =7.5;}elseif($code_substr == 10 && $cell == 72 && $pvmaxtilt == 30){$span= 7;}**/
switch($span){
case($cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 85|| $cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 85  ||
$cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 90 ||  $cell == 60 &&  $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 90 ||
$cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 85 ||   $cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 85
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 100 ||  $cell == 60 &&  $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 100
|| $cell == 60 && $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 110 ||  $cell == 60 &&  $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 110 ||  $cell == 60 &&  $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 115 ||   $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 115
||$cell == 60 &&  $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 115 || $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 115
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 130
):
$spantemp = 10.5;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 90 || $cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 90 ||
$cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 100 ||  $cell == 60 &&  $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 100 ||
$cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 100 ||  $cell == 60 &&  $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 100
|| $cell == 60 &&  $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 115 || $cell == 60 &&   $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 115
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 130):
$spantemp = 10.25;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 100 || $cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 100
||$cell == 60 &&  $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 100 ||  $cell == 60 &&  $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 100
|| $cell == 60 && $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 130 ||  $cell == 60 &&  $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 130
|| $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 130  ||  $cell == 60 &&  $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind ==130
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 140 || $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 140
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 85 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 85
|| $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 90 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 90
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 110
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 115 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 115):
$spantemp= 10;
$pvmwindtemp = $pvmaxwind;
break;
case ($cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 110  ||
$cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 110 ||   $cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 140 ||  $cell == 60 &&  $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 140
|| $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 140 ||  $cell == 60 &&  $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 140
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 90 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 90
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 110
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 115 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 115):
$spantemp = 9.75;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 130|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 130):
$spantemp = 9.5;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 120 || $cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 120
||$cell == 60 &&  $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 150 ||  $cell == 60 &&  $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 150
||$cell == 60 &&  $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 150 ||   $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 150
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 150 || $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 150
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 140 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 140
||  $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 85 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 85
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 85 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 85
|| $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 110):
$spantemp = 9.25;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 130
|| $cell == 60 && $pvmaxtilt == 15 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 130
|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 110
||$cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 130
|| $cell == 60 &&  $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 120
||$cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 140
|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 140 );
$spantemp = 8.25;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 120 || $cell == 60 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 120
||
$cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 120 ||  $cell == 60 &&  $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 120
||  $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 90 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 90
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 100 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 100
|| $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 115 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 115 ):
$spantemp = 9;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 130
|| $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 110
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 140 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 140):
$spantemp = 7.75;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 160 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 160
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 150 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 150
||  $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 120 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 120
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 120 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 120
||  $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 150 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 150
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 150 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 150):
$spantemp = 7.25;
$pvmwindtemp = $pvmaxwind;
break;
case( $cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 85
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 85
|| $cell == 60 &&  $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 90
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 90
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 90
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 90
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 25 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 115
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 115):

$spantemp = 10.75;
$pvmwindtemp = $pvmaxwind;
break;

case($cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 120 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 120
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 150 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 150
|| $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 110
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 110
||  $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 140 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 140
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 140 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 140):
$spantemp = 8;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 160 || $cell == 60 && $pvmaxtilt == 15 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 160
|| $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 160 ||   $cell == 60 && $pvmaxtilt == 20 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 160
|| $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 100 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 100
|| $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 130
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 130):
$spantemp = 8.5;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 100 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 100
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 130 ):
	$spantemp = 8.75;
	$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 85 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 85
|| $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 110 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 110):
$spantemp = 11;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 130
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 130):
$spantemp = 6;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 72 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 05 && $seis == 'non-seismic' 		&& $pvmaxwind == 130):
$spantemp = 6.5;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 160 || $cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 160
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 130
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 160 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 160):
$spantemp = 6.25;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 130 || $cell == 60 && $pvmaxtilt == 30 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 130
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'seismic' && $pvmaxwind == 120 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 05  && $seis == 'non-seismic' && $pvmaxwind == 120
||  $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 160 || $cell == 72 && $pvmaxtilt == 20 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 160
||  $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 160 || $cell == 72 && $pvmaxtilt == 25 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 160):
$spantemp = 6.75;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 120 || $cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 120
||  $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'seismic' && $pvmaxwind == 150 || $cell == 72 && $pvmaxtilt == 30 && $code_substr == 10  && $seis == 'non-seismic' && $pvmaxwind == 150):
$spantemp = 7;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 85 || $cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 85
):
$spantemp = 11.5;
$pvmwindtemp = $pvmaxwind;
break;
case($cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'seismic' && $pvmaxwind == 90
|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 05 && $seis == 'non-seismic' && $pvmaxwind == 90

|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 110
|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'seismic' && $pvmaxwind == 115
|| $cell == 60 && $pvmaxtilt == 35 && $code_substr == 10 && $seis == 'non-seismic' && $pvmaxwind == 115):
$spantemp = 11.25;
$pvmwindtemp = $pvmaxwind;
break;

}

	//$fullPathToFile = $path.'PVMax '.$cell.' Cell 2V '.$pvmaxtilt.' '.$pvmwindtemp.' mph '.$span.'ft 7-'.$code_substr.''.$seisTemp.'.pdf';
	$fullPathToFile = $path.'PVMax '.$cell.' Cell 2V '.$pvmaxtilt.' '.trim($pvmwindtemp).' mph 30 psf '.$spantemp.'ft 7-'.$code_substr.''.$seisTemp.'.pdf';

	$pageCount = $pdf->setSourceFile($fullPathToFile);

	//$pdf->useTemplate($pdf->importPage(1),0,0);

	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $tplIdx = $pdf->importPage($pageNo);
    $pdf->SetPrintHeader(false);

	//add a page
   // $pdf->AddPage('P', 'Letter');
    //$pdf->useTemplate($tplIdx);
      $pdf->AddPage();
    $pdf->useTemplate($tplIdx, null, null, 0, 0, true);
	//font and color selection
    $pdf->SetFont('Helvetica');
    $pdf->SetTextColor(200, 0, 0);

	//now write some text above the imported page
    //$pdf->SetXY(40, 83);
    //$pdf->Write(2, 'THIS IS JUST A TEST');
}
}

//drawing file
$path = "files/";
//PVMax 60 Cell 03.15.pdf
$drawingpath = $path . "PVMax " .$cell. " Cell 11.15.pdf";
$Drawingpage = $pdf->setSourceFile($drawingpath);

//$pdf->useTemplate($pdf->importPage(1),0,0);

for ($pageNo = 1; $pageNo <= $Drawingpage; $pageNo++) {
    $tplI = $pdf->importPage($pageNo,0,0);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);
    // add a page
    $pdf->AddPage('L', 'A0');
    $pdf->useTemplate($tplI, null, null, 0, 0, true);

    // font and color selection
    $pdf->SetFont('Helvetica');
    $pdf->SetTextColor(200, 0, 0);

}

//Output the file as forced download
//$summary  = "PvMax_Summary_".$cell.'_cell_'.$pvmaxtilt.'_tilt_'. $pvmaxwind.'_wind_'.$code_substr.'_code.pdf';
//$pdf->Output($summary, 'I');
 		 $email;$comment;$captcha;
		$mail = new PHPMailer(); // defaults to using php "mail()"

        $body = "Thank you for using PV Powersite. Make sure to click the 'Add to Basket' link in order to connect to our online store. 
        The documentation generated from the site can be used for permitting purposes.  
        Should you have technical issues with this site, please send screen shots and/or descriptions to <a href='mailto:marketing.us@schletter-group.com'>marketing.us@schletter-group.com</a>.
		";
		$marketing = 'marketing@schletter.us';
		$sendfrom = preg_replace("/\n/", "", $marketing);
        $mail->AddReplyTo("marketing.us@schletter-group.com","PV Powersite");
        $mail->SetFrom($sendfrom , 'PV Powersite');


			$wes = "wesley.babers@schletter.us";
			$eric = "eric.jacobs@schletter.us";
			$justin = "justin.russell@schletter.us";

		if(isset($_GET['pdf_email_geotech']) ){
			//echo "email sent";
			// $address =  preg_replace("/\n/", "", $wes);
			 //$Bcc = "kateka.thach@schletter.us";
			// $cc =  preg_replace("/\n/", "", $eric);
			// $Bcc =  preg_replace("/\n/", "", $justin);

		}else{
			 $address = preg_replace("/\n/", "", $email);
			 $cc =  preg_replace("/\n/", "", $saleemail);
			 //$Bcc = $wes;
			 if(isset($_POST['g-recaptcha-response'])){
          	    $captcha=$_POST['g-recaptcha-response'];
        	}
			if(!$captcha){
          		echo '<h2>Please check the the captcha form.</h2>';
          		exit;
        	}
        	  $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LciJxATAAAAAI5t-BilODJtHdJEe6XE07zF0BD0&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
       		 if($response.success==false)
        		{
          			//echo '<h2>You are spammer ! Get the out</h2>';
        		}else
        		{
          			//echo '<h2>Thanks for posting comment.</h2>';
        		}
		}


       	// $address = $email;
		$cc = $saleemail;
        $mail->AddAddress($address);
		$mail->AddCC($cc);
		$mail->AddBCC($Bcc);
        $mail->Subject    = "PvMax System Report_".$projectaddress;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->Body=$body;
        //documentation for Output method here: http://www.fpdf.org/en/doc/output.htm
        // $pdf->Output("Test Invoice.pdf","F");
	    //Output the file as forced download
		$pdf->Output('files/PvMax-System-report.pdf', 'F');
        $path = "files/PvMax-System-report.pdf";
        $mail->AddAttachment($path, '', $encoding = 'base64', $type = 'application/pdf');
        global $message;
        if(!$mail->Send()) {
          $message =  "Summary could not be send. Mailer Error: " . $mail->ErrorInfo;
        } else {
		 	//$message = "Summary";
			//sleep(5);
			//header("Location: http://secure.schletter.us/standard/form.php?$message");
			//die();
        	//echo  $message = "Summary sent!";
			//'FS '.$cell.' Cell '.$fstilt.' 2V '.$fswind.'mph '.$code_substr.''.$seis.'.pdf';
		$pdf->Output('files/PvMax-System-report.pdf', 'I');

		}


?>
