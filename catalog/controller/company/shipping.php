<?php
class ControllerCompanyShipping extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'company', 'shipping', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Set page data
    //--------------------------------------------------------------------------
    
    // Get forwarders
    $forwarders = $this->delivery->Get_Forwarders( $this->language->Get_Language_Code() );

    // Test for forwarders found
    if ( count( $forwarders ) === 0 )
    {

      //------------------------------------------------------------------------
      // No forwarders found
      //------------------------------------------------------------------------

      // Set empty list
      $this->data[ 'forwarders' ] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Forwarders found
      //------------------------------------------------------------------------

      // Process each forwarder
      foreach ( $forwarders as $forwarder ) 
      {

        // Get delivery methods
        $delivery_methods = $this->delivery->Get_Methods( $this->language->Get_Language_Code(), $forwarder[ 'id' ], 'XX', 'XX' );

        // Add forwarder
        $this->data[ 'forwarders' ][] = 
          array(
            'id' => $forwarder[ 'id' ],
            'name' => $forwarder[ 'name' ],
            'description' => $forwarder[ 'description' ],
            'image_type' => $forwarder[ 'image_type' ],
//            'image_data' => ( $forwarder[ 'image_type' ] === '' ) ? './image/default/no_image.jpg' : 'data:'. $forwarder[ 'image_type' ] . ';base64, ' . base64_encode( $forwarder[ 'image_data' ] ),
            'image_data' => ( $forwarder[ 'image_type' ] === '' ) ? './image/default/no_image.jpg' : 'data:'. $forwarder[ 'image_type' ] . ';base64,' . $forwarder[ 'image_data' ],
//            'methods' => array( 'Подспособ 1', 'Подспособ 2', 'Подспособ 3' )
            'methods' => $delivery_methods
          );

      }

    }
    
    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setKeywords('');
    $this->response->setRobots('index, follow');

    // Set styles
    $this->response->addStyle( 'catalog/view/stylesheet/company/shipping.css' );

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