<?php
class ControllerWorkplaceItemsImagesAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Item GUID not found
      //------------------------------------------------------------------------

    }
    else
    {

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'items_images_add', 'index', $this->language->Get_Language_Code());

      // Get item guid
      $this->data['item_guid'] = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Set link
      $this->data[ 'cancel_button_href' ] =  $this->url->link( 'workplace/items/info', 'guid=' . $this->data['item_guid'], 'SSL' );
      $this->data[ 'add_image_button_href' ] = $this->url->link( 'workplace/items/images/add/Add', 'item_guid='.$this->data['item_guid'], 'SSL' );

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
    $this->messages->Load( $this->data, 'workplace', 'items_images_add', 'Add', $this->language->Get_Language_Code() );

    // Init json data
    $json = array();

    // Init return status code
    $json[ 'return_code' ] = false;

    // Init item data
    $data = array();

    // Clear request data valid sataus
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Item guid
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( ! $this->request->Is_GET_Parameter_GUID( 'item_guid' ) )
    {

      //----------------------------------------------------------------------
      // ERROR:  Item guid parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'item_guid' ] = $this->data[ 'workplace_items_images_add_item_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      //  Item guid parameter found
      //----------------------------------------------------------------------

      // Store customer data
      $data[ 'item_guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'item_guid' ) );

      // Load data models
      $this->load->model( 'items/items' );

      // Test GUID validity
      if ( $this->model_items_items->Is_Exists_By_GUID( $data[ 'item_guid' ] ) === false )
      {

        //--------------------------------------------------------------------
        // ERROR:  Item guid invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'item_guid' ] = $this->data[ 'workplace_items_images_add_item_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Document version valid
        //--------------------------------------------------------------------

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

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
      $json[ 'error' ][ 'image_data' ] = $this->data[ 'workplace_items_images_add_image_data_error' ];

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

      // Store document data
      $data[ 'filename' ] = $_FILES[ 'image_data' ][ 'name' ];
      $data[ 'type' ] = $_FILES[ 'image_data' ][ 'type' ];
      // $data[ 'size' ] = $_FILES[ 'image_data' ][ 'size' ];
      // $data[ 'hash' ] = md5_file( $_FILES[ 'image_data' ][ 'tmp_name' ], false );

      if( $_FILES[ 'image_data' ][ 'size' ] >= 4294967295 )
      {

        //----------------------------------------------------------------------
        // ERROR: Image data parameter too big
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'image_data' ] = $this->data[ 'workplace_items_images_add_image_data_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Image data valid
        //--------------------------------------------------------------------

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      }

      if( substr($data[ 'type' ], 0, 5)  != 'image' )
      {

        //----------------------------------------------------------------------
        // ERROR: Image data parameter not image
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'image_data' ] = $this->data[ 'workplace_items_images_add_not_image_data_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Image data valid
        //--------------------------------------------------------------------

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

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

      // Load data model
      $this->load->model( 'items/images' );

      // Add new item image
      if ( $this->model_items_images->Add_Item_Image( $data ) === false )
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
        $json[ 'redirect_url' ] =  $this->url->link( 'workplace/items/info', 'guid=' . $data[ 'item_guid' ], 'SSL' );

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