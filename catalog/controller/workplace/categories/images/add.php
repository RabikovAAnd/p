<?php
class ControllerWorkplaceCategoriesImagesAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for category GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Category GUID not found
      //------------------------------------------------------------------------

    }
    else
    {

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'categories_images_add', 'index', $this->language->Get_Language_Code());

      // Get category guid
      $this->data['category_guid'] = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Set link
      $this->data[ 'cancel_button_href' ] =  $this->url->link( 'workplace/categories/info', 'guid=' . $this->data['category_guid'], 'SSL' );
      $this->data[ 'add_image_button_href' ] = $this->url->link( 'workplace/categories/images/add/Add', 'category_guid='.$this->data['category_guid'], 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle('');
      $this->response->setDescription('');
      $this->response->setKeywords('');
      $this->response->setRobots('index, follow');

      // Set page configuration
      $this->children = array(
        'common/footer',
        'workplace/menu',
        'common/header'
      );

    }

  }

  //----------------------------------------------------------------------------
  // Add new image to the item
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'categories_images_add', 'Add', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'categories/categories' );

    // Init json data
    $json = array();

    // Init return status code
    $json[ 'return_code' ] = false;

    // Init item data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Category guid
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_GET_Parameter_GUID( 'category_guid' ) === false)
    {

      //----------------------------------------------------------------------
      // ERROR: Category guid parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'category_guid' ] = $this->data[ 'workplace_categories_images_add_category_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Category guid parameter found
      //----------------------------------------------------------------------

      // Store customer data
      $data[ 'category_guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'category_guid' ) );

      // Test category GUID validity
      if ( $this->model_categories_categories->Is_Exists_By_GUID( $data[ 'category_guid' ] ) === false )
      {

        //--------------------------------------------------------------------
        // ERROR: Category guid invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'category_guid' ] = $this->data[ 'workplace_categories_images_add_category_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Category guid valid
        //--------------------------------------------------------------------

      }

    }

    //------------------------------------------------------------------------
    // Image data
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( isset( $_FILES[ 'image_data' ] ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Image data parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'image_data' ] = $this->data[ 'workplace_categories_images_add_image_data_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Image data parameter found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Check for any upload errors in $_FILES[ 'image_data' ][ 'error' ]

      // Store image content
      $data[ 'image_data' ] = file_get_contents( $_FILES[ 'image_data' ][ 'tmp_name' ] );

      // Store image data
      $data[ 'filename' ] = $_FILES[ 'image_data' ][ 'name' ];
      $data[ 'type' ] = $_FILES[ 'image_data' ][ 'type' ];
      // $data[ 'size' ] = $_FILES[ 'image_data' ][ 'size' ];
      // $data[ 'hash' ] = md5_file( $_FILES[ 'image_data' ][ 'tmp_name' ], false );

      // Test for image size valid
      if (
        ( $_FILES[ 'image_data' ][ 'size' ] > $this->model_categories_categories->Get_Category_Picture_Maximum_Size() ) ||
        ( $_FILES[ 'image_data' ][ 'size' ] == 0 )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Image data parameter too big
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'image_data' ] = $this->data[ 'workplace_categories_images_add_image_data_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Image data valid
        //--------------------------------------------------------------------

      }

      // Test for file data type valid
      if( substr( $data[ 'type' ], 0, 5 )  != 'image' )
      {

        //----------------------------------------------------------------------
        // ERROR: Image data parameter not image
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'image_data' ] = $this->data[ 'workplace_categories_images_add_not_image_data_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Image data valid
        //--------------------------------------------------------------------

      }

    }

    //------------------------------------------------------------------------
    // Process data
    //------------------------------------------------------------------------

    // Is request data valid
    if ( $request_data_valid === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error return code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameters present and valid, try to store image
      //------------------------------------------------------------------------

      // Add new item image
      if ( $this->model_categories_categories->Add_Category_Image( $data ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Image upload failed
        //----------------------------------------------------------------------

        // Set error return code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Image successfully uploaded
        //----------------------------------------------------------------------

        // Set redirect URL
        $json[ 'redirect_url' ] =  $this->url->link( 'workplace/categories/info', 'guid=' . $data[ 'category_guid' ], 'SSL' );

        // Set success return code
        $json[ 'return_code' ] = true;

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>