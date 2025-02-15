<?php
class ControllerAccountLogin extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer is logged in
    if ( $this->customer->Is_Logged() === true )
    {

      //------------------------------------------------------------------------
      // Customer is already logged in
      //------------------------------------------------------------------------

      // Redirect to account
      $this->response->Redirect( $this->url->link( 'account/account', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer is not logged in
      //------------------------------------------------------------------------

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'login', 'index', $this->language->Get_Language_Code() );

      // Set page data

      $this->data[ 'action' ] = $this->url->link( 'account/login', '', 'SSL' );
      $this->data[ 'account_login_register_button_href' ] = $this->url->link( 'account/register', '', 'SSL' );
      $this->data[ 'account_login_forgot_password_href' ] = $this->url->link( 'account/forgotten', '', 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/login.css' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'common/header'
      );

    }

  }

  //----------------------------------------------------------------------------
  // Login method
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function login()
  {

    // Load messages
    $this->messages->Load( $this->data, 'account', 'login', 'login', $this->language->Get_Language_Code() );

    // Init json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === true )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer logged in
      //------------------------------------------------------------------------

      // Set json data
      $json[ 'return_code' ] = true;
      $json[ 'error' ] = array();
      $json[ 'redirect_url' ] = $this->url->link( 'account/account', '', 'SSL' );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Test for all POST parameters exists
      if (
        ( $this->request->Is_POST_Parameter_Exists( 'email' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Exists( 'password' ) === false )
      )
      {

        //--------------------------------------------------------------------
        // ERROR: Invalid POST parameter set
        //--------------------------------------------------------------------

        // Set json data
        $json[ 'return_code' ] = false;
        $json[ 'error' ][ 'email_or_password' ] = $this->data[ 'account_login_email_or_password_error' ];
        $json[ 'redirect_url' ] = '';

      }
      else
      {

        //--------------------------------------------------------------------
        // POST parameter set valid
        //--------------------------------------------------------------------

        // Try to login by email and password
        if ( $this->customer->Login( $this->request->Get_POST_Parameter_As_String( 'email' ), $this->request->Get_POST_Parameter_As_String( 'password' ) ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Login failed, invalid user or password
          //--------------------------------------------------------------------

          // Set json data
          $json[ 'return_code' ] = false;
          $json[ 'error' ][ 'email_or_password' ] = $this->data[ 'account_login_email_or_password_error' ];
          $json[ 'redirect_url' ] = '';

        }
        else
        {

          //--------------------------------------------------------------------
          // Login successed
          //--------------------------------------------------------------------

          //! @todo ANVILEX KM: Log customer IP

          // Test for cart not exist for customer
          if ( $this->cart->Is_Exist() === false )
          {
          
            //------------------------------------------------------------------
            // Cart not exists, create it
            //------------------------------------------------------------------

            // Create cart for customer
            $this->cart->Create();

          }
          
          //! @todo ANVILEX KM: Send login email if unknown IP detected

          // Set json data
          $json[ 'return_code' ] = true;
          $json[ 'error' ] = array();
          $json[ 'redirect_url' ] = $this->url->link( 'account/account', '', 'SSL' );

        }

      }

    }

    // Send json data
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>