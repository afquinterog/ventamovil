<?php 
class ZMailHelper{

	
	public static $userName = "etp\fvega";
	public static $password = "Junio2013*";
	public static $email = "telecliente@etp.net.co";
	 
	
	/**
	 * Send a mail using PHPMailer
	 * 
	 * @param string $msg the html message
	 * @param array $recipients an array including the mail recipients
	 * 		        The array is of the form array (
	 * 													(
	 * 													'mail' => 'example@example.com' , 
	 * 													'name'=>'Mr Example' 
	 *													)
	 *												) 
	 * @param array $copyRecipients an array including the mail copy recipients
	 * 				The array is of the form ('mail' => 'example@example.com' , 'name'=>'Mr Example' )
	 */
	public static function sendMail( $msg , $fromMail, $fromName , $subject , $recipients , $copyRecipients = NULL , $attachments = NULL ,
									 $options = NULL 
									 ){
	
		//Import the library
		require_once( JPATH_COMPONENT . DS . 'libraries' . DS . 'phpMailer' . DS . 'class.phpmailer.php' );    
		 
		$options['altbody'] = isset( $options['altbody'] ) ? $options['altbody'] :  "Para ver este mensaje, por favor use un visor HTML!";
									 
		$mail	= new PHPMailer();
		setlocale(LC_TIME, "es_ES");
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "exchange02"; // SMTP server
		$mail->Host       = "172.16.1.28"; // SMTP server
		//$mail->SMTPAuth      = true;                  // enable SMTP authentication
		//$mail->Port          = 587;                    // set the SMTP port for the GMAIL server
		//$mail->Username      = "etp\fvega"; // SMTP account username
		
		//$mail->SMTPSecure = "tls";                 // sets the prefix to the server
		//$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
		                                           // 1 = errors and messages
		                                           // 2 = messages only
		                                          
		//$mail->SetFrom( $user->email , 'Equipo de Servicio al cliente UNE');
		//$mail->Username = self::$userName;
		//$mail->Password = self::$password;
		$mail->email = self::$email;
		
		$mail->SetFrom( $fromMail , $fromName );
		$mail->Subject    = $subject;
		$mail->AltBody    = $options['altbody'] ; 
		//$mail->charSet = "UTF-8";
		//$mail->MsgHTML( $msg );
		$mail->IsHTML(true);
		$mail->Body = $msg ;
		
		//print_r( $recipients );
		if( is_array( $recipients ) ){
		
			foreach( $recipients as $recipient ){
				$mail->AddAddress( $recipient['mail'] , $recipient['name'] );
			}
		}
		
		if( is_array( $copyRecipients ) ){
			foreach( $copyRecipients as $recipient ){
				$mail->AddAddress( $recipient['mail'] , $recipient['name'] );
			}
		}
		
		if( is_array( $attachments ) ) {
			foreach( $attachments as $attachment ){
				$mail->AddAttachment( $attachment );
			}
		}
	
		if( $mail->Send() ){
			return true;
		}
		else{
			return false;
		}				
	}
	
	
	
	
	
	
}



