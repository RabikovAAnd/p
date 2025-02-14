<?php

class ControllerAccountMenu extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for custommer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link('account/login', '', 'SSL') );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'menu', 'index', $this->language->Get_Language_Code() );

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      $this->data[ 'account_href' ] = $this->url->link( 'account/account', '', 'SSL' );
      $this->data[ 'workplace_href' ] = $this->url->link( 'workplace/front', '', 'SSL' );
      $this->data[ 'edit_href' ] = $this->url->link( 'account/edit', '', 'SSL' );
      $this->data[ 'password_href' ] = $this->url->link( 'account/password', '', 'SSL' );
      $this->data[ 'address_href' ] = $this->url->link( 'account/address/list', '', 'SSL' );
      $this->data[ 'wishlist_href' ] = $this->url->link( 'account/wishlist', '', 'SSL' );
      $this->data[ 'order_href' ] = $this->url->link( 'account/orders/list', '', 'SSL' );
      $this->data[ 'return_href' ] = $this->url->link( 'account/return', '', 'SSL' );
      $this->data[ 'transaction_href' ] = $this->url->link( 'account/transaction', '', 'SSL' );
      $this->data[ 'newsletter_href' ] = $this->url->link( 'account/newsletter', '', 'SSL' );
      $this->data[ 'orders_list_href' ] = $this->url->link( 'account/orders_list', '', 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/address.css' );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>