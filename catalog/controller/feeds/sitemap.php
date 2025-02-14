<?php

//------------------------------------------------------------------------------
// Controller class for generating sitemap index and sitemap pilefiles
// This controller handles the creation of XML sitemaps for categories, products,
// and manufacturers, and generates a sitemap index file linking to them.
//------------------------------------------------------------------------------

class ControllerFeedsSitemap extends Controller
{

  //----------------------------------------------------------------------------
  // Main entry point for generating the sitemap index file.
  // This file references individual sitemaps for categories, products, and manufacturers.
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load required models for accessing data
    // ANVILEX KM: Dont remove this lines, it will be requered later
//   $this->load->model( 'categories/categories' );
//    $this->load->model( 'items/items' );
//    $this->load->model( 'manufacturers/manufacturers' );

    // Start building the sitemap index XML
    $file_content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $file_content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Add references to individual sitemaps
    $file_content .= '<sitemap><loc>' . HTTPS_SERVER . 'sitemap/categories.xml</loc></sitemap>' . PHP_EOL;
    $file_content .= '<sitemap><loc>' . HTTPS_SERVER . 'sitemap/products.xml</loc></sitemap>' . PHP_EOL;
    $file_content .= '<sitemap><loc>' . HTTPS_SERVER . 'sitemap/manufacturers.xml</loc></sitemap>' . PHP_EOL;

    // Close the sitemap index
    $file_content .= '</sitemapindex>' . PHP_EOL;

    //--------------------------------------------------------------------------
    // Send sitemap index content
    //--------------------------------------------------------------------------

    // Disable using template for page rendering
    $this->Set_Template_Requered( false );

    // Set responce headers
// ANVILEX KM: Use this header if you need to download sitemap as a file
//    $this->response->Add_Header( 'Content-Disposition: attachment; filename="sitemap_index.xml"' );
    $this->response->Add_Header( 'Content-Type: application/xml' );
    $this->response->Add_Header( 'Content-Length: ' . strlen( $file_content ) );

    // Send the sitemap sitemap index content
    $this->response->Set_File_Output( $file_content );

  }

  //----------------------------------------------------------------------------
  // Generates and saves the sitemap for categories.
  // Outputs the sitemap as an XML response.
  //----------------------------------------------------------------------------

  public function categories()
  {

    // Load the model for categories
    $this->load->model( 'categories/categories' );

    // Retrieve all active categories
    $categories = $this->model_categories_categories->Get_GUID_Of_Active_Categories();

    //! @brief ANVILEX KM: Test for categories valid

    // Start building the XML structure
    $file_content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $file_content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Add each category as a <url> entry
    foreach ( $categories as $category )
    {

      // Add category line
      $file_content .= '<url>' . PHP_EOL;
      $file_content .= '<loc>' . $this->url->link( 'catalog/categories', 'category_guid=' . $category[ 'guid' ], 'SSL' ) . '</loc>' . PHP_EOL;
      $file_content .= '<lastmod>' . $category[ 'modification_date' ] . '</lastmod>' . PHP_EOL;
      $file_content .= '<changefreq>weekly</changefreq>' . PHP_EOL;
      $file_content .= '<priority>0.7</priority>' . PHP_EOL;
      $file_content .= '</url>' . PHP_EOL;

    }

    // Close the XML structure
    $file_content .= '</urlset>' . PHP_EOL;

    // Save the sitemap to a file
//    file_put_contents( DIR_SITEMAP . 'categories.xml', $file_content );

    //--------------------------------------------------------------------------
    // Send sitemap index content
    //--------------------------------------------------------------------------

    // Disable using template for page rendering
    $this->Set_Template_Requered( false );

    // Set responce headers
// ANVILEX KM: Use this header if you need to download sitemap as a file
//    $this->response->Add_Header( 'Content-Disposition: attachment; filename="sitemap_index.xml"' );
    $this->response->Add_Header( 'Content-Type: application/xml' );
    $this->response->Add_Header( 'Content-Length: ' . strlen( $file_content ) );

    // Send the sitemap content
    $this->response->Set_File_Output( $file_content );

  }

  //----------------------------------------------------------------------------
  // Generates and saves the sitemap for products.
  // Outputs the sitemap as an XML response.
  //----------------------------------------------------------------------------

  public function products()
  {

    // Load the model for products
    $this->load->model( 'items/items' );

    // Retrieve all active products
    $products = $this->model_items_items->getAllProducts();

    // Start building the XML structure
    $file_content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $file_content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Add each product as a <url> entry
    foreach ( $products as $product )
    {
        // Add product line
        $file_content .= '<url>' . PHP_EOL;
        $file_content .= '<loc>' . $this->url->link( 'items/info', 'guid=' . $product['guid'], 'SSL' ) . '</loc>' . PHP_EOL;
        $file_content .= '</url>' . PHP_EOL;
    }

    // Close the XML structure
    $file_content .= '</urlset>' . PHP_EOL;

    // Save the sitemap to a file
//    file_put_contents( DIR_SITEMAP . 'products.xml', $file_content );

    //--------------------------------------------------------------------------
    // Send sitemap content
    //--------------------------------------------------------------------------

    // Disable using template for page rendering
    $this->Set_Template_Requered( false );

    // Set response headers
// ANVILEX KM: Use this header if you need to download sitemap as a file
//    $this->response->Add_Header( 'Content-Disposition: attachment; filename="sitemap_products.xml"' );
    $this->response->Add_Header( 'Content-Type: application/xml' );
    $this->response->Add_Header( 'Content-Length: ' . strlen( $file_content ) );

    // Send the sitemap content
    $this->response->Set_File_Output( $file_content );
}

  //----------------------------------------------------------------------------
  // Generates and saves the sitemap for manufacturers.
  // Outputs the sitemap as an XML response.
  //----------------------------------------------------------------------------

  public function manufacturers()
  {

    // Load the model for manufacturers
    $this->load->model( 'manufacturers/manufacturers' );

    // Retrieve all manufacturers
    $manufacturers = $this->model_manufacturers_manufacturers->getAllManufacturers();

    // Generate the XML sitemap
    $output = $this->generateSitemap( $manufacturers, 'manufacturers/info', 'manufacturer_id' );

    // Save the sitemap to a file
//    file_put_contents( DIR_SITEMAP . 'manufacturers.xml', $output );

    // Set response headers and output the sitemap
    $this->response->Add_Header( 'Content-Type: application/xml; charset=utf-8' );
    $this->response->Set_File_Output( $output );

  }

  //-------------------------------------------------------
  // Helper function to generate a sitemap XML for a given set of items.
  // @param array  $items   The array of items to include in the sitemap.
  // @param string $route   The route used to generate URLs for items.
  // @param string $idKey   The key in the item array that contains the unique identifier.
  // @return string         The generated XML string.
  //-------------------------------------------------------

  private function generateSitemap( $items, $route, $idKey )
  {

    // Start building the XML structure
    $output = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Add each item as a <url> entry
    foreach ( $items as $item )
    {
      $output .= '<url>' . PHP_EOL;
      $output .= '<loc>' . $this->url->link( $route, $idKey . '=' . $item[ $idKey ] ) . '</loc>' . PHP_EOL;
      $output .= '</url>' . PHP_EOL;
    }

    // Close the XML structure
    $output .= '</urlset>' . PHP_EOL;

    return $output;

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>