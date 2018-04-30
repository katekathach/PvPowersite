<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// Include the main TCPDF library and TCPDI.
require_once('includes/session.php');
set_include_path('../standard/tcpdf/');
require_once('../standard/tcpdf/tcpdf.php');
require_once('../standard/tcpdf/tcpdi.php');
//require_once('fpdi/fpdi.php');

$client_name = $_POST['cname'];
$sales_name  = $_POST['sales'];
$projectaddress 	 = $_POST['projectaddress'];
$city 		 = $_POST['city'];
$state  	 = $_POST['states'];
$zipcode     = $_POST['zipcode'];
$email 		 = $_POST['email'];
$cell        = $_SESSION['fsmoduleCell'];
$fscode      = $_SESSION['fscodeVersion'];
$fstilt      = $_SESSION['fstilt'];
$fswind      = trim($_SESSION['fswind']);
$fssnow      = $_SESSION['fssnow'];
$code_substr = substr($fscode, -2);
$seismic     = $_SESSION['fsseismic'];
$html        = "";
$coversheet  = "";
$seis        = "";
$projectname = $_SESSION['projectname'];

if(isset($_SESSION['projectAddress']) && isset($_SESSION['projectZip'] ) && isset($_SESSION['projectCity'] ) && isset($_SESSION['projectState'] )){

//var_dump( explode( ',', $_SESSION['projectCityState'] ));

$projectaddress      = $_SESSION['projectAddress'];
$city		 	     = $_SESSION['projectCity'] ;
$state		 	     = $_SESSION['projectState'] ;
$zipcode     	     = $_SESSION['projectZip'];

}else{

$projectaddress 	 = $_POST['projectaddress'];
$city 		 		 = $_POST['city'];
$state  	 		 = $_SESSION['projectState'] ;
$zipcode     		 = $_POST['zipcode'];

}


$saleemail="";
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
	case "David Johnson":
	$saleemail = "david.johnson@schletter-group.com";
	break;
	case "Fernando Figueroa":
	$saleemail = "fernando.figueroa@schletter-group.com";
	break;
	case "George Varney":
	$saleemail = "george.varney@schletter-group.com";
	break;
	case "Justin Smith":
	$saleemail = "justin.smith@schletter-group.com";
	break;
	
	default:
    $saleemail = "sales.us@schletter-group.com";
}


if($seismic == "seismic"){}else{$seis = " NS";}

//Original file with multiple pages
$path = "files/fs_".$cell. "/ASCE 7-".$code_substr."/";
//$fullPathToFile = $path.'FS '.$cell.' Cell '.$fstilt.' 2V '.$fswind.'mph '.$code_substr.''.$seis.'.pdf';
$fullPathToFile = $path.'FS '.$cell.' Cell 2V '.$fstilt.' '.$fswind.'mph 30psf 7-'.$code_substr.''.$seis.'.pdf';
//test file name
//echo $fullPathToFile;

class PDF extends TCPDI {

    var $_tplIdx;

