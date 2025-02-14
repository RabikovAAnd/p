<?php
class ControllerCatalogTeaser extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  protected function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'catalog', 'teaser', 'index', $this->language->Get_Language_Code() );

    // Load categories model
    $this->load->model( 'categories/categories' );

    // Set root category
    $category_guid = '9E83D6845B334A1FA0A5249EEFC9782D';

    // Set headline link
    $this->data[ 'catalog_teaser_header_href' ] = $this->url->link( 'catalog/categories', 'category_guid=' . $category_guid );

    // Query SQL database
    $categories = $this->model_categories_categories->Get_Teaser_Categories( $category_guid );

    // Create array
    $this->data[ 'catalog_categories' ] = array();

    // Iterate over all news items
    foreach ( $categories as $category )
    {

      // Get subcategory information
      $category_info = $this->model_categories_categories->Get_Category( $category[ 'guid' ], $this->language->Get_Language_Code() );

      // Get subcategory counts
      $count_of_categories = $this->model_categories_categories->Get_Subcategories_Count( $category[ 'guid' ] );

      // Test subcategories are exists
      if ( $count_of_categories == 0 )
      {
        
        //----------------------------------------------------------------------
        // No subcategories fond, show product list
        //----------------------------------------------------------------------

        // Compose URL
        $category_url = $this->url->link( 'catalog/products', 'category_guid=' . $category_info[ 'guid' ], 'SSL' );
      
      }
      else
      {

        //----------------------------------------------------------------------
        // Subcategories found, show categories list
        //----------------------------------------------------------------------

        // Compose URL
        $category_url = $this->url->link( 'catalog/categories', 'category_guid=' . $category_info[ 'guid' ], 'SSL' );

      }

      // Add category
      $this->data[ 'catalog_categories' ][] = array(
        'image_type' => $category_info[ 'image_type' ],
        'image_data' => base64_encode( $category_info[ 'image_data' ] ),
        'image_title' => $category_info[ 'name' ],
        'name' => $category_info[ 'name' ],
        'description_short' => $category_info[ 'description_short' ],
        'description' => $category_info[ 'description' ],
        'href' => $category_url
      );

    }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Add styles to document
//    $this->response->addStyle( 'catalog/view/stylesheet/catalog/teaser.css' );

    // Render page
//    $this->Render( 'catalog/teaser.tpl' );

  }

}
//----------------------------------------------------------------------------
// End of file
//----------------------------------------------------------------------------
?>