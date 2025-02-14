<?php
class ControllerAccountPasswordSent extends Controller
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

      //! @todo ANVILEX KM: Check for password reset request present

      // Load messages
      $this->messages->Load( $this->data, 'account', 'password_sent', 'index', $this->language->Get_Language_Code() );

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'noindex, nofollow' );

      // Add styles

      // Set page template
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