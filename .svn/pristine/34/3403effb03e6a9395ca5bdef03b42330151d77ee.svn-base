<?php
class ControllerItemsInfo extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'items', 'info', 'index', $this->language->Get_Language_Code() );

    // Test for parameters exists
    if ( $this->request->Is_GET_Parameter_Exists( 'guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not set
      //------------------------------------------------------------------------

      // Redirect to product not found page

      // Set document headline
      $this->data[ 'heading_title' ] = $this->language->get( 'text_error' );

      // Set error text
      $this->data[ 'text_error' ] = $this->language->get( 'text_error' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document title
      $this->response->setTitle( $this->language->get( 'text_error' ) );

      // Add style
      $this->response->addStyle( 'catalog/view/stylesheet/products/info.css' );

      // Add error header
      $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 404 Not Found' );

      // Configure error page
      $this->children = array(
        'common/footer',
        'common/header'
      );

      // Render error page
//      $this->response->Set_HTTP_Output( $this->Render( 'error/not_found.tpl' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found, continue processing
      //------------------------------------------------------------------------

      // Get parameter as string
      $item_guid = $this->request->Get_GET_Parameter_As_String( 'guid' );

      // Load data models
      $this->load->model( 'items/items' );

      // Get item information
      $item = $this->model_items_items->Get_Information( $item_guid );

      // Test for product info valid
      if ( $item[ 'valid' ] == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid item information detected
        //----------------------------------------------------------------------

        // Redirect to item not found page

        // ANVILEX KM: To implement

      }
      else
      {

        //----------------------------------------------------------------------
        // Item information valid, continue processing
        //----------------------------------------------------------------------

        // Set item generic information
        $item_data[ 'guid' ] = $item[ 'guid' ];
        $item_data[ 'mpn' ] = $item[ 'mpn' ];
        $item_data[ 'manufacturer_name' ] = $item[ 'manufacturer_name' ];
        $item_data[ 'manufacturer_href' ] = $this->url->link( 'manufacturers/info', 'manufacturer_id=' . (int)$item[ 'manufacturer_id' ] );

        //----------------------------------------------------------------------
        // Get item description
        //----------------------------------------------------------------------

        // Get item description
        $description = $this->model_items_items->Get_Description( $item_guid, $this->language->Get_Language_Code() );

        // Set item description
        $item_data[ 'description' ] = $description[ 'description' ];

        //----------------------------------------------------------------------

        // Get item image
        $item_image = $this->model_items_items->Get_Image( $item_guid );

        // Set default item image
        $item_data[ 'image_data' ] = ( $item_image[ 'valid' ] == false ) ? '' : 'data:'. $item_image[ 'type' ] . ';base64, ' . base64_encode( $item_image[ 'data' ] );

        // Set item data
        $this->data[ 'item' ] = $item_data;

        //----------------------------------------------------------------------

        // Get item properties
        $item_properties = $this->model_items_items->Get_Product_Properties_1( $item_guid, $this->language->Get_Language_Code() );

        // Set item properties
        $this->data[ 'properties' ] = $item_properties;

        //----------------------------------------------------------------------
        // Item documents
        //----------------------------------------------------------------------

        // Get item documents
        $item_documants = $this->model_items_items->Get_Documents( $item_guid, $this->language->Get_Language_Code() );

        // Set item documents
        $this->data[ 'documents' ] = $item_documants;

        //----------------------------------------------------------------------
        // Get cart line information
        //----------------------------------------------------------------------

        // Try to get cart line totals
        $item_cart = $this->cart->Get_Line_Totals( $item_guid );

        // Set cart information
        $this->data[ 'cart' ] = $item_cart;

        //----------------------------------------------------------------------
        // Get warehouse information
        //----------------------------------------------------------------------

        // Get item warehouse information
        // $item_warehouse = $this->warehouse->Get_Item_Stocked_Quantity( $item_guid );

        // Set warehouse information
        // $this->data[ 'warehouse' ] = $item_warehouse;

        //**********************************************************************

        //----------------------------------------------------------------------
        // Get warehouse information
        //----------------------------------------------------------------------
/*
      // Get product price information
      $product_price_information = $this->warehouse->getProductPrice( $item_guid );

        $product_data[ 'product_stock_quantity' ] = $product_warehouse_info[ 'quantity' ];

        $product_data[ 'product_price' ] = number_format( $product_price_information[ 'price' ], 4 ) . ' EUR';
*/
        //----------------------------------------------------------------------
        // Get item price information
        //----------------------------------------------------------------------
/*
        // Get product price information
        $product_price_info = $this->model_items_items->Get_Product_Price( $item[ 'item_id' ] );

        // Test for cart information valid
        if ( $product_price_info[ 'valid' ] == false )
        {

          //--------------------------------------------------------------------
          // ERROR: No valid cart information present
          //--------------------------------------------------------------------

          // Set default quantity
          $product_data[ 'unit_price' ] = '-.-- EUR / ' . $item[ 'quantisation_unit_name' ];

        }
        else
        {

          //--------------------------------------------------------------------
          // Cart information present
          //--------------------------------------------------------------------

          // Set item price
          $product_data[ 'unit_price' ] = number_format( $product_price_info[ 'price' ], 2 ) . ' EUR / ' . $item[ 'quantisation_unit_name' ];

        }
*/

      }

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set page title
      $this->response->setTitle( $item_data[ 'mpn' ] . ' - ' . $item_data[ 'manufacturer_name' ] );

        // Set page description
//        $this->response->setDescription( $item_data[ 'meta_description' ] );

          // Set keywords
//        $this->response->setKeywords( $item_data[ 'meta_keyword' ] );

//        $this->response->setPageTopic( $this->language->get( 'meta_page_topic' ) );

      // Set robot information
      $this->response->setRobots( 'index, follow' );

      // Set links
      $this->response->addLink( $this->url->link( 'items/info', 'guid=' . $item_guid ), 'canonical' );

// ANVILEX KM: Loging temporary disabled
//      $this->model_catalog_product->updateViewed( $this->request->get['product_guid'] );

      // Add style
      $this->response->addStyle( 'catalog/view/stylesheet/products/info.css' );

      // Configure page
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