<?php
class ControllerWorkplaceItemsCreate extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'add_item', 'index', $this->language->Get_Language_Code() );

    // Load data model
    $this->load->model( 'items/items' );
    $this->load->model( 'customers/customers' );
    $this->load->model( 'manufacturers/manufacturers' );

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // Item GUID parameter not found, create new item
      //----------------------------------------------------------------------

    }
    else
    {

      //----------------------------------------------------------------------
      // Item GUID present and valid, clone item
      //----------------------------------------------------------------------

      // Get item GUID
      $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get item information
      $this->data[ 'item' ] = $this->model_items_items->Get_Information( $item_guid );

      //----------------------------------------------------------------------

      $this->data[ 'item' ][ 'description' ] = $this->model_items_items->Get_Description( $item_guid, $this->language->Get_Language_Code() )[ 'description' ];

      $this->data['cancel_button_href'] = $this->url->link('workplace/items/info', 'guid=' . $item_guid, 'SSL');

      //----------------------------------------------------------------------

      // Try to get unit data
      $unit_data = $this->units->Get_Unit_Info( $this->data[ 'item' ][ 'quantisation_unit_id' ], $this->language->Get_Language_Code() );

      // Test for unit data invalid
      if( $unit_data[ 'return_code' ] === false )
      {

        $this->data[ 'item' ][ 'unit_data' ] = array();

      }
      else
      {

        $this->data[ 'item' ][ 'unit_data' ] = $unit_data[ 'data' ];

      }

    }

    //------------------------------------------------------------------------
    // Load manufacturers list data
    //------------------------------------------------------------------------

    // Get list of manufacturers
    $manufacturers =  $this->model_manufacturers_manufacturers->Get_List_Of_Manufacturers( 30, '' );

    // Process all manufacturer
    foreach ( $manufacturers as $manufacturer )
    {

      // Add manufacturer data to the list
      $this->data[ 'manufacturers' ][] = array(
        'name' => $manufacturer[ 'company_name' ],
        'guid' => $manufacturer[ 'guid' ]
      );

    }

    //------------------------------------------------------------------------
    // Load units list data
    //------------------------------------------------------------------------
    
    // Let units
    $this->data[ 'units' ] = $this->model_items_items->Get_Units( $this->language->Get_Language_Code() );

    //------------------------------------------------------------------------

    // Button link
    $this->data[ 'workplace_add_item_button_href' ] = $this->url->link( 'workplace/items/create/create_item', '', 'SSL' );

    //------------------------------------------------------------------------
    // Set document data
    //------------------------------------------------------------------------

    // Set document properties
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

  //----------------------------------------------------------------------------
  // Search item
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function search()
  {

    // Initialise json data
    $json = array();

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      if ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameter not found
        //----------------------------------------------------------------------
        
        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter valid
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'manufacturers/manufacturers' );

        // get list of fanufacturers
        $manufacturers = $this->model_manufacturers_manufacturers->Get_List_Of_Manufacturers( 30, $this->request->Get_POST_Parameter_As_String( 'search' ) );

        // Process all manufacturer
        foreach ( $manufacturers as $manufacturer )
        {

          $json[ 'manufacturers' ][] = array(
            'name' => $manufacturer[ 'company_name' ],
            'guid' => $manufacturer[ 'guid' ]
          );

        }

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Create new item
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function create_item()
  {

    // Init json data
    $json = array();

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'add_item', 'Create_Item', $this->language->Get_Language_Code() );

      // Init item data
      $item_data = array();

      // Clear request data valid status
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Atomic item
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Boolean( 'atomic_item' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Atomic item parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'atomic_item' ] = $this->data[ 'workplace_add_item_atomic_item_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Atomic item parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $item_data[ 'atomic_item' ] = $this->request->Get_POST_Parameter_As_Boolean( 'atomic_item' );

      }

      //------------------------------------------------------------------------
      // Generate item MPN
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Boolean( 'generate_mpn' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Generate mpn parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'generate_mpn' ] = $this->data[ 'workplace_add_item_atomic_item_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Atomic item parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $item_data[ 'generate_mpn' ] = $this->request->Get_POST_Parameter_As_Boolean( 'generate_mpn' );

      }
      
      //------------------------------------------------------------------------
      // Item MPN
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'mpn' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: MPN parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'mpn' ] = $this->data[ 'workplace_add_item_mpn_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // MPN parameter found
        //----------------------------------------------------------------------

        if( $item_data[ 'generate_mpn' ] === false )
        {
          
          //--------------------------------------------------------------------
          // Generate MPN disabled
          //--------------------------------------------------------------------

          // Store MPN
          $item_data[ 'mpn' ] = trim( $this->request->Get_POST_Parameter_As_String( 'mpn' ) );

          // Test MPN validity
          if (
            ( utf8_strlen( $item_data[ 'mpn' ] ) < 1 ) ||
            ( utf8_strlen( $item_data[ 'mpn' ] ) > 64 )
          )
          {

            //------------------------------------------------------------------
            // ERROR: MPN invalid
            //------------------------------------------------------------------

            // Set error message text
            $json[ 'error' ][ 'mpn' ] = $this->data[ 'workplace_add_item_mpn_error' ];

            // Clear request data valid status
            $request_data_valid = false;

          }
          else
          {

            //------------------------------------------------------------------
            // MPN valid
            //------------------------------------------------------------------

          }

        }
        else
        {

          //--------------------------------------------------------------------
          // Generate MPN enabled
          //--------------------------------------------------------------------

          // Store empty MPN
          $item_data[ 'mpn' ] = '';

        }

      }

      //------------------------------------------------------------------------
      // Order code parameter
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'order_code' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Order code parameter not found
        //----------------------------------------------------------------------

        // Set error message text
