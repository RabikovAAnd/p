<?php

class ControllerCompanyTerms extends Controller
{

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'company', 'terms', 'index', $this->language->Get_Language_Code() );

    // Set data
    $this->data[ 'text_message_header' ] = $this->language->get('text_header');
    $this->data[ 'text_message_body' ] = $this->language->get('text_body');

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------
    
    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setKeywords('');
    $this->response->setRobots('index, follow');

    // Add styles

    // Set page sections
    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>