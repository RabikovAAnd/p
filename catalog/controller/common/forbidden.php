<?php
class ControllerErrorForbidden extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    // Set page headline
    $this->data[ 'heading_title' ] = $this->language->get( 'common_error403_page_heading' );

    // Set error message
    $this->data[ 'message_text' ] = $this->language->get( 'common_error403_page_message' );

    //--------------------------------------------------------------------------

    // Set document title
    $this->response->setTitle( $this->language->get( 'common_error403_document_title' ) );
    $this->response->setDescription( '' );
    $this->response->setKeywords( '' );
    
    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

    // Set header 403 respone code
    $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 403 forbidden' );

  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>