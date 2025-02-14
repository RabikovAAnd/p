<?php
class ControllerWorkplaceItemsNotFound extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    //----------------------------------------------------------------------
    // Item GUID parameter found, continue processing
    //----------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'items_not_found', 'index', $this->language->Get_Language_Code() );

    //----------------------------------------------------------------------
    // Render page
    //----------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );
    $this->response->setRobots( 'index, follow' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>