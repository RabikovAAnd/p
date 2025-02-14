<?php
class ControllerAccountTrigger extends Controller
{

  //----------------------------------------------------------------------------
  
  public function index() 
  {

    // Load model
    $this->load->model('account/communication');

    // Assign email object settings
    $settings['mail_protocol'] = $this->config->get('config_mail_protocol');
    $settings['mail_parameter'] = $this->config->get('config_mail_parameter');
    $settings['smtp_host'] = $this->config->get('config_smtp_host');
    $settings['smtp_username'] = $this->config->get('config_smtp_username');
    $settings['smtp_password'] = $this->config->get('config_smtp_password');
    $settings['smtp_port'] = $this->config->get('config_smtp_port');
    $settings['smtp_timeout'] = $this->config->get('config_smtp_timeout');
    $settings['mail_from'] = $this->config->get('config_smtp_from');
    $settings['mail_sender'] = $this->config->get('config_smtp_sender');

    // Check for message id parameter present
    if ( isset($this->request->get['id']) )
    {

      // Get message id
      $message_id = $this->request->get['id'];

      // ANVILEX KM: ToDo ==> Check for id is integer

      // Send message
      $this->model_account_communication->actionSendMessage( $settings, $message_id );

    }
    else
    {

      // Test limit parameter
      if ( isset($this->request->get['limit']) )
      {
        $limit = $this->request->get['limit'];
      }
      else
      {
        $limit = 2;
      }

      // ANVILEX KM: ToDo ==> Check for limit is integer

      // Send messages
      $messages = $this->model_account_communication->getMessagesByStatus( 'forward', $limit );

      // Iterate over all messages
      foreach( $messages as $message )
      {

        // Get message id
        $message_id = $message['id'];

        // Send message
        $this->model_account_communication->actionSendMessage( $settings, $message_id );

      }

    }

  }

}
?>
