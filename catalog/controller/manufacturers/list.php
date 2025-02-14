<?php
class ControllerManufacturersList extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

//    $this->customer->Fix_Data_1();

    // Load messages
    $this->messages->Load( $this->data, 'manufacturers', 'list', 'index', $this->language->Get_Language_Code() );

    // Load model
    $this->load->model( 'manufacturers/manufacturers' );

    //--------------------------------------------------------------------------

    $this->data[ 'manufacturers' ] = array();

    // Get manufacturers
    $manufacturers = $this->model_manufacturers_manufacturers->getManufacturers();

    // Process all manufacturer
    foreach ( $manufacturers as $manufacturer )
    {
      
      $this->data[ 'manufacturers' ][] = array(
        'name' => ucfirst( $manufacturer[ 'name' ] ),
        'manufacturer_href' => $this->url->link( 'manufacturers/info', 'manufacturer_id=' . (int)$manufacturer[ 'manufacturer_id' ] ),
      );
      
    }

    // Sort list of manufacturers
    sort( $this->data[ 'manufacturers' ] );

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );
    $this->response->setRobots( 'index, follow' );

    // Add styles
    $this->response->addStyle( 'catalog/view/stylesheet/manufacturers.css' );

    // Set page children
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