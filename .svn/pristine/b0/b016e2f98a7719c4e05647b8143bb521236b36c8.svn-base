<?php
class ControllerCompanyCareers extends Controller
{

  //----------------------------------------------------------------------------
  
  public function index()
  {
    //------------------------------------------------------------------------
    // Set page data
    //------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'company', 'careers', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setRobots( 'index, follow' );

    // Add styles
    
    // Set page configuration
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