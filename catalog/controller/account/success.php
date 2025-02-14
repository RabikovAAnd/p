<?php 
class ControllerAccountSuccess extends Controller 
{

  //! @todo ANVILEX KM: Is this file used!!!

  public function index() 
  {
  

    $this->data[ 'heading_title' ] = $this->language->get( 'heading_title' );

    $this->data[ 'button_continue' ] = $this->language->get( 'button_my_account' );
    $this->data[ 'continue' ] = $this->url->link( 'account/account', '', 'SSL' );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    $this->response->setTitle( $this->language->get( 'heading_title' ) );
        
    $this->children = array(
      'common/footer',
      'common/header' 
    );

  }

}
?>