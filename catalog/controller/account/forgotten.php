<?php
class ControllerAccountForgotten extends Controller
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

      // Load messages
      $this->messages->Load( $this->data, 'account', 'forgotten', 'index', $this->language->Get_Language_Code() );

      // Set links
      $this->data[ 'send_link_button_href' ] = $this->url->Link( 'account/forgotten/send_link', '', 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/forgotten.css' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'common/header'
      );

    }

  }

  //----------------------------------------------------------------------------
  // Send password restore email
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function send_link()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load( $this->data, 'account', 'forgotten', 'sendPassword', $this->language->Get_Language_Code() );

    // Test for email parameter exists and valid
    if ( $this->request->Is_POST_Parameter_Email( 'email' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: No parameter present
      //------------------------------------------------------------------------

      // Set error code
      $json[ 'error' ][ 'email' ] = $this->data[ 'account_forgotten_invalid_email_format_error' ];

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter present and valid
      //------------------------------------------------------------------------

      // Get email
      $email = $this->request->Get_POST_Parameter_As_String( 'email' );

      // Test for customer account exists
      if ( $this->customer->Is_Exists( $email ) === false )
      {

        //--------------------------------------------------------------------
        // ERROR: Contact not found
        //--------------------------------------------------------------------

        // Set redirect link
        // Note: Requered to redirect to link sent page to prevent email tracking
        $json[ 'redirect_url' ] = $this->url->link( 'account/password_sent', '', 'SSL' );

        // Set success code
        // Note: Requered to send success code to prevent email tracking
        $json[ 'return_code' ] = true;

      }
      else
      {

        //--------------------------------------------------------------------
        // Contact found
        //--------------------------------------------------------------------

        // Generate hash
        $hash = UUID_V4_T1();

        // Reset password
        $this->customer->Reset_Password( $email, $hash );

        //----------------------------------------------------------------------
        // Send email with link to set new password
        //----------------------------------------------------------------------

        // Create template
        $email_template = new Template();

        // Set email messages
        $email_template->messages = $this->data;

        // Set email template data
        $email_template->data[ 'reset_password_href' ] = $this->url->Link( 'account/password', '&hash=' . $hash, 'SSL' );

        $this->mail->setTo( $email );
        $this->mail->setSubject( html_entity_decode( $this->data[ 'account_forgotten_subject_message' ], ENT_QUOTES, 'UTF-8' ) );
        $this->mail->setHtml( html_entity_decode( $email_template->Render( 'account/password_reset_email.tpl' ), ENT_QUOTES, 'UTF-8' ) );

        // Send email
        $this->mail->send();

        //--------------------------------------------------------------------

        // Set redirect link
        $json[ 'redirect_url' ] = $this->url->link( 'account/password_sent', '', 'SSL' );

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>