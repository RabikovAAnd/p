<?php

class ControllerAccountRegisterSuccess extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    if ( ! $this->customer->Is_Logged() )
    {


      $this->response->Redirect($this->url->link('account/account', '', 'SSL'));

    }
    else
    {

      if ( isset( $this->session->data[ 'register_success' ] ) )
      {

        //------------------------------------------------------------------------
        // Set page data
        //------------------------------------------------------------------------

        // Load messages
        $this->messages->Load( $this->data, 'account', 'register_success', 'index', $this->language->Get_Language_Code() );

        $this->data[ 'action' ] = $this->url->link( 'account/register', '', 'SSL' );

        unset($this->session->data['register_success']);

        //------------------------------------------------------------------------
        // Render page
        //------------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle($this->messages->Get_Message('document_title_text'));
        $this->response->setDescription($this->messages->Get_Message('document_description_text'));
        $this->response->setKeywords('');
        $this->response->setRobots('index, follow');

        // Add styles
        $this->response->addStyle('catalog/view/stylesheet/account/register.css');

        // Set page template
        $this->children = array(
          'common/footer',
          'common/header'
        );

      }
      else
      {

        $this->response->Redirect( $this->url->link( 'account/account', '', 'SSL' ) );

      }

    }

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>