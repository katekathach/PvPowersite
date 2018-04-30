<?
	
	require_once('includes/class.phpmailer.php');
	$mail = new PHPMailer(); // defaults to using php "mail()"
        $body = "Thank you for using PV Powersite. Make sure to click the 'Add to Basket' link in order to connect to our online store. The documentation generated from the site can be used for permitting purposes.  Should you have technical issues with this site, please send screen shots and/or descriptions to <a href='mailto:marketing@schletter.us'>marketing@schletter.us</a>. 
		";

        $mail->AddReplyTo("marketing@schletter.us","PV Powersite");
        $mail->SetFrom('marketing@schletter.us', 'PV Powersite ');
			
			
		
		if(isset($_GET['pdf_email_geotech']) ){
				//echo "email sent";
				$address = "marketing@schletter.us";
				$Bcc = "kateka.thach@schletter.us";	
				$cc  = "kateka.thach@schletter.us";
			 
		}else{
			 $address = $email;
			 $cc = $saleemail;
			 $Bcc = "wesley.babers@schletter.us";	
		}
       
	   
       // $address = $email;
		//$cc = $saleemail;
        $mail->AddAddress($address);
		$mail->AddCC($cc); 
		$mail->AddBCC($Bcc);       
        $mail->Subject    = "FS System Report";       
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->Body=$body;
        //documentation for Output method here: http://www.fpdf.org/en/doc/output.htm       
        // $pdf->Output("Test Invoice.pdf","F");
	    //Output the file as forced download
		//$pdf->Output('files/FS-System-report.pdf', 'F');
       // $path = "files/FS-System-report.pdf";

       // $mail->AddAttachment($path, '', $encoding = 'base64', $type = 'application/pdf');
        global $message;
        if(!$mail->Send()) {
          $message =  "Summary could not be send. Mailer Error: " . $mail->ErrorInfo;
        } else {
		$message = "Summary";
		//sleep(5);
		//header("Location: http://secure.schletter.us/standard/form.php?$message");
		//die();
        //echo  $message = "Summary sent!";
		//'FS '.$cell.' Cell '.$fstilt.' 2V '.$fswind.'mph '.$code_substr.''.$seis.'.pdf';					
			//$pdf->Output('files/FS-System-report.pdf', 'I');
		}


?>
