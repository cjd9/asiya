<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mastermodel extends MY_Model
{
	 public function __construct()
    {
		parent::__construct();
	}
	
	// function to send email -
	function send_mail($to_email, $to_name, $sub, $msg, $attachment = '', $is_cc = '')
	{
		/*	
			Date		:	16-09-2015
			Ref			:	http://www.learn2crack.com/2014/03/sending-mail-phpmailer.html
		
			Note 		: 	1.	Uncomment extension=php_openssl.dll in php.ini of Wamp server
				
							2.	Put PHPMailerlibrary folder in application folder of CI
		
			Ref			:	http://stackoverflow.com/questions/18064612/how-to-enable-phps-openssl-extension-to-install-composer
			
			Update Date : 	16-09-2015
		*/
		
		require_once(APPPATH.'PHPMailer/PHPMailerAutoload.php');
 
		$mail = new PHPMailer;
		
		$mail->isSMTP();
		$mail->Host = 'mail.asiya.co.in';
		$mail->SMTPAuth = true;
		$mail->Username = 'contact@asiya.co.in';
		$mail->Password = 'asiya@1234';
		$mail->SMTPSecure = 'tls';
		 
		$mail->From = 'contact@asiya.co.in';
		$mail->FromName = 'Asiya Center of Physiotherapy & Rehabilitation';
		$mail->addAddress($to_email, $to_name);
		 
		$mail->addReplyTo('contact@asiya.co.in', 'Asiya Center of Physiotherapy & Rehabilitation');
		
		// check if CC -
		if($is_cc != '')
		{
			$mail->addCC('dhairav.shah@hotmail.com');
		}
		
		// check if attachment -
		if($attachment != '')
		{
			$mail->addAttachment($attachment);         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		}
		 
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		 
		$mail->Subject = $sub;
		$mail->Body    = $msg;
		 
		if(!$mail->send())
		{
		  /* echo 'Message could not be sent.';
		   echo 'Mailer Error: ' . $mail->ErrorInfo;
		   exit;*/
		   
		   return false;
		}
		else
		{
			//$mail->ClearAllRecipients(); 
    		//$mail->ClearAttachments();   //Remove all attachements
		
			return true;
		}
	}
	
	// function to send sms -
	function send_sms($mobile_no, $name, $msg)
	{
		// http://sms6.routesms.com/client/login.php

		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
				
		// Replace with your username
		$user = "asiyac";
		$pass = "asi65yac";
		
		// Replace with your Message content
		$message = urlencode($msg);
		
		// url syntax -
				//http://121.241.242.121/bulksms/bulksms?username=xxxxxxx&password=xxxxxx&type=0&dlr=1&destination=91xxxxxxxx&source=asiyac&message=xxxxxxx
				
		// send sms -
		$ch = curl_init("http://121.241.242.121/bulksms/bulksms?username=".$user."&password=".$pass."&type=0&dlr=1&destination=".$mobile_no."&source=asiyac&message=".$message); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);      
			curl_close($ch); 
		
		//$output = file_get_contents("http://103.16.101.52/sendsms/bulksms?username=".$user."&password=".$pass."&type=0&dlr=1&destination=".$mobile_no."&source=routesms&message=".$message);
		
		// check -
		//http://121.241.242.121/bulksms/bulksms?username=asiyac&password=asi65yac&type=0&dlr=1&destination=8087084381&source=asiyac&message=hello
		
		// get response of the successful sms push -
		$result = explode('|', $output);	// make error_code and mobile_no:msg id separate from response
		
		$error_code = $result[0];
		
		$res = array();
		
		$res['error_code'] = $error_code;	// error code
		
		// if error code is 1701 means success -
		if($error_code == "1701")
		{
			$result1 = explode(':', $result[1]);	// make mobile_no and msg_id separate from response
			
			$res['msg_id'] = $result1[1];
		}
		
		//var_dump($res);
		
		//return $res;
		
		return $res['msg_id'];
	}
}