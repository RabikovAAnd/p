<?php

class ControllerManufacturersInfo extends Controller
{

  public function index()
  {

    // Try to get parameter "manufacturer_id"
    if ( isset( $this->request->get[ 'manufacturer_id' ] ) == false ) 
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not set
      //------------------------------------------------------------------------

      // Redirect to product not found page

      // Set document headline
      $this->data[ 'heading_title' ] = $this->language->get( 'text_error' );

      // Set error text
      $this->data[ 'text_error' ] = $this->language->get( 'text_error' );

      //------------------------------------------------------------------

      // Set document title
      $this->response->setTitle( $this->language->get( 'text_error' ) );

      // Add style
      $this->response->addStyle( 'catalog/view/stylesheet/manufacturers.css' );

      // Configure error page
      $this->children = array(
        'common/footer',
        'common/header'
      );

      // Add error header
      $this->response->Add_Header( $this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found' );

      // Render error page
//      $this->response->Set_HTTP_Output( $this->Render( 'error/not_found.tpl' ) );

    } 
    else 
    {

      //------------------------------------------------------------------------
      // Parameter found, continue processing
      //------------------------------------------------------------------------

      // Get manufacturer identifier
      $manufacturer_id = $this->request->get['manufacturer_id'];

      // Load data models
      $this->load->model('manufacturers/manufacturers');

      // Get manufacture information
      $manufacturer = $this->model_manufacturers_manufacturers->getManufacturer($manufacturer_id, $this->language->Get_Language_Code());

      //--------------------------------------------------------------------------

      // Set heading text
      $this->data['heading_title'] = $manufacturer['name'];

      // Set description text
      $this->data['description'] = $manufacturer['description'];

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle($manufacturer['name']);
      $this->response->setDescription($this->messages->Get_Message('document_description_text') . $manufacturer['name']);
      $this->response->setKeywords('');
      $this->response->setRobots('index, follow');

      // Add style
      $this->response->addStyle('catalog/view/stylesheet/manufacturers.css');

      // Set page children
      $this->children = array(
        'common/footer',
        'common/header'
      );

    }

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>