    function Header(){

        //global $fullPathToFile;
        //$this->SetY(15);
        // Logo
        $image_file = '../standard/img/schletter-logo.png';
        $this->Image($image_file, 150, 5, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        if (is_null($this->_tplIdx)) {

        // THIS IS WHERE YOU GET THE NUMBER OF PAGES
        //$this->numPages = $this->setSourceFile($fullPathToFile);
        // $this->_tplIdx = $this->importPage(1);

        }

        //$this->useTemplate($this->_tplIdx);

    }

    function Footer() {
		// Position at 15 mm from bottom
        $this->SetY(-15);
        // Logo
       // $image_file = '../standard/img/schletter-logo.png';
       // $this->Image($image_file, 25, 275, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('Helvetica', 'I', 12);
        // Page number
        $this->Cell(0, 10, 'FS Summary | Schletter Inc. | (888) 608 - 0234', 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

require_once('includes/class.phpmailer.php');

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
tr:nth-child(2){
	background-color: #ccc;
}
</style>';

$html .= '<h1>FS System &mdash; Summary</h1>';
$html .= ' <h2>Part List</h2>
<table border="1" cellspacing="2" cellpadding="3" class="parts-list" style="margin-left:auto;margin-right:auto; padding:20px;">
<tr>

<th  ><strong>Description</strong></th>
<th  ><strong>Value</strong></th>
<th  ><strong>Units</strong></th>

</tr>';

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


$html .= '<tr >';

  if($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 15 && $cell == 60) {
	     $html .= '<td class="product-code">140004-001</td>';
	     $html .=  '<td>Standard FS Foundation '.$_SESSION['fstilt'].'</td>';
	  }else if($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 15 && $cell == 60){
	     $html .= '<td class="product-code">140003-001</td>';
	     $html .= '<td>Standard FS Ram Post '.$_SESSION['fstilt'].'</td>';
	  }else if($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 20 && $cell == 60){
	  	 $html .= '<td class="product-code">140004-002</td>';
	  	 $html .= '<td>Standard FS Foundation '.$_SESSION['fstilt'].'</td>';
	  }else if($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 20 && $cell == 60){
		 $html .= '<td class="product-code">140003-002</td>';
	     $html .= '<td>Standard FS Ram Post</td>';
	  }else if($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 25 && $cell == 60) {
		 $html .= '<td class="product-code">140004-003</td>';
	     $html .= '<td>Standard FS Foundation '.$_SESSION['fstilt'].'</td>';
	  }else if($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 25 && $cell == 60 ){
		 $html .= "<td class='product-code'>140003-003</td>";
	     $html .= "<td>Standard FS Ram Post ".$_SESSION['fstilt']."</td>";
	  }else if($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 30 && $cell == 60){
		 $html .= '<td class="product-code">140004-004</td>';
	     $html .= '<td>Standard FS Foundation '.$_SESSION['fstilt'].'</td>';
	  }else if($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 30 && $cell == 60){
		 $html .= '<td class="product-code">140003-004</td>';
	     $html .= '<td>Standard FS Ram Post '.$_SESSION['fstilt'].'</td>';
	  }else if($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 35  && $cell == 60){
		 $html .= "<td class='product-code'>140003-005</td>";
	     $html .= "<td>Standard FS Ram Post ".$_SESSION['fstilt']." degrees</td>";
	  }elseif($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 35  && $cell == 60){
		 $html .= "<td class='product-code'>140004-005</td>";
	     $html .= "<td>Standard FS Foundation ".$_SESSION['fstilt']." degrees</td>";
      }else if($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 20 && $cell == 72){
		 $hltm .= "<td class='product-code'>140003-006</td>";
	     $html .= "<td>Standard FS Ram Post ".$_SESSION['fstilt']." degrees</td>";
      }elseif($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 20 && $cell == 72){
		 $html .= "<td class='product-code'>140004-006</td>";
	     $html .= "<td>Standard FS Ram Post ".$_SESSION['fstilt']." degrees</td>";
	  }elseif($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 25 && $cell == 72){
		 $html .= "<td class='product-code'>140004-007</td>";
	     $html .= "<td>Standard FS Foundation ".$_SESSION['fstilt']." degrees</td>";
	  }elseif($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 25 && $cell == 72){
		 $html .= "<td class='product-code'>140003-008</td>";
	     $html .= "<td>Standard FS Ram Post ".$_SESSION['fstilt']." degrees</td>";
	  }elseif($_SESSION['fstype_of_rack'] == 'rammed-post' && $_SESSION['fstilt'] == 30 && $cell == 72){
		 $html .= "<td class='product-code'>140003-008</td>";
	     $html .= "<td>Standard FS Ram Post ".$_SESSION['fstilt']." degrees</td>";
	  }elseif($_SESSION['fstype_of_rack'] == 'concrete-pillar' && $_SESSION['fstilt'] == 30 && $cell == 72){
		 $html .= "<td class='product-code'>140004-008</td>";
	     $html .= "<td>Standard FS Foundation ".$_SESSION['fstilt']." degrees</td>";
}

$html .= '<td class="qty">'.$_SESSION['fsSupportTriCount'].'</td></tr>';

//$html .= '<tr>
//<td class="product-code">'.$_SESSION['fstriangleItem'].'</td>
//<td>Standard FS Triangle '.$_SESSION['fstilt'].' degrees</td>
//<td class="qty">'.$_SESSION['fsSupportTriCount'].'</td>
//</tr>';

if ($_SESSION['fsSpliceCount']  > 0 || $_SESSION['fsSpliceCount']  > 4){
//Don't display row if array is small and doesn't need splices
$html .= '<tr>
         <td class="product-code">129303-000</td>
         <td>S 1.5 Splice Kit</td>
         <td class="qty">'. $_SESSION['fsSpliceCount'].'</td>
		 </tr>';
}

/******************** End & Mid Clamp list *****************************/

$html .= '<tr>
         <td class="product-code">'.$_SESSION['fsEndClampitemnum'].'</td>
         <td>'. $_SESSION['fsEndClampdesc'] .'</td>
         <td class="qty">'.$_SESSION['fsEndClampqty'].'</td>
		 </tr>';

$html .= '<tr>
         <td class="product-code">'.$_SESSION['fsMiddleClampitemnum'] .'</td>
         <td>'. $_SESSION['fsMiddleClampdesc'].'</td>
         <td class="qty">'.	$_SESSION['fsMiddleClampqty'].'</td>
         </tr>';

if($_SESSION['fsmodule_thickness'] == 6.8 || $_SESSION['fsmodule_thickness']  == 8){
$html .= '<tr>
<td class="product-code">'.$_SESSION['fsLaminateHookItemNum'].'</td>
<td>'.$_SESSION['fsLaminateHookdesc'].'</td>
<td class="qty">'.$_SESSION['fsLaminateHookqty'].'</td>
</tr>';
}
$html .= '</table>';

//Calculation Table
$html .= '<table>';
$html .= '<h2>Calculation</h2><table border="1" cellspacing="2" cellpadding="2" class ="parts-list" style="margin-left:auto;margin-right:auto; padding:20px;">
	      <tr>
          <th  ><strong>Description</strong></th>
          <th  ><strong>Value</strong></th>
          <th  ><strong>Units</strong></th>
  	      </tr>';

$html .= "<tr>
         <td>Design Type</td>
         <td>".$cell."</td>
         <td></td>
		 </tr>";

$html .= "<tr><td>Type of Rack</td>";
         if($_SESSION['fstype_of_rack'] == "rammed-post"){  $html .= "<td>Rammed</td>";}else { $html .= "<td>Drilled Shaft</td>";}
         $html .= "<td></td>
		 </tr>";

$html .= "<tr>
         <td>Module Width</td>
         <td>".$_SESSION['fsmoduleWidth']."</td>
         <td>mm</td>
		 </tr>";

$html .=  "<tr>
         <td>Size of Rack</td>
   		<td>2V x ".$_SESSION['fsmoduleCount']."</td>
        <td></td>
		</tr>";

$html .= "<tr>
         <td>Tilt</td>
         <td>".$fstilt."</td>
         <td>degrees</td>
		 </tr>";

$html .= "<tr>
   <td>Code Version</td>
   <td>".$fscode."</td>
   <td></td>
   </tr>";

$html .= "<tr>
   <td>Wind</td>
   <td>".$fswind."</td>
   <td>mph</td>
   </tr>";

$html .=  "<tr>
   <td>Ground Snow</td>
     <td>".$fssnow."</td>";
$html .= "<td>psf</td></tr>";

$html .=  "   <tr>
         <td>System Length</td>
         <td>".ceil($_SESSION['fsSystemlength'])."</td>
         <td>inches</td>
          </tr>";

$html .= "<tr>
		 <td>Rack Quantity</td>
         <td>".$_SESSION['fsrack_quantity']."</td>
         <td></td>
		</tr>";
$html .= "</table>";

	$_SESSION['centerCount'];
	$_SESSION['center'];
	$_SESSION['IntermRailRow'] ;
	$_SESSION['IntermRailCut'] ;
	$_SESSION['EndRailRow'];
	$_SESSION['EndRailCut'] ;
	$_SESSION['RailColumnTF'];
	$_SESSION['totalRailLen'];
	$_SESSION['totalRailRow'];
	$_SESSION['IntermRowtotal'];
	$_SESSION['roundendcut'];
	$_SESSION['roundIntercut'];
	$_SESSION['roundcenter'];
	$_SESSION['centertotal'];



$html .= '<h2>Rails Location and Cuts</h2>
<table border="1" class="parts-list" cellspacing="2" cellpadding="3" style="margin-left:auto;margin-right:auto; padding:20px;">
<tr>
<th ><strong>Location</strong></th>
<th ><strong>Rails Row</strong></th>
<th ><strong>Cut</strong></th>
<th ><strong>Rail Length</strong></th>
<th ><strong>Total (mm)</strong></th>
</tr>

<tr>
<td>Center</td>';

	$html .= '<td>'. $_SESSION['centerCount'] .'</td>';


$html  .= '<td>@</td>';

	if(isset($_SESSION['center'])){
	$html .= '<td>'. round($_SESSION['center'],-1) .'</td>';
	}else{
	$html .= '<td>'. 0 .'</td>';
	}




if($_SESSION["sysLength"] <= $_SESSION["stocklen"]){ $html .= '<td>'. round($_SESSION['sysLength'] * $_SESSION['centerCount'] ,-1).'</td>';
}elseif($_SESSION["support"] ==2 && $_SESSION["sysLength"] > $_SESSION["stocklen"]){
	$html .= '<td>'.round($_SESSION["fsonespanrail1"] * $_SESSION['centerCount'],-1) .'</td>';}elseif($_SESSION["support"] ==2 && $_SESSION["sysLength"] <= $_SESSION["stocklen"]){
		$html .= '<td>'.$_SESSION['sysLength'] * $_SESSION['centerCount'] .'</td>';}elseif(($_SESSION['RailColumnTF']) == "true" || $_SESSION['support'] == 2){ $html .= '<td>'. round($_SESSION['center'] * $_SESSION['centerCount'],-1) .'</td>';}else{$html .= '<td>'. 0 .'</td>';}
$html .= '</tr>';
$html .= '<tr><td>Intermediate</td>';
$html .= '<td>'.$_SESSION['IntermRailRow'].'</td>';

$html .= '<td>@</td>';

	if(isset($_SESSION['IntermRailCut'])){
	$html .= '<td>'. round($_SESSION['IntermRailCut'],-1) .'</td>';
	}else{
	$html .= '<td>'. 0 .'</td>';
	}

if($_SESSION['sysLength'] <= $_SESSION['stocklen'] ){$html .= '<td>'. 0 .'</td>'; }elseif($_SESSION['support'] == 2 && $_SESSION['sysLength'] > $_SESSION['stocklen']){
$html .= '<td>'. $_SESSION["fsonespanrail2"]  .'</td>';}elseif($_SESSION['support'] == 2 && $_SESSION['sysLength'] <= $_SESSION['stocklen']){ $html .= '<td>'. 0 .'</td>';} {$html .= '<td>'. round($_SESSION['IntermRailCut']  * $_SESSION['IntermRailRow']) .'</td>';}
$html .= '</tr>';


$html .= '<tr><td>End</td>';
if(($_SESSION['RailColumnTF']) == "false" || $_SESSION['support'] == 2){$html .= '<td>'. 0 .'</td>';}else{$html .= '<td>'.$_SESSION['EndRailRow'] .'</td>';}

$html  .= '<td>@</td>';

if($_SESSION['sysLength'] <= $_SESSION['stocklen']){$html .= '<td>'. 0 .'</td>';}elseif($_SESSION['support'] == 2){$html .= '<td>'. 0 .'</td>';}else{$html .= '<td>'.$_SESSION['roundendcut'].'</td>';}
if($_SESSION['RailColumnTF'] == "false" || $_SESSION['support'] == 2){ $html .= '<td>'. 0 .'</td>';}else{$html .= '<td>'. round($_SESSION['endrowtotal']).'</td>';}
$html .= '</tr></table>';

//$html .= "<br/> <p style='text-transform:uppercase'>it is violation fo law for any person to alter any document that bears the seal of a professional engineer, unless the person is acting under the direction of a licensed prefressional engineer.<p>";


$pdf->AddPage('P', 'Letter');
$pdf->writeHTML($html, true, false, true, false, '');

"<p>";
foreach ( $_SESSION['fscutdesc'] as $key => $value) {
	$coversheet .=  $value ;
}
 "</p>";
//$coversheet .= '<p>'.   $_SESSION['fscutdesc'] .'</p>';

$coversheet .= '<h2>Installation Details</h2>';
$coversheet .= '<table border="1" cellspacing="2" cellpadding="4">';
$coversheet .= '<tr>
         <th  ><strong>Max Span</strong></th>
         <th  ><strong>Tension</strong></th>
	     <th  ><strong>Lateral</strong></th>
         <th  ><strong>Shaft Depth</strong></th>
         </tr>';

if( $fscode == 'ASCE7-10'){
$coversheet .= '<tr>
<td>'.$_SESSION['fsmax_span'].' ft</td>
<td>'.$_SESSION['fstension_force'].' kips</td>
<td>'.$_SESSION['fslateral_force'].' kips</td>
<td>'.$_SESSION['fsdrilled_shaft_depth'].' ft</td>';
 //if($_SESSION['fsstar_item'] == 1){ $html .= '<td>required</td>'; }else{$html .= '<td>none</td>';}
$coversheet .= '</tr>';
}else if( $fscode == 'ASCE7-05'){
$coversheet .= '<tr>
<td>'.$_SESSION['fsmax_span'].' ft</td>
<td>'.$_SESSION['fstension_force'].' kips</td>
<td>'.$_SESSION['fslateral_force'].' kips</td>
<td>'.$_SESSION['fsdrilled_shaft_depth'].' ft</td>';
//if($_SESSION['fsstar_item'] == 1){ $html .= '<td>required</td>'; }else{$html .= '<td>none</td>';}
$coversheet .= '</tr>';
}
$coversheet .= '</table>';
// add a page
// Add Cover Sheet

$coversheet .= '<h1>Client and Project Information</h1><table border="1" cellspacing="2" cellpadding="4">';
$coversheet .= "<tr>
    <td><strong>Client Name (Company)</strong></td>
    <td>".$client_name ."</td>
	</tr>";

 $coversheet .= "<tr>
    <td><strong>Project Name</strong></td>
    <td>". $projectname."</td>
	</tr>";

$coversheet .= "<tr>
    <td><strong>Project Street Address:</strong></td>
    <td>". $projectaddress ."</td>
    </tr>";

$coversheet .="<tr>
    <td><strong>Project City:</strong></td>
    <td>". $city ."</td>
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

//design, snow, wind information
$coversheet .= '<br>';
$coversheet .= '<div class="design"><strong>Design Criteria: </strong> '. $fscode .'<br/>' ;
$coversheet .= '<strong>Maximum Wind Speed:</strong> '.$fswind.' MPH <br/>';
$coversheet .= '<strong>Maximum Ground Snow Load:</strong> '.$fssnow.'</div><br/>';

//seismic criteria
if($seismic  == "seismic"){
$coversheet .='<div><strong>Seismic Criteria</strong> : <span>Seismic category: E</span><br><table  border="1" cellspacing="2" cellpadding="3" class="parts-list" style="margin-left:auto;margin-right:auto; padding:20px;">';
$coversheet .='<tr><td>Sds</td><td>2.00</td><td>Sd1</td><td>1.40</td></tr>';
$coversheet .='<tr><td>Ss</td><td>3.00</td><td>S1</td><td>1.40</td></tr>';
$coversheet .='</table></div>';
}
//system includes information
$coversheet .= '<div><strong>Package Includes:</strong>';
$coversheet .= '<ol types="1"><li>State specific Stamped Letter of Blessing</li><li>Representative Design Calculations</li><li>Structural Drawings</li></ol>';
$coversheet .= '<strong>System Type: </strong>FS System ,';
$coversheet .= '<strong>System Size:</strong> 2V x '.$_SESSION['fsmoduleCount'].',';
$coversheet .= '<strong>System Location: </strong>Edge Zone';
$coversheet .= '</div>';

$pdf->AddPage('P' , 'Letter');
$pdf->writeHtml($coversheet, true, false, true, false, '');


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
$pdf->useTemplate($tplidxs, null, null, 0, 0, true);
}else{}

//add calculation pdf
if(file_exists($fullPathToFile)){
//Sealed Letter of Acceptance
$pageCount = $pdf->setSourceFile($fullPathToFile);
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $tplIdx = $pdf->importPage($pageNo);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);
    // add a page
    $pdf->AddPage();
    $pdf->useTemplate($tplIdx, null, null, 0, 0, true);

    // font and color selection
    $pdf->SetFont('Helvetica');
    $pdf->SetTextColor(200, 0, 0);

}
}else{

	$fswindtemp = "";
	if($code_substr == 05 && $cell == 60){ $fswindtemp = 110;}elseif($code_substr == 10 && $cell == 60){ $fswindtemp = 140;}
	if($code_substr == 05 && $cell == 72){ $fswindtemp = 110;}elseif($code_substr == 10 && $cell == 72){ $fswindtemp = 140;}

    //$fullPathToFiles = $path.'FS '.$cell.' Cell '.$fstilt.' 2V '.$fswindtemp.' mph '.$code_substr.''.$seis.'.pdf';
    $fullPathToFiles = $path.'FS '.$cell.' Cell 2V '.$fstilt.' '.$fswind.'mph 30psf 7-'.$code_substr.''.$seis.'.pdf';
	$pageCounts = $pdf->setSourceFile($fullPathToFiles);
for ($pageNos = 1; $pageNos <= $pageCounts; $pageNos++) {
    $tplIdxx = $pdf->importPage($pageNos);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);
    // add a page
    $pdf->AddPage();
    $pdf->useTemplate($tplIdxx, null, null, 0, 0, true);

    // font and color selection
    $pdf->SetFont('Helvetica');
    $pdf->SetTextColor(200, 0, 0);

}

}

