<?php
class ModelCompanyContact extends Model 
{

  //----------------------------------------------------------------------------
  // Add new customer
  //----------------------------------------------------------------------------

	public function addCustomer( $data )
	{
/*
    // Compose SQL query
    $sql = "INSERT INTO customer SET ";
    $sql .= "firstname='" . $this->db->escape($data['firstname']) . "', ";
    $sql .= "lastname='" . $this->db->escape($data['lastname']) . "', ";
    $sql .= "email='" . $this->db->escape($data['email']) . "', ";
    $sql .= "telephone='" . $this->db->escape($data['telephone']) . "', ";
    $sql .= "fax='" . $this->db->escape($data['fax']) . "', ";
    $sql .= "salt='" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', ";
    $sql .= "password='" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', ";
    $sql .= "newsletter='" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ";
    $sql .= "ip='" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', ";
    $sql .= "status='1', ";
    $sql .= "approved='1', ";
    $sql .= "date_added=NOW()";
    
    // Query database
    $this->db->query( $sql );
    
    // Get customer ID
		$customer_id = $this->db->getLastId();

    // Compose SQL query
    $sql = "INSERT INTO address SET ";
    $sql .= "customer_id = '" . (int)$customer_id . "', ";
    $sql .= "firstname = '" . $this->db->escape($data['firstname']) . "', ";
    $sql .= "lastname = '" . $this->db->escape($data['lastname']) . "', ";
    $sql .= "company = '" . $this->db->escape($data['company']) . "', ";
    $sql .= "company_id = '" . $this->db->escape($data['company_id']) . "', ";
    $sql .= "tax_id = '" . $this->db->escape($data['tax_id']) . "', ";
    $sql .= "address_1 = '" . $this->db->escape($data['address_1']) . "', ";
    $sql .= "address_2 = '" . $this->db->escape($data['address_2']) . "', ";
    $sql .= "city = '" . $this->db->escape($data['city']) . "', ";
    $sql .= "postcode = '" . $this->db->escape($data['postcode']) . "', ";
    $sql .= "country_id = '" . (int)$data['country_id'] . "', ";
    $sql .= "zone_id = '" . (int)$data['zone_id'] . "'";

    // Query database
    $this->db->query( $sql );

    // Get address ID
		$address_id = $this->db->getLastId();

    // Compose SQL query
    $sql = "UPDATE customer SET address_id=" . (int)$address_id . " WHERE customer_id=" . (int)$customer_id;

    // Query database
    $this->db->query( $sql );

		//--------------------------------------------------------------------------
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message = $this->language->get('text_welcome') . "\n\n"; 
		
		$message .= $this->language->get('text_login') . "\n\n"; 
		
		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n\n"; 
		$message .= $this->config->get('config_name');
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();

		//--------------------------------------------------------------------------

		// Send to main admin email if new account email is enabled
		if ( $this->config->get('config_account_mail') ) 
		{

			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . $this->config->get('config_name') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			$message .= $this->language->get('text_customer_group') . " \n";
			
			if ($data['company']) {
				$message .= $this->language->get('text_company') . ' '  . $data['company'] . "\n";
			}
			
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";
			
			$mail->setTo($this->config->get('config_email'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
			
			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_emails'));
			
			foreach ($emails as $email) 
			{
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) 
				{
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
*/
	}

  //----------------------------------------------------------------------------

	public function Is_Exists( $email = '' )
	{

		// Trim email address
		$email = trim( $email );

		// Compose SQL query
		$sql = "SELECT customer_id FROM customer_copy WHERE email='" . $this->db->escape( $email ) . "' LIMIT 1";

		// Query database
		$result = $this->db->query( $sql );

		// Test record count
		if ( $result->num_rows == 0 )
		{
			// Set error code
			$return_code = false;

		}
		else
		{

			// Set success code
			$return_code = true;

		}

		// Return status
		return( $return_code );

	}

	public function findCustomerId($email){
		$sql = "SELECT customer_id FROM customer_copy WHERE email='" . $this->db->escape( $email ) . "' LIMIT 1";
		$result = $this->db->query( $sql );
		return $result->rows[0]['customer_id'];
	}

	public function userHasChat($customer_id, $admin_id = 1){
		$sql = "SELECT chat_id, count(chat_id) FROM messenger WHERE user_id = ";
		$sql .= $this->db->escape($customer_id);
		$sql .= " OR user_id = ";
		$sql .= $this->db->escape($admin_id);
		$sql .= " GROUP BY chat_id";
		$sql .= " HAVING count(chat_id) > 1";

		$result = $this->db->query( $sql );

		if( $result->num_rows == 0){
			$result = NULL;
		}else{
			$result = $result->rows[0]['chat_id'];
		}

		return $result;
		//Add length test
	}

	public function createCustomer($data){
		$sql = "INSERT INTO customer_copy SET ";
		$sql .= "email='" . $this->db->escape($data['email']) . "', ";
		$sql .= "password='" . $this->db->escape(password_hash($data['password'], PASSWORD_DEFAULT ) ). "', ";
		$sql .= "ip='" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', ";
		$sql .= "newsletter='" . ($data['newsletter'] === 'true' ? 1 : 0) . "', ";
		$sql .= "status='1', ";
		$sql .= "approved='1', ";
		$sql .= "date_added=NOW()";


		$this->db->query( $sql );
		$customer_id = $this->db->query( "SELECT customer_id FROM customer_copy WHERE email='" . $this->db->escape($data['email'] ) . "' LIMIT 1" );
		return $customer_id->rows[0]['customer_id'];

	}

	public function createChat($customer_id, $admin_id = 1){
		$result = $this->db->query("SELECT chat_id FROM messenger ORDER BY chat_id DESC LIMIT 1");
		if( $result->num_rows == 0){
			$chat_id = 1;
		}else{
			$chat_id = $result->rows[0]['chat_id'];
			$chat_id = $chat_id + 1;
		}

		$sql = "INSERT INTO messenger(chat_id, user_id) VALUES (";
		$sql .= $this->db->escape($chat_id) . ", ";
		$sql .= $this->db->escape($customer_id) . ")";

		// Query database
		$this->db->query( $sql );

		$sql = "INSERT INTO messenger(chat_id, user_id) VALUES (";
		$sql .= $this->db->escape($chat_id) . ", ";
		$sql .= $this->db->escape($admin_id) . ")";

		// Query database
		$this->db->query( $sql );

		// Return status
		return( $chat_id );
	}
	public function addMessage($chat_id, $customer_id, $subject, $message){
		$sql = "INSERT INTO chat_messages(chat_id, user_id, subject, message, message_date, message_time) VALUES (";
		$sql .= $this->db->escape($chat_id) . ", ";
		$sql .= $this->db->escape($customer_id) . ", '";
		$sql .= $this->db->escape($subject) . "', '";
		$sql .= $this->db->escape($message) . "', ";
		$sql .= "CURDATE(), ";
		$sql .= "CURTIME())";

		// Query database
		$this->db->query( $sql );

		// Set success code
		$return_code = true;


		// Return status
		return( $return_code );
	}

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
