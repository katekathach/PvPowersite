<?php
 error_reporting(E_ALL);
 //ini_set('display_errors', 1);
 require_once ('includes/session.php');

 $_SESSION['clientName'] = htmlspecialchars($_POST['cname']);
 $_SESSION['email'] = htmlspecialchars($_POST['email']);
 $_SESSION['salesGuy'] = htmlspecialchars($_POST['sales']);
 $_SESSION['projectAddress'] = htmlspecialchars($_POST['projectaddress']);
 $_SESSION['city'] = htmlspecialchars($_POST['city']);
 $fscode = htmlspecialchars($_SESSION['fscodeVersion']);
 $fstilt = htmlspecialchars($_SESSION['fstilt']);
 $fswind = trim($_SESSION['fswind']);
 $span = htmlspecialchars($_SESSION['code'][0]['max_span']);
 $cell = htmlspecialchars($_SESSION['fsmoduleCell']);
 $seis = htmlspecialchars($_SESSION['fsseismic']);
 $code_substr = substr($fscode, -2);

 //$code_substr = substr($code, -2);
 $html = "";
 $coversheet = "";
 $seisTemp;
 $saleemail = " ";
 $email = $_SESSION['email'];


switch($sales_name){
  case "Angela Kliever":
  $saleemail = "angela.kliever@schletter-group.com";
  break;
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

$results_output = ob_get_contents();
ob_end_clean();
ob_start();
require_once 'includes/pdf.inc';
$html = ob_get_clean();
require_once ("includes/mpdf/mpdf.php");
require_once ("includes/PDFMerger/PDFMerger.php");
//require_once("includes/PDFMerger/PDFMerger.php");
//if (empty($html))
	//echo "We were unable to create your PDF for download.";
require_once('includes/class.phpmailer.php');
$mpdf = new mPDF('', '', 0, '', 15, 15, 16, 32, 9, 9, 'L');
//$mpdf->allow_charset_conversion=true;
//$mpdf->charset_in='UTF-8';
//$mpdf->SetHTMLHeader('<p class="pageHeader">Page {PAGENO} of 6</p>');
$mpdf -> SetHTMLFooter('<p class="pageFooter"><br><img src="img/schletter-logo-small.png"><br><br>&copy;FS &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Schletter Inc.&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;(520) 289-8700&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="mailto:mail@schletter.us">mail@schletter.us</a></p>');
$mpdf -> WriteHTML($html);
if($seis == "seismic"){ $seisTemp = ""; }else{ $seisTemp = " NS"; }
 //Original file with multiple pages
 //$path = "files/PVMax ".$cell. " Cell/" . "ASCE 7-".$code_substr."/";
// $filename = tempnam("tmp/","");
// PVMax, 60 Cell Rev 10.08.2014_AutoCAD-Model.pdf
if($seismic == "seismic"){}else{$seis = " NS";}
$path =  "files/fs_".$cell. "/ASCE 7-".$code_substr."/";
$drawing = "files/";
 $additionalPDF  = $drawing . "ALUM FS " .$fstilt. " " .$cell. " Cell Gen2 AutoCAD Sheet_123_Model.pdf";
//$additionalPDF = "files/PVMax ".$_SESSION['module_cell']." Cell 11.15.pdf";
$additionalPDFLetters = "../standard/letters/".$_SESSION["projectState"]." - Standardized Racking System, Blessing Letter.pdf";
// $fullPathToFile = $path.'PVMax '.$cell.' Cell 2V '.$pvmaxtilt.' '.$pvmaxwind.'mph '.$span.'ft 7-'.$code_substr.''.$seisTemp.'.pdf';
$fullPathToFile = $path.'FS '.$cell.' Cell 2V '.$fstilt.' '.$fswind.'mph 30psf 7-'.$code_substr.''.$seis.'.pdf';
// $fullPathToFile = $path.'PVMax '.$cell.' Cell 2V '.$pvmaxtilt.' '.trim($pvmwindtemp).' mph 30 psf '.$spantemp.'ft 7-'.$code_substr.''.$seisTemp.'.pdf';

//*** Remove older PDF tmp files ***//
$filetimeThreshold = 3600;
$tmppath = "tmp/";
if ($handle = opendir($tmppath)) {
	while (false !== ($file = readdir($handle))) {

		if (!is_file($tmppath . $file))
			continue;

		$timeDiff = time() - filectime($tmppath . $file);
		if ($timeDiff > $filetimeThreshold) {
			unlink($tmppath . $file);
		}
	}
}

$filename = tempnam("tmp/", "");

$mpdf -> Output($filename, 'F');

$merger = new PDFMerger();
$merger->addPDF($filename, 'all');

if(file_exists($additionalPDFLetters)){
	$merger->addPDF($additionalPDFLetters, 'all');
}else{}
if(file_exists($fullPathToFile)){
	$merger->addPDF($fullPathToFile, 'all');
}
//$merger->addPDf($fullPathToFile ,'all');
if(file_exists($additionalPDF)){
$merger->addPDF($additionalPDF, 'all');
}


/**
 *  Email customer and sales man PDF
 */
 		$comment;$captcha;
		$mail = new PHPMailer(); // defaults to using php "mail()"

        $body = "Thank you for using PV Powersite. Make sure to click the 'Add to Basket' link in order to connect to our online store.
        The documentation generated from the site can be used for permitting purposes.
        Should you have technical issues with this site, please send screen shots and/or descriptions to <a href='mailto:marketing@schletter.us'>marketing@schletter.us</a>.
		";

		$marketing = 'marketing@schletter.us';
		$sendfrom = preg_replace("/\n/", "", $marketing);
        $mail->AddReplyTo("marketing@schletter.us","PV Powersite");
        $mail->SetFrom($sendfrom , 'PV Powersite');
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
			/*** if(isset($_POST['g-recaptcha-response'])){
          	    $captcha=$_POST['g-recaptcha-response'];
        	}
			if(!$captcha){
          		echo '<h2>Please check the the captcha form.</h2>';
          		exit;
        	}**/
        	  //$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LciJxATAAAAAI5t-BilODJtHdJEe6XE07zF0BD0&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
       		// if($response.success==false)
        		//{
          			//echo '<h2>You are spammer ! Get the out</h2>';
        		//}else
        		//{
          			//echo '<h2>Thanks for posting comment.</h2>';
        		}
        			// $address = $email;
		//$cc = $saleemail;
        $mail->AddAddress($address);
		$mail->AddCC($cc);
		//$mail->AddBCC($Bcc);
        $mail->Subject    = "FS System Report_".$projectaddress;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->Body=$body;
  		//$mpdf->Output('files/FS-System-report.pdf', 'F');
        //$path = "files/FS-System-report.pdf";
		$merger->merge( 'file' , 'files/FS-System-report.pdf' );
 		//$merger->merge('string','files/WS-System-report.pdf');
		//$mpdf->Output('files/WS-System-report.pdf', 'F');
        $path = "files/FS-System-report.pdf";
        $mail->AddAttachment($path, '', $encoding = 'base64', $type = 'application/pdf');
        global $message;
        if(!$mail->Send()) {
          $message =  "Summary could not be send. Mailer Error: " . $mail->ErrorInfo;
        } else {
		 	$merger->merge('browser');
			unlink($filename);
		}



//$mpdf -> Output();



?>
