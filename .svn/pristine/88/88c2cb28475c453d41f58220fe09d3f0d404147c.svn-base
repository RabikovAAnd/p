<?php

//------------------------------------------------------------------------------
// Controller class for generating YML feed for Yandex.Market
//------------------------------------------------------------------------------

class ControllerFeedsYandex extends Controller 
{

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------

  public function index()
  {

    // Generate XML header and main document structure
    $output = '<?xml version="1.0" encoding="UTF-8"?>';
    $output .= '<yml_catalog date="' . date( 'Y-m-d H:i:s' ) . '">';
    $output .= '<shop>';

    // Add main shop information
    $output .= '<name>Anvilex</name>';
    $output .= '<company>Anvilex</company>';
    $output .= '<url>' . HTTPS_SERVER . '</url>';

    // Specify the currency used
    $output .= '<currencies>';
    $output .= '<currency id="RUB" rate="1"/>';
    $output .= '</currencies>';

    // Start the product section
    $output .= '<offers>';

    // Load the model to retrieve product data
    $this->load->model( 'items/items' );

    // Retrieve products available in specific warehouses
    $products = $this->model_items_items->getProductsByWarehouse(
      '787BC0170B204EC485BD5B3491AB43AE', // customer_guid
      'RU'                                // country_iso_code_2
    );

    // Loop through all products and generate XML for each
    foreach ( $products as $product )
    {

      $output .= '<offer id="' . htmlspecialchars( $product[ 'guid' ] ) . '">';

      // Add main product characteristics
      $output .= '<name>' . htmlspecialchars( $product[ 'name' ] ) . '</name>';
      $output .= '<vendor>' . htmlspecialchars( $product[ 'manufacturer' ] ) . '</vendor>';
      $output .= '<url>' . $this->url->link( 'product/product', 'guid=' . $product[ 'guid' ] ) . '</url>';
      $output .= '<description>' . htmlspecialchars($product['description']) . '</description>';
      $output .= '<currencyId>RUB</currencyId>';
      $output .= '<categoryId>' . htmlspecialchars($product['category_guid']) . '</categoryId>';

      // Delivery options
      $output .= '<store>false</store>';
      $output .= '<pickup>false</pickup>';
      $output .= '<delivery>true</delivery>';
      $output .= '</offer>';

    }

    // Close all open tags
    $output .= '</offers>';
    $output .= '</shop>';
    $output .= '</yml_catalog>';

    // Set response headers and send XML
    $this->response->addHeader( 'Content-Type: application/xml; charset=utf-8' );

    // Send content
    $this->response->setOutput( $output );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>