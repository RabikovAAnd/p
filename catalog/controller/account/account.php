<?php
class ControllerAccountAccount extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------
      
      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------
      
      // Load messages
      $this->messages->Load( $this->data, 'account', 'account', 'index', $this->language->Get_Language_Code() );

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'account/menu',
        'common/header'
      );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>