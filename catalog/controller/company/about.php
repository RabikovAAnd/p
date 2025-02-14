<?php
class ControllerCompanyAbout extends Controller
{
     
  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {
    //------------------------------------------------------------------------
    // Set page data
    //------------------------------------------------------------------------

    // Load model
    $this->load->model( 'customers/informations' );

    // Get information
    $this->data[ 'sections' ] = $this->model_customers_informations->Get_Information( 'about', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'company', 'about', 'index', $this->language->Get_Language_Code() );

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
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