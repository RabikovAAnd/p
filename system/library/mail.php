<?php
class Mail 
{

	public $protocol = 'mail';
	public $hostname;
	public $username;
	public $password;
	public $port = 25;
	public $timeout = 5;
	public $newline = "\n";
	public $crlf = "\r\n";
	public $verp = false;
	public $parameter = '';

	protected $to = '';
	protected $from = '';
	protected $sender = '';
	protected $subject = '';
	protected $text = '';
	protected $html = '';
	protected $attachments = array();

  //----------------------------------------------------------------------------
  // Send to
  //----------------------------------------------------------------------------
  
	public function setTo( $to = '' )
	{
    
		$this->to = $to;
	
  }

  //----------------------------------------------------------------------------
  // Send from
  //----------------------------------------------------------------------------

	public function setFrom( $from ) 
	{
    
		$this->from = $from;

  }

  //----------------------------------------------------------------------------
  // Set sender
  //----------------------------------------------------------------------------

	public function setSender( $sender = '' ) 
	{
		$this->sender = $sender;
	}

  //----------------------------------------------------------------------------
  // Set emeil subject
  //----------------------------------------------------------------------------
  
	public function setSubject( $subject = '' ) 
	{
    
		$this->subject = $subject;
	
  }

  //----------------------------------------------------------------------------
  // Set email text
  //----------------------------------------------------------------------------

	public function setText( $text = '' ) 
	{

		$this->text = $text;
	
  }

  //----------------------------------------------------------------------------
  // Set email as HTML
  //----------------------------------------------------------------------------

	public function setHtml( $html = '' ) 
	{

    $this->html = $html;
	
  }

  //----------------------------------------------------------------------------
  // Add attachment
  //----------------------------------------------------------------------------

	public function addAttachment(  $filename ) 
	{
		$this->attachments[] = $filename;
	}

  //----------------------------------------------------------------------------
  // Send email method
  //----------------------------------------------------------------------------

