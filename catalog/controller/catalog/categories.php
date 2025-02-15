<?php
class ControllerCatalogCategories extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------
  
  public function index()
  {

    // Load data model
    $this->load->model( 'categories/categories' );

//    $this->load->model( 'tool/image' );

    // Test for parameters exists
    if ( $this->request->Is_GET_Parameter_Exists( 'category_guid' ) === false )
    {

      // Set default category
      $category_guid = '9E83D6845B334A1FA0A5249EEFC9782D';

    }
    else
    {

      // Get category ID
      $category_guid = $this->request->Get_GET_Parameter_As_String( 'category_guid' );

    }

    // Get category
    $category = $this->model_categories_categories->Get_Category( $category_guid, $this->language->Get_Language_Code() );

    // Test category
    if ( $category )
    {

      //----------------------------------------------------------------------------------
      // Category found, process it
      //----------------------------------------------------------------------------------

      // Set categories list
      $this->data[ 'categories' ] = array();

      // Get sub categories
      $subcategories = $this->model_categories_categories->Get_Subcategories( $category_guid, 'EN' );

      // Test for no subcategories found
      if ( isset( $subcategories ) === false )
      {

        //----------------------------------------------------------------------
        // No sub categories found, regirect to product listing
        //----------------------------------------------------------------------

      }
      else
      {

        //----------------------------------------------------------------------
        // List sub categories
        //----------------------------------------------------------------------

        // Iterate iver all categories
        foreach ( $subcategories as $subcategory )
        {

          // Get subcategory information
          $subcategory_info = $this->model_categories_categories->Get_Category( $subcategory[ 'guid' ], $this->language->Get_Language_Code() );

          // Get subcategory counts
          $count_of_subcategories = $this->model_categories_categories->Get_Subcategories_Count( $subcategory[ 'guid' ] );

          $properties = array();

          $properties[] = array( 'name' => 'Property 1', 'value' => 'Value 1' );
          $properties[] = array( 'name' => 'Property 2', 'value' => 'Value 2' );
          $properties[] = array( 'name' => 'Property 3', 'value' => 'Value 3' );
          
          
          // Test subcategories are exists
          if ( $count_of_subcategories == 0 )
          {

            //------------------------------------------------------------------
            // No subcategories fond, show link to product list
            //------------------------------------------------------------------

            // Compose URL
            $url = $this->url->link( 'catalog/products', 'category_guid=' . $subcategory_info[ 'guid' ] );

          }
          else
          {

            //------------------------------------------------------------------
            // Subcategories found, show link to categories list
            //------------------------------------------------------------------

            // Compose URL
            $url = $this->url->link( 'catalog/categories', 'category_guid=' . $subcategory_info[ 'guid' ] );

          }

          // Add subcategory to the list
          $this->data[ 'categories' ][] = array(
            'image_type' => $subcategory_info[ 'image_type' ],
            'image_data' =>  base64_encode( $subcategory_info[ 'image_data' ] ),
            'image_title' => $subcategory_info[ 'name' ],
            'name' => $subcategory_info[ 'name' ],
            'description' => $subcategory_info[ 'description' ],
            'href' => $url,
            'properties' => $properties
          );

        }

      }

      // Set parent category data
      $this->data[ 'text_parent_category_header' ] = $category[ 'name' ];
      $this->data[ 'text_parent_category_description' ] = $category[ 'description' ];

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      $this->response->setTitle( $category[ 'name' ] );
      $this->response->setDescription( $category[ 'description' ] );
      $this->response->setKeywords( '' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/catalog/categories.css' );

      // Add page children
      $this->children = array(
        'common/footer',
        'common/header'
      );

    }
    else
    {

      //------------------------------------------------------------------------
      // ERROR: Category not found
      //------------------------------------------------------------------------

      // Add style
      $this->response->addStyle( 'catalog/view/stylesheet/categories.css' );

      // Set document title
      $this->response->setTitle( $this->language->get( 'text_document_title_category_not_found' ) );
      
      // Set document description
      $this->response->setDescription( '' );

      // Set document keywords
      $this->response->setKeywords( '' );

      // Set document messages
      $this->data[ 'text_message_header' ] = $this->language->get( 'text_error_header_category_not_found' );
      $this->data[ 'text_message_body' ] = $this->language->get( 'text_error_message_category_not_found' );

      // Add document header as 404 return code
      $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 404 Not Found' );

      // Add page children
      $this->children = array(
        'common/footer',
        'common/header'
      );

      // Render page
//      $this->response->Set_HTTP_Output( $this->Render( 'catalog/not_found.tpl' ) );

    }

  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>