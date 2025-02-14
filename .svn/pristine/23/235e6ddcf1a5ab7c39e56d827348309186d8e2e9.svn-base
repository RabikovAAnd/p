<?php
class ControllerAccountForgottenMail extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------
  
  public function index()
  {

    // Test for customer logged
    if ( $this->customer->Is_Logged() === true )
    {

      //------------------------------------------------------------------------
      // Customer already logged
      //------------------------------------------------------------------------

      // Redirect to account
      $this->response->Redirect( $this->url->link( 'account/account', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------
      
      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'forgotten_mail', 'index', $this->language->Get_Language_Code() );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      
      // Set page configuration
      $this->children = array(
        'common/footer',
        'common/header'
      );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>