	public function Send()
	{
	  
		if (!$this->to) 
		{
			trigger_error('Error: E-Mail to required!');
			exit();			
		}

		if (!$this->from) 
		{
			trigger_error('Error: E-Mail from required!');
			exit();					
		}

		if (!$this->sender) 
		{
			trigger_error('Error: E-Mail sender required!');
			exit();					
		}

		if (!$this->subject) 
		{
			trigger_error('Error: E-Mail subject required!');
			exit();					
		}

		if ((!$this->text) && (!$this->html)) 
		{
			trigger_error('Error: E-Mail message required!');
			exit();					
		}

		if (is_array($this->to)) 
		{
			$to = implode(',', $this->to);
		} 
		else 
		{
			$to = $this->to;
		}

    //--------------------------------------------------------------------------

		$boundary = '----=_NextPart_' . md5(time());

		$header = '';
		
		$header .= 'MIME-Version: 1.0' . $this->newline;
		
		if ( $this->protocol != 'mail' )
		{
			$header .= 'To: ' . $to . $this->newline;
			$header .= 'Subject: ' . $this->subject . $this->newline;
		}
		
		$header .= 'Date: ' . date('D, d M Y H:i:s O') . $this->newline;
		$header .= 'From: ' . '=?UTF-8?B?' . base64_encode($this->sender) . '?=' . '<' . $this->from . '>' . $this->newline;
		$header .= 'Reply-To: ' . '=?UTF-8?B?' . base64_encode($this->sender) . '?=' . '<' . $this->from . '>' . $this->newline;
		$header .= 'Return-Path: ' . $this->from . $this->newline;
		$header .= 'X-Mailer: PHP/' . phpversion() . $this->newline;
		$header .= 'Content-Type: multipart/related; boundary="' . $boundary . '"' . $this->newline . $this->newline;

		if (!$this->html) 
		{
			$message  = '--' . $boundary . $this->newline;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
			$message .= $this->text . $this->newline;
		} 
		else 
		{
			$message  = '--' . $boundary . $this->newline;
			$message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . $this->newline . $this->newline;
			$message .= '--' . $boundary . '_alt' . $this->newline;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;

			if ($this->text) 
      {
				$message .= $this->text . $this->newline;
			} else {
				$message .= 'This is a HTML email and your email client software does not support HTML email!' . $this->newline;
			}

			$message .= '--' . $boundary . '_alt' . $this->newline;
			$message .= 'Content-Type: text/html; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
			$message .= $this->html . $this->newline;
			$message .= '--' . $boundary . '_alt--' . $this->newline;
		}

    //--------------------------------------------------------------------------
    // Process attachments
    //--------------------------------------------------------------------------
    
		foreach ($this->attachments as $attachment) 
		{
			if (file_exists($attachment)) 
			{
				$handle = fopen($attachment, 'r');
				
				$content = fread($handle, filesize($attachment));
				
				fclose($handle);

				$message .= '--' . $boundary . $this->newline;
				$message .= 'Content-Type: application/octet-stream; name="' . basename($attachment) . '"' . $this->newline;
				$message .= 'Content-Transfer-Encoding: base64' . $this->newline;
				$message .= 'Content-Disposition: attachment; filename="' . basename($attachment) . '"' . $this->newline;
				$message .= 'Content-ID: <' . basename(urlencode($attachment)) . '>' . $this->newline;
				$message .= 'X-Attachment-Id: ' . basename(urlencode($attachment)) . $this->newline . $this->newline;
				$message .= chunk_split(base64_encode($content));
			}
		}

		$message .= '--' . $boundary . '--' . $this->newline;

    //--------------------------------------------------------------------------
    // Send email
    //--------------------------------------------------------------------------

		if ($this->protocol == 'mail') 
		{
      
			ini_set('sendmail_from', $this->from);

			if ($this->parameter) 
			{
				mail( $to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header, $this->parameter );
			} 
			else 
			{
				mail( $to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header );
			}
		
    } 
		elseif ($this->protocol == 'smtp') 
		{
      
			$handle = fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeout);

			if (!$handle) 
			{
				trigger_error('Error: ' . $errstr . ' (' . $errno . ')');
				exit();					
			} 
			else 
			{
				if (substr(PHP_OS, 0, 3) != 'WIN') 
				{
					socket_set_timeout($handle, $this->timeout, 0);
				}

				while ($line = fgets($handle, 515)) 
				{
					if (substr($line, 3, 1) == ' ') 
					{
						break;
					}
				}

				if (substr($this->hostname, 0, 3) == 'tls') 
				{
					fputs($handle, 'STARTTLS' . $this->crlf);

					while ($line = fgets($handle, 515)) 
					{
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') 
						{
							break;
						}
					}

					if (substr($reply, 0, 3) != 220) 
					{
						trigger_error('Error: STARTTLS not accepted from server!');
						exit();								
					}
				}

				if (!empty($this->username)  && !empty($this->password)) 
				{
					fputs($handle, 'EHLO ' . getenv('SERVER_NAME') . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) 
					{
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') 
						{
							break;
						}
					}

					if (substr($reply, 0, 3) != 250) 
					{
						trigger_error('Error: EHLO not accepted from server!');
						exit();								
					}

					fputs($handle, 'AUTH LOGIN' . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) 
					{
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') 
						{
							break;
						}
					}

					if (substr($reply, 0, 3) != 334) 
					{
						trigger_error('Error: AUTH LOGIN not accepted from server!');
						exit();						
					}

					fputs($handle, base64_encode($this->username) . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) 
					{
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') 
						{
							break;
						}
					}

					if (substr($reply, 0, 3) != 334) 
					{
						trigger_error('Error: Username not accepted from server!');
						exit();								
					}

					fputs($handle, base64_encode($this->password) . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) 
					{
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') 
						{
							break;
						}
					}

					if (substr($reply, 0, 3) != 235) 
					{
						trigger_error('Error: Password not accepted from server!');
						exit();
					}
					
				} 
				else 
				{
				  
					fputs($handle, 'HELO ' . getenv('SERVER_NAME') . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) 
					{
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') 
						{
							break;
						}
					}

					if (substr($reply, 0, 3) != 250) 
					{
						trigger_error('Error: HELO not accepted from server!');
						exit();
					}
					
				}

				if ($this->verp) 
				{
					fputs($handle, 'MAIL FROM: <' . $this->from . '>XVERP' . $this->crlf);
				} 
				else 
				{
					fputs($handle, 'MAIL FROM: <' . $this->from . '>' . $this->crlf);
				}

				$reply = '';

				while ($line = fgets($handle, 515)) 
				{
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') 
					{
						break;
					}
				}

				if (substr($reply, 0, 3) != 250) 
				{
					trigger_error('Error: MAIL FROM not accepted from server!');
					exit();							
				}

				if (!is_array($this->to)) 
				{
					fputs($handle, 'RCPT TO: <' . $this->to . '>' . $this->crlf);

					$reply = '';

					while ($line = fgets($handle, 515)) 
					{
						$reply .= $line;

						if (substr($line, 3, 1) == ' ') 
						{
							break;
						}
					}

					if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) 
					{
						trigger_error('Error: RCPT TO not accepted from server!');
						exit();							
					}
				} 
				else 
				{
					foreach ($this->to as $recipient) 
					{
						fputs($handle, 'RCPT TO: <' . $recipient . '>' . $this->crlf);

						$reply = '';

						while ($line = fgets($handle, 515)) 
						{
							$reply .= $line;

							if (substr($line, 3, 1) == ' ') 
							{
								break;
							}
						}

						if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) 
						{
							trigger_error('Error: RCPT TO not accepted from server!' );
							exit();								
						}
					}
				}

				fputs($handle, 'DATA' . $this->crlf);

				$reply = '';

				while ($line = fgets($handle, 515)) 
				{
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') 
					{
						break;
					}
				}

				if (substr($reply, 0, 3) != 354) 
				{
					trigger_error('Error: DATA not accepted from server!');
					exit();						
				}
            	
