<?php

class ControllerAccountLogout extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer logged out
    if ( $this->customer->Is_Logged() === false ) 
    {

      //------------------------------------------------------------------------
      // Customer is not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    } 
    else 
    {

      //------------------------------------------------------------------------
      // Customer is logged in, perform logout
      //------------------------------------------------------------------------

      // Logout
      $this->customer->Logout();

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'logout', 'index', $this->language->Get_Language_Code() );

      // Set page data
      $this->data[ 'account_logout_home_href' ] = $this->url->link( 'common/home', '', 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/logout.css' );

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