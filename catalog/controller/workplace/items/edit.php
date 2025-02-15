<?php
class ControllerWorkplaceItemsEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Item GUID parameter not found
      //----------------------------------------------------------------------

      //! Redirect to item not found page
      $this->response->Redirect( $this->url->link( 'workplace/items/not_found', '', 'SSL' ) );

    }
    else
    {

      //----------------------------------------------------------------------
      // Item GUID parameter found, continue processing
      //----------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'items_edit', 'index', $this->language->Get_Language_Code() );

      //----------------------------------------------------------------------
      // Parameters found, continue processing
      //----------------------------------------------------------------------

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'manufacturers/manufacturers' );

      // Get item guid
      $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      $this->data['cancel_button_href'] = $this->url->link('workplace/items/info', 'guid=' . $item_guid, 'SSL');

      // Get item information
      $this->data[ 'item' ] = $this->model_items_items->Get_Information( $item_guid );

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

      //------------------------------------------------------------------------
      // Load units list data
      //------------------------------------------------------------------------
    
      // Let units
      $this->data[ 'units' ] = $this->model_items_items->Get_Units( $this->language->Get_Language_Code() );
    
      // Get list of manufacturers
      $manufacturers =  $this->model_manufacturers_manufacturers->Get_List_Of_Manufacturers( 30, '' );

      //! @todo ANVILEX KM: That is this.
      $this->data[ 'item_manufacturer_exist' ] =  $this->model_manufacturers_manufacturers->Is_Manufacturer_Exist( $this->data[ 'item' ][ 'manufacturer_guid' ] );

      // Process all manufacturer
      foreach ( $manufacturers as $manufacturer )
      {
  
        // Add manufacturer data
        $this->data[ 'manufacturers' ][] = array(
          'name' => $manufacturer[ 'company_name' ],
          'guid' => $manufacturer[ 'guid' ]
        );
  
      }
  
      // Get item description
      $item_description = $this->model_items_items->Get_Description( $item_guid, $this->language->Get_Language_Code() );
  
      // Get item description
      $this->data[ 'item' ][ 'description' ] = $item_description[ 'description' ];
  
      // Compose links
      $this->data[ 'workplace_items_edit_item_button_href' ] = $this->url->link( 'workplace/items/edit/Save_Changes', '', 'SSL' );
  
      //----------------------------------------------------------------------
      // Render page
      //----------------------------------------------------------------------
  
      // Set document properties
      $this->response->setTitle( $this->data[ 'item' ][ 'product_mpn' ] );
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

  //----------------------------------------------------------------------------
  // Search manufacturers
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

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        // Load data models
        $this->load->model( 'manufacturers/manufacturers' );

        // get list of fanufacturers
        $manufacturers = $this->model_manufacturers_manufacturers->Get_List_Of_Manufacturers( 30, $this->request->Get_POST_Parameter_As_String( 'search' ) );

        // Process all manufacturer
        foreach ( $manufacturers as $manufacturer )
        {

          // Add manufacturer to the list
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
  // Edit item
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Save_Changes()
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
      $this->messages->Load( $this->data, 'workplace', 'items_edit', 'Save_Changes', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'manufacturers/manufacturers' );

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
        $json[ 'error' ][ 'atomic_item' ] = $this->data[ 'workplace_items_edit_atomic_item_error' ];

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
      // MPN
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'mpn' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: MPN parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'mpn' ] = $this->data[ 'workplace_items_edit_mpn_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // MPN parameter found
        //----------------------------------------------------------------------

        // Store MPN
        $item_data[ 'mpn' ] = trim( $this->request->Get_POST_Parameter_As_String( 'mpn' ) );

        // Test MPN validity
        if (
          ( utf8_strlen( $item_data[ 'mpn' ] ) < 1 ) ||
          ( utf8_strlen( $item_data[ 'mpn' ] ) > $this->model_items_items->Get_Item_MPN_Maximum_String_Size() )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: MPN invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'mpn' ] = $this->data[ 'workplace_items_edit_mpn_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // MPN valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Order code
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'order_code' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Order code parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'order_code' ] = $this->data[ 'workplace_items_edit_order_code_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Order code parameter found
        //----------------------------------------------------------------------

        // Store Order code
        $item_data[ 'order_code' ] = trim( $this->request->Get_POST_Parameter_As_String( 'order_code' ) );

        // Test Order code validity
        if (
          ( utf8_strlen( $item_data[ 'order_code' ] ) > $this->model_items_items->Get_Item_Order_Code_Maximum_String_Size() )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: Order code invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'order_code' ] = $this->data[ 'workplace_items_edit_order_code_error' ];

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
      // Description
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'description' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Description parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_items_edit_description_error' ];

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
          $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_items_edit_description_error' ];

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
      // Item GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Item_guid not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_items_edit_guid_not_exist_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item_guid parameter found
        //----------------------------------------------------------------------

        $item_data[ 'guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'guid' ) );

        // Test email format
        if ( $this->model_items_items->Is_Exists_By_GUID( $item_data[ 'guid' ] ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Item_guid is invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_items_edit_manufacturer_list_not_exist_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Item found by GUID 
          //--------------------------------------------------------------------
          
        }

      }

      //------------------------------------------------------------------------
      // Manufacturer GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'manufacturer' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Manufacturer not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'manufacturer' ] = $this->data[ 'workplace_items_edit_manufacturer_list_not_exist_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Manufacturer parameter found
        //----------------------------------------------------------------------

        $item_data[ 'manufacturer_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'manufacturer' );
        
        // Test email format
        if ( $this->model_manufacturers_manufacturers->Is_Manufacturer_Exist( $item_data[ 'manufacturer_guid' ] ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Manufacturer is invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'manufacturer' ] = $this->data[ 'workplace_items_edit_manufacturer_list_not_exist_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Manufacturer found
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
        $json[ 'error' ][ 'unit' ] = $this->data[ 'workplace_items_edit_unit_error' ];

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

        // Test for item with same mpn and manufactrurer already exists
        if ( $this->model_items_items->Is_Edit_Item_Exists( $item_data[ 'guid' ], $item_data[ 'mpn' ],  $item_data[ 'manufacturer_guid' ] ) === true )
        {

          //--------------------------------------------------------------------
          // ERROR: Item referenced by MPN and manufacturer GUID exists
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'item_exists' ] = $this->data[ 'workplace_items_edit_item_exists_error' ];

          // Set error code
          $json[ 'return_code' ] = false;

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Item referenced by MPN and manufacturer GUID not exists
          //--------------------------------------------------------------------

          // Try to add new item
          $return_data = $this->model_items_items->Edit( $item_data,  $this->language->Get_Language_Code() );

          // Test for item not created
          if ( $return_data === false )
          {

            //--------------------------------------------------------------------
            // ERROR: Item not created
            //--------------------------------------------------------------------

            //! @todo ANVILEX KM: Set error message

            // Set error code
            $json[ 'return_code' ] = false;

          }
          else
          {

            //--------------------------------------------------------------------
            // Item created
            //--------------------------------------------------------------------

            // Set redirect URL
            $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info', 'guid=' . $item_data[ 'guid' ], 'SSL' );

            // Set success code
            $json[ 'return_code' ] = true;

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