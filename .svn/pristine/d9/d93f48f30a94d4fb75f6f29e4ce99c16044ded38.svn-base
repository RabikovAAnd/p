<?php
class ModelAccountCommunication extends Model 
{

  //----------------------------------------------------------------------------
  // Add new communication channel to database
  //----------------------------------------------------------------------------

  public function addChannel( $email, $contact_id = 0 )
  {

    // Compose SQL query
    $sql = "INSERT INTO communication_channels SET contact_id=" . (int)$contact_id . ", status='new', email='" . $email . "'";

    // Execute SQL query
    $this->db->query( $sql );

/*
    // Compose SQL query
    $sql = "INSERT INTO communication_channel_actions SET channel_id=" . (int)$channel_id . ", action='create'";

    // Execute SQL query
    $this->db->query($sql);
*/

  }

  //----------------------------------------------------------------------------
  // 
  //----------------------------------------------------------------------------
  
  public function actionVerify( $channel_id )
  {

    // Compose SQL query
    $sql = "UPDATE communication_channels SET status='passive' WHERE id=" . (int)$channel_id;

    // Execute SQL query
    $this->db->query($sql);

    // Compose SQL query
    $sql = "INSERT INTO communication_channel_actions SET channel_id=" . (int)$channel_id . ", action='verifivation'";

    // Execute SQL query
    $this->db->query($sql);

  }

  //----------------------------------------------------------------------------
  // Change communication channel to active subscribed status
  //----------------------------------------------------------------------------
  
  public function actionSubscribe( $channel_id )
  {

    // Compose SQL query
    $sql = "UPDATE communication_channels SET status='active' WHERE id=" . (int)$channel_id;

    // Execute SQL query
    $this->db->query($sql);

    // Compose SQL query
    $sql = "INSERT INTO communication_channel_actions SET channel_id=" . (int)$channel_id . ", action='invalidation'";

    // Execute SQL query
    $this->db->query($sql);

  }

  //----------------------------------------------------------------------------
  // Change communication channel to inactive subscribed status
  //----------------------------------------------------------------------------

  public function actionUnsubscribe( $channel_id )
  {

    // Compose SQL query
    $sql = "UPDATE communication_channels SET status='inactive' WHERE id=" . (int)$channel_id;

    // Execute SQL query
    $this->db->query($sql);

    // Compose SQL query
    $sql = "INSERT INTO communication_channel_actions SET channel_id=" . (int)$channel_id . ", action='unsubscription'";

    // Execute SQL query
    $this->db->query($sql);

  }

  //----------------------------------------------------------------------------
  // Change communication channel to invalid state
  //----------------------------------------------------------------------------

  public function actionInvalidate( $channel_id )
  {

    // Compose SQL query
    $sql = "UPDATE communication_channels SET status='invalid' WHERE id=" . (int)$channel_id;

    // Execute SQL query
    $this->db->query($sql);

    // Compose SQL query
    $sql = "INSERT INTO communication_channel_actions SET channel_id=" . (int)$channel_id . ", action='invalidation'";

    // Execute SQL query
    $this->db->query($sql);

  }

  //----------------------------------------------------------------------------
  // Get communication channel by hash
  //----------------------------------------------------------------------------
  
  public function getChannelByHash( $hash )
  {

    // Compose SQL query
    $sql = "SELECT channel_id FROM communication_messages WHERE hash='" . $this->db->escape( $hash ) . "' LIMIT 1";

    // Execute SQL query
    $result = $this->db->query( $sql );

    $channel_id = '';
    if ( isset( $result->row[ 'channel_id' ] ) )
    {

      // Set channel id
      $channel_id = $result->row[ 'channel_id' ];

    }

    // Return id
    return( $channel_id );

  }

  //----------------------------------------------------------------------------
  // Get communication channel identifier by email
  //----------------------------------------------------------------------------
  
  public function Get_Channel_By_Email( $email='' )
  {

    // Test email for validity
    if ( $email == '' )
    {
      
      // Set default data
      $data[ 'valid' ] = false;
      $data[ 'id' ] = 0;
      
    }
    else
    {

      // Compose SQL query
      $sql = "SELECT id FROM communication_channels WHERE email='" . $this->db->escape( $email ) . "' LIMIT 1";

      // Execute SQL query
      $result = $this->db->query( $sql );
      
      // Test record count
      if ( $result->num_rows != 1 )
      {

        // Set default data
        $data[ 'valid' ] = false;
        $data[ 'id' ] = 0;
        
      }
      else
      {

        // Set default data
        $data[ 'valid' ] = true;
        $data[ 'id' ] = $result->row[ 'id' ];

      }
      
      // Return data
      return( $data );
      
    }
    
  }
  
  //----------------------------------------------------------------------------
  // Create message
  //----------------------------------------------------------------------------
  // $message[ 'channel_id' ]
  // $message[ 'headline' ]
  // $message[ 'body' ]
  