//        $json[ 'error' ][ 'order_code' ] = $this->data[ 'workplace_add_item_order_code_error' ];

        // Set request data valid status
        // Note: Order code is optional field

      }
      else
      {

        //----------------------------------------------------------------------
        // Order code parameter found
        //----------------------------------------------------------------------

        // Store order code
        $item_data[ 'order_code' ] = trim( $this->request->Get_POST_Parameter_As_String( 'order_code' ) );

        // Test order code validity
        if ( utf8_strlen( $item_data[ 'order_code' ] ) > 64 )
        {

          //--------------------------------------------------------------------
          // ERROR: Order code invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'order_code' ] = $this->data[ 'workplace_add_item_order_code_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Order code valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Description parameter
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'description' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Description parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_add_item_description_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Description parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $item_data[ 'description' ] = trim( $this->request->Get_POST_Parameter_As_String( 'description' ) );

        // Test description validity
        if ( utf8_strlen( $item_data[ 'description' ] ) > 255 )
        {

          //--------------------------------------------------------------------
          // ERROR: Description invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_add_item_description_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Description valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Manufacturer
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'manufacturer_list' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Manufacturer not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'manufacturer_list' ] = $this->data[ 'workplace_add_item_manufacturer_list_not_exist_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Manufacturer GUID parameter found
        //----------------------------------------------------------------------

        $item_data[ 'manufacturer_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'manufacturer_list' );

        // Load data models
        $this->load->model( 'manufacturers/manufacturers' );

        // Test email format
        if ( $this->model_manufacturers_manufacturers->Is_Manufacturer_Exist( $item_data[ 'manufacturer_guid' ] ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Manufacturer GUID is invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'manufacturer_list' ] = $this->data[ 'workplace_add_item_manufacturer_list_not_exist_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Manufacturer GUID valid
          //--------------------------------------------------------------------
          

        }

      }

      //------------------------------------------------------------------------
      // Unit
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Positive_Integer( 'unit' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Unit parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'unit' ] = $this->data[ 'workplace_add_item_unit_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Unit parameter found and valid
        //----------------------------------------------------------------------

        // Store customer data
        $item_data[ 'unit' ] = $this->request->Get_POST_Parameter_As_Integer( 'unit' );

      }

      //------------------------------------------------------------------------
      // Favorite
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Boolean( 'favorite' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Favorite parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'favorite' ] = $this->data[ 'workplace_add_item_favorite_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Favorite parameter found and valid
        //----------------------------------------------------------------------

        // Store customer data
        $item_data[ 'favorite' ] = $this->request->Get_POST_Parameter_As_Boolean( 'favorite' );

      }

      //------------------------------------------------------------------------
      // Process request data
      //------------------------------------------------------------------------

      // Is request data valid
      if ( $request_data_valid === false )
      {

        //------------------------------------------------------------------------
        // ERROR: Parameters not valid
        //------------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Parameters present and valid
        //--------------------------------------------------------------------

        // Load data model
        $this->load->model( 'items/items' );

        // Test for item already exists
        if ( $this->model_items_items->Is_Exists( $item_data[ 'mpn' ], $item_data[ 'manufacturer_guid' ] ) )
        {

          //--------------------------------------------------------------------
          // ERROR: Item referenced by MPN and manufacturer GUID exists
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'item_exists' ] = $this->data[ 'workplace_add_item_item_exists_error' ];

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Item referenced by MPN and manufacturer GUID not exists
          //--------------------------------------------------------------------

          // Generate item GUID
          $item_data[ 'guid' ] = UUID_V4_T1();

          // Try to add new item
          $return_data = $this->model_items_items->Add_Item( $item_data );

          // Test for item not created
          if ( $return_data[ 'return_code' ] === false )
          {

            //--------------------------------------------------------------------
            // ERROR: Item not created
            //--------------------------------------------------------------------

            // Set error message text
            $json[ 'error' ][ 'error' ] = $this->data[ 'workplace_add_item_failed_error' ];

            // Set error code
            $json[ 'return_code' ] = false;

          }
          else
          {

            //--------------------------------------------------------------------
            // Item created
            //--------------------------------------------------------------------

            // Test for item should be added to favorite items
            if( $item_data[ 'favorite' ] === true )
            {
             
              // Add item to customer favorites list
              $this->model_items_items->Add_To_Favorites( $this->customer->Get_GUID(), $item_data[ 'guid' ] );
              
              //! @todo ANVILEX KM: Log error
              
            }

            // Test for 
            if (
//              ( $item_data[ 'mpn' ] == '' ) ||
              ( $item_data[ 'generate_mpn' ] === true )
            )
            {
              
              //--------------------------------------------------------------------
              // Overwrite MPN
              //--------------------------------------------------------------------
              
              // Try to get ID of new item
              $new_item = $this->model_items_items->Get_Information( $item_data[ 'guid' ] );
              
              // Test for new item information getted
              if ( $new_item[ 'return_code' ] === false )
              {
              
                //----------------------------------------------------------------
                // ERROR:
                //----------------------------------------------------------------
              
                // Set error message text
                $json[ 'error' ][ 'error' ] = $this->data[ 'workplace_add_item_internal_error' ];
              
                // Set error code
                $json[ 'return_code' ] = false;
              
              }
              else
              {
              
                //----------------------------------------------------------------
                // New item information data getted
                //----------------------------------------------------------------
              
                // Compose MPN of new created item
                $new_item_mpn = 'ID' . $new_item[ 'item_id' ];
              
                // Try to update MPN of new item
                if ( $this->model_items_items->Update_MPN( $item_data[ 'guid' ], $new_item_mpn ) === false )
                {
                  
                  //--------------------------------------------------------------
                  // ERROR: MPN update failed
                  //--------------------------------------------------------------
                
                  // Set error message text
                  $json[ 'error' ][ 'error' ] = $this->data[ 'workplace_add_item_internal_error' ];
                
                  // Set error code
                  $json[ 'return_code' ] = false;
              
                }
                else
                {
                  
                  //--------------------------------------------------------------
                  // MPN update successed
                  //--------------------------------------------------------------
                            
                  // Set redirect URL
                  $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info', 'guid=' . $item_data[ 'guid' ], 'SSL' );
              
                  // Set success code
                  $json[ 'return_code' ] = true;
              
                }
                
              }
            
            }
            else
            {
              
              //----------------------------------------------------------------
              // Overwrite MPN not needed
              //----------------------------------------------------------------

              // Set redirect URL
              $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info', 'guid=' . $item_data[ 'guid' ], 'SSL' );

              // Set success code
              $json[ 'return_code' ] = true;
              
            }

          }

        }

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