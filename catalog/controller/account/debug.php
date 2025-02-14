<?php
class ControllerAccountDebug extends Controller
{

  //----------------------------------------------------------------------------

  public function index() 
  {

    // Load model
    $this->load->model('account/communication');

    $message['channel_id'] = 1;
    $message['headline'] = 'ANVILEX: Email subject';
    $message['body'] = 'Email message body';
    
    $this->model_account_communication->addMessage( $message );

  }

}
?>