<?php

class ControllerCompanyPayment extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    //--------------------------------------------------------------------------
    // Set page data
    //--------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'company', 'payment', 'index', $this->language->Get_Language_Code() );

    // Get payment methods    
    $this->data[ 'payment_methods' ] = $this->payment->Get_Methods( $this->language->Get_Language_Code(), 1 );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'index, follow' );

    // Set styles
    $this->response->addStyle( 'catalog/view/stylesheet/company/payment.css' );
        
    // Set page sections
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