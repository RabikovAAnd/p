<?php
class ControllerCommonHeader extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------
  
  protected function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'header', 'header', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Logo
    //--------------------------------------------------------------------------

    // Set logo data
    $this->data[ 'logo_image' ] = $this->request->Get_Server_Base() . 'image/common/logo.png';
    $this->data[ 'logo_href' ] = $this->url->link( 'common/home' );
//    $this->data[ 'logo_title' ] = $this->config->get( 'config_name' );
//    $this->data[ 'logo_alt' ] = $this->language->get( 'text_logo' );

/*
    if ($this->config->get('config_logo') && file_exists( DIR_IMAGE . $this->config->get('config_logo') ))
    {
      $this->data['logo'] = $this->request->Get_Server_Base() . 'image/' . $this->config->get('config_logo');
    }
    else
    {
      $this->data['logo'] = '';
    }
*/

    //--------------------------------------------------------------------------
    // Language button
    //--------------------------------------------------------------------------

    $this->data[ 'header_header_language_button_text' ] = $this->language->Get_Language_Code();
    $this->data[ 'header_header_language_button_href' ] = $this->url->link( 'language/language' ); 

    //--------------------------------------------------------------------------
    // Location button
    //--------------------------------------------------------------------------
    
    $this->data[ 'header_header_location_button_text' ] = $this->location->Get_Country_Code();
    $this->data[ 'header_header_location_button_href' ] = $this->url->link( 'country/country' );

    //--------------------------------------------------------------------------
    // Cart button
    //--------------------------------------------------------------------------

    // Set button data
    $this->data[ 'header_header_cart_button_text' ] = $this->cart->Get_Lines_Count();
    $this->data[ 'header_header_cart_button_href' ] = $this->url->link( 'cart/show', '', 'SSL' ); 

    //--------------------------------------------------------------------------
    // My account button
    //--------------------------------------------------------------------------

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === true )
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      $this->data[ 'header_header_account_button_href' ] = $this->url->link( 'account/account', '', 'SSL' ); 
    
    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged out
      //------------------------------------------------------------------------
      
      $this->data[ 'header_header_account_button_href' ] = $this->url->link( 'account/login', '', 'SSL' );
    
    }

    //--------------------------------------------------------------------------
    // Logout button
    //--------------------------------------------------------------------------

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === true )
    {
    
      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      $this->data[ 'header_header_logout_button_enabled' ] = true;
      $this->data[ 'header_header_logout_button_href' ] = $this->url->link( 'account/logout', '', 'SSL' );
      
      $this->data[ 'header_header_workplace_button_enabled' ] = true;
      $this->data[ 'header_header_workplace_button_href' ] = $this->url->link( 'workplace/front', '', 'SSL' );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged out
      //------------------------------------------------------------------------

      $this->data[ 'header_header_logout_button_enabled' ] = false;
      $this->data[ 'header_header_logout_button_href' ] = $this->url->link( 'account/login', '', 'SSL' );

      $this->data[ 'header_header_workplace_button_enabled' ] = false;
      $this->data[ 'header_header_workplace_button_href' ] = $this->url->link( 'account/login', '', 'SSL' );

    }

    //--------------------------------------------------------------------------
    // Menu buttons
    //--------------------------------------------------------------------------

    $this->data[ 'header_header_home_button_href' ] = $this->url->link( 'common/home' );
    $this->data[ 'header_header_about_button_href' ] = $this->url->link( 'company/about' );
    $this->data[ 'header_header_contact_button_href' ] = $this->url->link( 'company/contact' );
    $this->data[ 'header_header_careers_button_href' ] = $this->url->link( 'company/careers' );
    $this->data[ 'header_header_catalog_button_href' ] = $this->url->link( 'catalog/categories', 'category_guid=9E83D6845B334A1FA0A5249EEFC9782D' );

    //--------------------------------------------------------------------------
    // Daniel's robot detector
    //! @todo ANVILEX KM: Remove???
    //--------------------------------------------------------------------------
/*
    $status = true;

    // Check user agent
    if (isset($this->request->server['HTTP_USER_AGENT']))
    {

      $robots = explode("\n", trim($this->config->get('config_robots')));

      foreach ($robots as $robot)
      {

        if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false)
        {
          $status = false;

          break;
        }

      }

    }
*/

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Add header stylesheets
//    $this->response->addStyle( 'catalog/view/stylesheet/common/header.css' );

    // Render page
//    $this->Render( 'common/header.tpl' );

  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
