<?php
class ControllerAccountUnsubscribe extends Controller
{

  //! @todo ANVILEX KM: Is this file used!!!
  
  public function index()
  {

    // Load model
    $this->load->model( 'account/communication' );

    // Set documet properties
    $this->response->setTitle( $this->language->get('text_document_title') );
    $this->response->setDescription( $this->language->get('text_document_metadescription') );
    $this->response->setRobots( 'noindex, follow' );

    // Check for hash parameter present
    if ( isset($this->request->get[ 'hash' ]) )
    {

      // Get hash
      $hash = $this->request->get['hash'];

      // Try to resolve communication channel id
      $channel_id = $this->model_account_communication->getChannelByHash( $hash );

      // Test for valid channel
      if ( $channel_id != '' )
      {

        // Unsubscribe communication channel
        $this->model_account_communication->actionUnsubscribe( $channel_id );

        // Optional: Send unsubscribe emeil

      }

    }

    // Set data
    $this->data['text_message_header'] = $this->language->get('headline_news_unsubscription');
    $this->data['text_message_body'] = $this->language->get('text_news_unsubscription');

    // Set page sections
    $this->children = array(
      'common/footer',
      'common/header'
    );

	}

}
?>