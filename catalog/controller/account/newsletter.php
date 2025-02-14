<?php

class ControllerAccountNewsletter extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false ) 
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {
      
      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'newsletter', 'index', $this->language->Get_Language_Code() );

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      //! @todo ANVILEX KM: Rewrite and optimise code

      $this->data[ 'customer_data' ] = $this->customer->Get_Contact_Information( $this->customer->Get_GUID() );

      if ( $this->request->Is_POST_Request() ) 
      {

        $this->customer->editNewsletter( $this->request->post[ 'newsletter'] );

        $this->session->data['success'] = $this->language->get( 'text_success' );

        $this->response->Redirect( $this->url->link('account/account', '', 'SSL' ) );
    
      }

      $this->data[ 'action' ] = $this->url->link( 'account/newsletter', '', 'SSL' );

      $this->data[ 'newsletter' ] = $this->customer->getNewsletter();

      $this->data[ 'back' ] = $this->url->link( 'account/account', '', 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );

      // Set page template
      $this->children = array(
        'common/footer',
        'account/menu',
        'common/header'
      );
    
    }

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit_Newsletter()
  {

    // Load messages
    $this->messages->Load( $this->data, 'account', 'newsletter', 'Edit_Newsletter', $this->language->Get_Language_Code() );
    
    // Init json data
    $json = array();

    //! @todo ANVILEX KM: Rewrite and optimise code

    if ( $this->request->Is_POST_Parameter_Exists( 'newsletter' ) ) 
    {

      $this->data[ 'customer_id' ] = $this->customer->Get_Customer_Id_by_Guid( $this->customer->Get_GUID() )[ 'customer_id' ];
      $this->data[ 'newsletter' ] = ( $this->request->Get_POST_Parameter_As_String( 'newsletter' ) === 'true' ) ? 1 : 0;

      $this->customer->Edit_Newsletter( $this->data );
      
      $json['return_code'] = true;
      $json['animation'] = [ $this->data[ 'account_newsletter_save_button_text' ], $this->data[ 'account_newsletter_save_button_success_text' ] ];

    } 
    else 
    {

      $json['return_code'] = false;

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function optin()
  {

    $contact_id = isset($this->request->get['contact_id']) ? $this->request->get['contact_id'] : '';

    if (isset($this->request->get['hash'])) {

      if (is_numeric($this->request->get['hash'])) {

        $hash = $this->request->get['hash'];

      } else {

        $hash = '';

      }

    } else {

      $hash = '';

    }

    if (is_numeric($contact_id) && isValidMd5($hash)) {

      $this->customer->updateNewsletter($contact_id, $hash, true);

    } else {

      // Error

    }

  }

  //----------------------------------------------------------------------------

  public function optout()
  {
  }

  //----------------------------------------------------------------------------

  protected function isValidMd5( $md5 = '' )
  {

    return strlen($md5) == 32 && ctype_xdigit( $md5 );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>