<?php
class ControllerAccountPasswordSuccess extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === true )
    {

      //------------------------------------------------------------------------
      // Customer logged, regirect to account page
      //------------------------------------------------------------------------

      // Redirect to account
      $this->response->Redirect( $this->url->link( 'account/account', '', 'SSL' ) );

    } 
    else 
    {

      //------------------------------------------------------------------------
      // Customer not logged
      //------------------------------------------------------------------------

      if ( isset($this->session->data['password_success']) === false )
      {

        //----------------------------------------------------------------------
        // Customer not logged, regirect to login page
        //----------------------------------------------------------------------

        // Redirect to login page
        $this->response->Redirect( $this->url->link( 'account/account', '', 'SSL' ) );

      }
      else
      {

        //----------------------------------------------------------------------
        // Customer logged
        //----------------------------------------------------------------------

        // Load messages
        $this->messages->Load( $this->data, 'account', 'password_success', 'index', $this->language->Get_Language_Code() );

        // Set document properties
        $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
        $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
        $this->response->setKeywords( '' );
        $this->response->setRobots( 'index, follow' );

        // Add styles

        // Set page template
        $this->children = array(
          'common/footer',
          'common/header'
        );

        unset( $this->session->data[ 'password_success' ] );

      }
      
    }
 
  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>