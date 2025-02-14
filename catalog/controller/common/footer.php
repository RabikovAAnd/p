<?php
class ControllerCommonFooter extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  protected function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'footer', 'footer', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Company section
    //--------------------------------------------------------------------------

    $this->data[ 'href_company_about' ] = $this->url->link( 'company/about' );
    $this->data[ 'href_company_press' ] = $this->url->link( 'news/list' );
    $this->data[ 'href_company_careers' ] = $this->url->link( 'company/careers' );
    $this->data[ 'href_company_contact' ] = $this->url->link( 'company/contact' );
    $this->data[ 'href_company_imprint' ] = $this->url->link( 'company/imprint' );

    //--------------------------------------------------------------------------
    // Information section
    //--------------------------------------------------------------------------

    $this->data[ 'href_information_terms_of_use' ] = $this->url->link( 'company/terms' ); // terms of use
    $this->data[ 'href_information_conditions' ] = $this->url->link( 'company/conditions' );
    $this->data[ 'href_information_revocation' ] = $this->url->link( 'company/revocation' );
    $this->data[ 'href_information_privacy' ] = $this->url->link( 'company/privacy' );
    $this->data[ 'href_information_payment' ] = $this->url->link( 'company/payment' );
    $this->data[ 'href_information_shipping' ] = $this->url->link( 'company/shipping' );
    $this->data[ 'href_information_returns' ] = $this->url->link( 'company/returns' );

    //--------------------------------------------------------------------------
    // Database section
    //--------------------------------------------------------------------------
    
    $this->data[ 'href_database_items' ] = $this->url->link( 'catalog/categories', 'category_guid=58C9847C9F1D43C6ABFE569BE6EE7D9A' );
    $this->data[ 'href_database_manufacturers' ] = $this->url->link( 'manufacturers/list' );
    $this->data[ 'href_database_target3001' ] = $this->url->link( 'database/taraget3001' );
    $this->data[ 'href_database_bugtracker' ] = 'http://www.anvilex.com/bugtracker';
//    $this->data[ 'href_database_svn' ] = $this->url->link( 'database/svn' );
//    $this->data[ 'href_database_acronyms' ] = $this->url->link( 'information/acronyms' );
    $this->data[ 'href_database_debug' ] = $this->url->link( 'database/debug' );

    //--------------------------------------------------------------------------
    // Imprint section
    //--------------------------------------------------------------------------

    // Set footer
    $this->data[ 'text_copyright' ] = '&copy;' . date( 'Y', time() ) . ' ' . $this->config->get( 'config_name' );

    //--------------------------------------------------------------------------

/*
// ANVILEX KM: Don't remove this code !!! 
    
  // Whos Online

    $this->load->model('tool/online');

    if (isset($this->request->server['REMOTE_ADDR']))
    {
      $ip = $this->request->server['REMOTE_ADDR'];
    }
    else
    {
      $ip = '';
    }

    if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI']))
    {
      $url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
    }
    else
    {
      $url = '';
    }

    if ( isset($this->request->server['HTTP_REFERER']) )
    {
      $referer = $this->request->server['HTTP_REFERER'];
    }
    else
    {
      $referer = '';
    }

    $this->model_tool_online->whosonline( $ip, $this->customer->Get_ID(), $url, $referer );

*/

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Add footer stylesheets
//    $this->response->addStyle( 'catalog/view/stylesheet/common/footer.css' );

    // Render page
//    $this->Render( 'common/footer.tpl' );
  
  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>