// add drawings pdf
$path = "files/";
$drawingpath = $path . "ALUM FS " .$fstilt. " " .$cell. " Cell Gen2 AutoCAD Sheet_123_Model.pdf";
if(file_exists($drawingpath)){
//$drawingpath = "files/PvMax-60cell-standard-drawings.pdf";"
$Drawingpage = $pdf->setSourceFile($drawingpath);

//$pdf->useTemplate($pdf->importPage(1),0,0);
for($pageNum = 1; $pageNum <= $Drawingpage; $pageNum++) {
    $tplI = $pdf->importPage($pageNum,0,0);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);
    // add a page
    $pdf->AddPage('L', 'A0');
    $pdf->useTemplate($tplI, null, null, 0, 0, true);

    // font and color selection
    $pdf->SetFont('Helvetica');
    $pdf->SetTextColor(200, 0, 0);

}
}else{}

//$js = <<<EOD
//app.alert("even");
//var tblrows = document.getElementsByTagName("tr");
//app.alert(tblrows);
//for(i=0;i<tblrows.length;i++){
//if(i%2==0){

//tblrows[i].style.backgroundColor = "#ccc";
//}
//{
//	else tblrows[i].style.backgroundColor = "#fff";
//}
//}
//EOD;
//$js = <<<EOD
//app.alert('JavaScript Popup Example', 3, 0, 'Welcome');
//EOD;
//$pdf->IncludeJS($js);
 $email;$comment;$captcha;
 		$mail = new PHPMailer(); // defaults to using php "mail()"
 		$mail->SMTPDebug = 3;
        $body = "Thank you for using PV Powersite.
        Make sure to click the 'Add to Basket' link in order to connect to our online store.
        The documentation generated from the site can be used for permitting purposes.
        Should you have technical issues with this site, please send screen shots and/or descriptions to <a href='mailto:marketing.us@schletter-group.com'>marketing.us@schletter-group.com</a>.
		";

       	$marketing = 'marketing.us@schletter-group.com';
		$sendfrom = preg_replace("/\n/", "", $marketing);
        $mail->AddReplyTo("marketing.us@schletter-group.com","PV Powersite");
        $mail->SetFrom($sendfrom , 'PV Powersite');


			$wes = "wesley.babers@schletter.us";
			$eric = "eric.jacobs@schletter.us";
			$justin = "justin.russell@schletter.us";

		if(isset($_GET['pdf_email_geotech']) ){
			 //echo "email sent";
			 $address =  preg_replace("/\n/", "", $wes);
			 //$Bcc = "kateka.thach@schletter.us";
			 $cc 	  =  preg_replace("/\n/", "", $eric);
			 $Bcc     =  preg_replace("/\n/", "", $justin);

		}else{

			 $address = preg_replace("/\n/", "", $email);
			 $cc =  preg_replace("/\n/", "", $saleemail);
			 $Bcc = $wes;

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
        $mail->Subject    = "FS System Report_".$projectaddress;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->Body=$body;
        //documentation for Output method here: http://www.fpdf.org/en/doc/output.htm
        // $pdf->Output("Test Invoice.pdf","F");
	    //Output the file as forced download
		$pdf->Output('files/FS-System-report.pdf', 'F');
        $path = "files/FS-System-report.pdf";

        $mail->AddAttachment($path, '', $encoding = 'base64', $type = 'application/pdf');
        //global $message;
        if(!$mail->Send()) {
          $message =  "Summary could not be send. Mailer Error: " . $mail->ErrorInfo;
        }else {
		$message = "Summary";
		//sleep(5);
		//header("Location: http://secure.schletter.us/standard/form.php?$message");
		//die();
        //echo  $message = "Summary sent!";
		//'FS '.$cell.' Cell '.$fstilt.' 2V '.$fswind.'mph '.$code_substr.''.$seis.'.pdf';
		$pdf->Output('files/FS-System-report.pdf', 'I');
		}


?>