  public function addMessage( $message )
  {

    // Generate 32 symbol uniquie hash
    $hash = token( 32 );

    // Compose SQL query
    $sql = "INSERT INTO communication_messages SET ";
    $sql .= "channel_id=" . (int)$message[ 'channel_id' ] . ", ";
    $sql .= "status='compose', ";
    $sql .= "priority=0, ";
    $sql .= "hash='" . $hash . "', ";
    $sql .= "headline='" . $message[ 'headline' ] . "', ";
    $sql .= "body='" . $message[ 'body' ] . "'";

    // Execute SQL query
    $this->db->query( $sql );
    
    // Compose SQL query
    $sql = "SELECT id FROM communication_messages WHERE hash='" . $hash . "' LIMIT 1";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Check for valid id
    if ( isset( $result->row[ 'id' ] ) == false )
    {
      
      //------------------------------------------------------------------------
      // ERROR: Message noz found
      //------------------------------------------------------------------------

      // Set default data
      $data[ 'valid' ] = false;
      $data[ 'message_id' ] = 0;
      
    }
    else
    {

      //------------------------------------------------------------------------
      // Message found, continue processing
      //------------------------------------------------------------------------

      // Get message ID
      $message_id = $result->row[ 'id' ];

      // Set data
      $data[ 'valid' ] = true;
      $data[ 'message_id' ] = $message_id;

      //------------------------------------------------------------------------

      // Add message attachments
      // ToDo

      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "UPDATE communication_messages SET ";
      $sql .= "status='ready' ";
      $sql .= "WHERE id='" . (int)$message_id . "'";

      // Execute SQL query
      $this->db->query( $sql );

    }

    // Return message data
    return( $data );

  }

  //----------------------------------------------------------------------------
  // Get messages
  //----------------------------------------------------------------------------

  public function getMessagesByStatus( $status, $limit )
  {

    // Compose SQL query
    $sql = "SELECT id FROM communication_messages WHERE status='" . $status . "' LIMIT " . (int)$limit;

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Return rows
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Send message
  //----------------------------------------------------------------------------
  // $settings[ 'mail_protocol' ]
  // $settings[ 'mail_parameter' ]
  // $settings[ 'smtp_host' ]
  // $settings[ 'smtp_username' ]
  // $settings[ 'smtp_password' ]
  // $settings[ 'smtp_port' ]
  // $settings[ 'smtp_timeout' ]
  // $settings[ 'mail_from' ]
  // $settings[ 'mail_sender' ]
  
  public function actionSendMessage( $message_id, $settings )
  {

    // Test settings presentce
    if ( isset( $settings ) == false )
    {

      //------------------------------------------------------------------------
      // Settings not setted, use settings from configuration
      //------------------------------------------------------------------------

      $settings[ 'mail_protocol' ] = $this->config->get( 'config_mail_protocol' );
      $settings[ 'mail_parameter' ] = $this->config->get( 'config_mail_parameter' );
      $settings[ 'smtp_host' ] = $this->config->get( 'config_smtp_host' );
      $settings[ 'smtp_username' ] = $this->config->get( 'config_smtp_username' );
      $settings[ 'smtp_password' ] = $this->config->get( 'config_smtp_password' );
      $settings[ 'smtp_port' ] = $this->config->get( 'config_smtp_port' );
      $settings[ 'smtp_timeout' ] = $this->config->get( 'config_smtp_timeout' );
      $settings[ 'mail_from' ] = $this->config->get( 'shop_email' );
      $settings[ 'mail_sender' ] = 'ANVILEX';

    }
    
    // Compose SQL query
    $sql = "SELECT cm.id, cm.channel_id, cm.hash, cm.headline, cm.body, cc.email FROM communication_messages cm LEFT JOIN communication_channels cc ON cm.channel_id=cc.id WHERE cm.id=" . (int)$message_id . " LIMIT 1";

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Check for valid id
    if ( isset($query->row ) )
    {

      // Get message data
      $message_id = $query->row[ 'id' ];
      $message_hash = $query->row[ 'hash' ];
      $message_headline = $query->row[ 'headline' ];
      $message_body = $query->row[ 'body' ];
      $channel_id = $query->row[ 'channel_id' ];
      $channel_email = $query->row[ 'email' ];

      //------------------------------------------------------------------------

      // Create email object
      $mail = new Mail();

      $mail->protocol = $settings[ 'mail_protocol' ];
      $mail->parameter = $settings[ 'mail_parameter' ];
      $mail->hostname = $settings[ 'smtp_host' ];
      $mail->username = $settings[ 'smtp_username' ];
      $mail->password = $settings[ 'smtp_password' ];
      $mail->port = $settings[ 'smtp_port' ];
      $mail->timeout = $settings[ 'smtp_timeout' ];

      $mail->setTo( $channel_email );
      $mail->setFrom( $settings[ 'mail_from' ] );
      $mail->setSender( $settings['mail_sender'] );

      $mail->setSubject( html_entity_decode( $message_headline, ENT_QUOTES, 'UTF-8' ) );
//      $mail->setText(strip_tags(html_entity_decode($message_body, ENT_QUOTES, 'UTF-8')));
      $mail->setText( html_entity_decode( $message_body, ENT_QUOTES, 'UTF-8' ) );

      // Send email
      $mail->send();

      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "INSERT INTO communication_channel_actions SET ";
      $sql .= "channel_id=" . (int)$channel_id . ", ";
      $sql .= "action='messaging', ";
      $sql .= "hash='" . $message_hash . "', ";
      $sql .= "message_id=" . (int)$message_id;

      // Execute SQL query
      $this->db->query( $sql );

      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "UPDATE communication_messages SET ";
      $sql .= "status='processed' ";
      $sql .= "WHERE id='" . (int)$message_id . "'";

      // Execute SQL query
      $this->db->query( $sql );

    }
  
  }

  //----------------------------------------------------------------------------

}
?>