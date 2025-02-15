<?php
class ControllerWorkplaceCategoriesInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'categories_info', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'categories/categories' );

    // Test for Category GUID parameter exists
    if ( ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false ) )
    {

      //----------------------------------------------------------------------
      // ERROR: Category GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to category not found page.

    }
    else
    {

      //------------------------------------------------------------------------
      // Category GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get category guid
      $category_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );
      $this->data[ 'category_guid' ] = $category_guid;

      // Get category information
      $this->data[ 'category' ] = $this->model_categories_categories->Get_Category_Information( $category_guid, $this->language->Get_Language_Code() );

      // Set links
      $this->data[ 'edit_button_href' ] = $this->url->link( 'workplace/categories/edit', 'guid=' . $category_guid, 'SSL' );

      //------------------------------------------------------------------------
      // Category image
      //------------------------------------------------------------------------

      // Get category image
      $image = $this->model_categories_categories->Get_Category_Image( $category_guid );

      // Test for error condition
      if( $image[ 'return_code' ] === false )
      {

        //----------------------------------------------------------------------
        // No images linked to category, set default image
        //----------------------------------------------------------------------

        // Set default main image data
        $this->data[ 'category' ][ 'main_image' ] = array(
          'default' => true,
          'image_type' => '',
          'image_data' => ''
        );

      }
      else
      {

        //----------------------------------------------------------------------
        // Process main image
        //----------------------------------------------------------------------

        // Create main image object
        $main_image = new Image();
        $main_image->Create_From_String( $image[ 'data' ] );

        // Resize main image
        $main_image->resize( 300, 300, 'w' );

        // Get main image information
        $main_image_info = $main_image->Get_Info();

        // Set main image data
        $this->data[ 'category' ][ 'main_image' ] = array(
          'default' => false,
          'image_type' => $main_image_info[ 'mime' ],
          'image_data' => $main_image->Get_Encoded()
        );

        // Destroy main image object
        unset( $main_image );

      }

      //------------------------------------------------------------------------
      // Retrieve path to the root category
      //------------------------------------------------------------------------

      // Init tree of categories
      $this->data[ 'tree_categories' ] = array();

      // Check for category is not a root category
      if( $this->data[ 'category' ][ 'guid' ] != '00000000000000000000000000000000' )
      {

        // Get parent category GUID
        $parent_guid = $this->data[ 'category' ][ 'parent_guid' ];

// ANVILEX KM: This code is not used
//        $category =  $this->data[ 'category' ];

        do
        {

          // Get child category
          $child_category = $this->model_categories_categories->Get_Category_Information( $parent_guid, $this->language->Get_Language_Code() );

          // Test for child category valid
          if( $child_category[ 'valid' ] === false )
          {

            //------------------------------------------------------------------
            // ERROR: Child category invalid
            //------------------------------------------------------------------

            // Terminate category tree parsing
            break;

          }
          else
          {

            //------------------------------------------------------------------
            // Child category valid
            //------------------------------------------------------------------

            // Add child category
            array_push( $this->data[ 'tree_categories' ], array(
              'guid' =>$child_category[ 'parent_guid' ],
              'name' => $child_category[ 'name' ],
              'href' => $this->url->link( 'workplace/categories/info', 'guid=' . $child_category[ 'guid' ], 'SSL' )
            ) );

            // Update parent category GUID
            $parent_guid = $child_category[ 'parent_guid' ];

          }

        } while ( $child_category[ 'parent_guid' ] != '00000000000000000000000000000000' );

        // Add root category
        array_push( $this->data[ 'tree_categories' ], array(
          'guid' =>'00000000000000000000000000000000',
          'name' => $this->data[ 'workplace_categories_info_category_tree_main_category_text' ],
          'href' => $this->url->link( 'workplace/categories/info', 'guid=00000000000000000000000000000000', 'SSL' )
        ));

      }

      //------------------------------------------------------------------------
      // Retrive subcategories
      //------------------------------------------------------------------------

      // Get category subcategories
      $subcategories = $this->model_categories_categories->Get_Subcategories( $category_guid, $this->language->Get_Language_Code() );

      if ( count( $subcategories ) > 0 )
      {

        // Process group properties
        foreach ( $subcategories as $subcategory )
        {

          // Set subcategory data
          $this->data[ 'subcategories' ][] = array(
            'element_href' => 'subcategory' . $subcategory[ 'guid' ],
            'guid' => $subcategory[ 'guid' ],
            'status' => $subcategory[ 'status' ],
            'href' =>  $this->url->link( 'workplace/categories/info', 'guid=' . $subcategory[ 'guid' ], 'SSL' ),
            'edit_button_href' =>  $this->url->link( 'workplace/categories/edit', 'guid=' . $subcategory[ 'guid' ], 'SSL' ),
            'move_button_href' =>  $this->url->link( 'workplace/categories/move', 'guid=' . $subcategory[ 'guid' ], 'SSL' ),
            'active_button_href' =>  $this->url->link( 'workplace/categories/status/change/Change', 'parent_guid=' . $category_guid .'&guid=' . $subcategory[ 'guid' ] . '&status=active', 'SSL' ),
            'inactive_button_href' =>  $this->url->link( 'workplace/categories/status/change/Change', 'parent_guid=' .$category_guid .'&guid=' . $subcategory[ 'guid' ] . '&status=inactive', 'SSL' ),
            'remove_button_href' =>  $this->url->link( 'workplace/categories/status/change/Change', 'parent_guid=' . $category_guid .'&guid=' . $subcategory[ 'guid' ] . '&status=deleted', 'SSL' ),
            'name' => $subcategory[ 'name' ],
            'description' => $subcategory[ 'description' ]
          );

        }

      }

      // Set links
      $this->data[ 'add_category_image_button_href' ] = $this->url->link( 'workplace/categories/images/add', 'guid=' . $category_guid, 'SSL' );
      $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/categories/add', 'guid=' . $category_guid, 'SSL' );

    }

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document categories
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );
    $this->response->setRobots( 'index, follow' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>