				// According to rfc 821 we should not send more than 1000 including the CRLF
				$message = str_replace("\r\n", "\n",  $header . $message);
				$message = str_replace("\r", "\n", $message);
				
				$lines = explode("\n", $message);
				
				foreach ($lines as $line) 
				{
					$results = str_split($line, 998);
					
					foreach ($results as $result) {
						if (substr(PHP_OS, 0, 3) != 'WIN') 
						{
							fputs($handle, $result . $this->crlf);
						} 
						else 
						{
							fputs($handle, str_replace("\n", "\r\n", $result) . $this->crlf);
						}							
					}
				}
				
				fputs($handle, '.' . $this->crlf);

				$reply = '';

				while ($line = fgets($handle, 515)) 
				{
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') 
					{
						break;
					}
				}

				if (substr($reply, 0, 3) != 250) 
				{
					trigger_error('Error: DATA not accepted from server!');
					exit();						
				}
				
				fputs($handle, 'QUIT' . $this->crlf);

				$reply = '';

				while ($line = fgets($handle, 515)) 
				{
					$reply .= $line;

					if (substr($line, 3, 1) == ' ') 
					{
						break;
					}
				}

				if (substr($reply, 0, 3) != 221) 
				{
					trigger_error('Error: QUIT not accepted from server!');
					exit();						
				}

				fclose( $handle );
				
			}
		}
	}
  
  //----------------------------------------------------------------------------
  // Email validation
  //----------------------------------------------------------------------------
  
  public function Is_Email_Valid( $Email_Address ) : bool
  {
    
    $Email_Address_Trimmed = trim( $Email_Address );
    
    if ( $Email_Address_Trimmed === '' ) 
    {
      
      return( false );
    
    }
    else
    {

      if ( ! filter_var( $Email_Address_Trimmed, FILTER_VALIDATE_EMAIL ) ) 
      {
        
        return( false );
      
      } 
      else 
      { 

        $atPos = strpos( $Email_Address_Trimmed, '@' );
        $domain = substr( $Email_Address_Trimmed, $atPos + 1);
    
        if ( !checkdnsrr( $domain, 'MX' ) ) 
        {
          
          return( false );
        
        } 
        else 
        {
          
          return( true );
        
        }
      
      }
      
    }

  }
  
}

//------------------------------------------------------------------------------

/*
<?php

# What to do if the class is being called directly and not being included in a script     via PHP
# This allows the class/script to be called via other methods like JavaScript

if(basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])){
$return_array = array();

if($_GET['address_to_verify'] == '' || !isset($_GET['address_to_verify'])){
    $return_array['error']              = 1;
    $return_array['message']            = 'No email address was submitted for verification';
    $return_array['domain_verified']    = 0;
    $return_array['format_verified']    = 0;
}else{
    $verify = new EmailVerify();

    if($verify->verify_formatting($_GET['address_to_verify'])){
        $return_array['format_verified']    = 1;

        if($verify->verify_domain($_GET['address_to_verify'])){
            $return_array['error']              = 0;
            $return_array['domain_verified']    = 1;
            $return_array['message']            = 'Formatting and domain have been verified';
        }else{
            $return_array['error']              = 1;
            $return_array['domain_verified']    = 0;
            $return_array['message']            = 'Formatting was verified, but verification of the domain has failed';
        }
    }else{
        $return_array['error']              = 1;
        $return_array['domain_verified']    = 0;
        $return_array['format_verified']    = 0;
        $return_array['message']            = 'Email was not formatted correctly';
    }
}

echo json_encode($return_array);

exit();
}

class EmailVerify 
{

public function __construct()
{
}

public function verify_domain($address_to_verify)
{
    // an optional sender  
    $record = 'MX';
    list($user, $domain) = explode('@', $address_to_verify);
    return checkdnsrr($domain, $record);
}

public function verify_formatting($address_to_verify)
{
    if(strstr($address_to_verify, "@") == FALSE){
        return false;
    }else{
        list($user, $domain) = explode('@', $address_to_verify);

        if(strstr($domain, '.') == FALSE){
            return false;
        }else{
            return true;
        }
    }
    }
}
?>
*/

//------------------------------------------------------------------------------
// Usage
//------------------------------------------------------------------------------

/*
// Include library file
require_once 'VerifyEmail.class.php'; 

// Initialize library class
$mail = new VerifyEmail();

// Set the timeout value on stream
$mail->setStreamTimeoutWait(20);

// Set debug output mode
$mail->Debug= TRUE; 
$mail->Debugoutput= 'html'; 

// Set email address for SMTP request
$mail->setEmailFrom('from@email.com');

// Email to check
$email = 'email@example.com'; 

// Check if email is valid and exist
if($mail->check($email)){ 
    echo 'Email &lt;'.$email.'&gt; is exist!'; 
}elseif(verifyEmail::validate($email)){ 
    echo 'Email &lt;'.$email.'&gt; is valid, but not exist!'; 
}else{ 
    echo 'Email &lt;'.$email.'&gt; is not valid and not exist!'; 
} 
*/

//------------------------------------------------------------------------------


//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>