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

    // Load the model to retrieve product data
    $this->load->model( 'items/items' );

    // Generate XML header and main document structure
    $file_content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $file_content .= '<yml_catalog date="' . date( 'Y-m-d H:i:s' ) . '">' . PHP_EOL;
    $file_content .= '<shop>' . PHP_EOL;

    // Add main shop information
    $file_content .= '<name>Anvilex</name>' . PHP_EOL;
    $file_content .= '<company>Anvilex</company>' . PHP_EOL;
    $file_content .= '<url>' . HTTPS_SERVER . '</url>' . PHP_EOL;

    // Specify the currency used
    $file_content .= '<currencies>' . PHP_EOL;
    $file_content .= '<currency id="RUB" rate="1"/>' . PHP_EOL;
    $file_content .= '</currencies>' . PHP_EOL;

    // Start the product section
    $file_content .= '<offers>' . PHP_EOL;

    $item_per_file = 20000;
    $limit = 5000;
    $offset = 0;

    do
    {

      // Retrieve products available in specific warehouses
      $products = $this->model_items_items->Get_Items_By_Warehouse(
        '787BC0170B204EC485BD5B3491AB43AE', // customer_guid
        'RU',                               // country_iso_code_2
        $limit,
        $offset
      );

      // Loop through all products and generate XML for each
      foreach ( $products as $product )
      {

        $file_content .= '<offer id="' . htmlspecialchars( $product[ 'guid' ] ) . '">' . PHP_EOL;

        // Add main product characteristics
        $file_content .= '<name>' . htmlspecialchars( $product[ 'mpn' ] ) . '</name>' . PHP_EOL;
        $file_content .= '<vendor>' . htmlspecialchars( $product[ 'manufacturer_guid' ] ) . '</vendor>' . PHP_EOL;
        $file_content .= '<url>' . htmlspecialchars( $this->url->link( 'product/product', 'guid=' . $product[ 'guid' ], 'SSL' ) ) . '</url>' . PHP_EOL;
        $file_content .= '<description>' . htmlspecialchars( $product[ 'description' ] ) . '</description>' . PHP_EOL;
        $file_content .= '<currencyId>RUB</currencyId>' . PHP_EOL;
        $file_content .= '<categoryId>' . htmlspecialchars( $product[ 'category_guid' ] ) . '</categoryId>' . PHP_EOL;

        // Delivery options
        $file_content .= '<store>false</store>' . PHP_EOL;
        $file_content .= '<pickup>false</pickup>' . PHP_EOL;
        $file_content .= '<delivery>true</delivery>' . PHP_EOL;
        $file_content .= '</offer>' . PHP_EOL;

      }

      $offset = $offset + $limit;
 
    }
    while ( ( count( $products ) != 0 ) & ( $offset <= ( $item_per_file + $limit ) ) );

    // Close all open tags
    $file_content .= '</offers>' . PHP_EOL;
    $file_content .= '</shop>' . PHP_EOL;
    $file_content .= '</yml_catalog>' . PHP_EOL;

    //--------------------------------------------------------------------------
    // Send sitemap index content
    //--------------------------------------------------------------------------

    // Disable using template for page rendering
    $this->Set_Template_Requered( false );

    // Set responce headers
// ANVILEX KM: Use this header if you need to download sitemap as a file
//    $this->response->Add_Header( 'Content-Disposition: attachment; filename="yandex.xml"' );
    $this->response->Add_Header( 'Content-Type: application/xml' );
    $this->response->Add_Header( 'Content-Length: ' . strlen( $file_content ) );

    // Send the sitemap content
    $this->response->Set_File_Output( $file_content );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>