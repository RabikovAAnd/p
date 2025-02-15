<?php
class ControllerWorkplaceCustomersAddressCreate extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------

  public function index()
  {

    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false ) 
    {
      
      //------------------------------------------------------------------------
      // ERROR: Parameter not set
      //------------------------------------------------------------------------

    } 
    else
    {

      //------------------------------------------------------------------------
      // Parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'customers_address_create', 'index', $this->language->Get_Language_Code() );

      // Get customer GUID
      $customer_guid = $this->request->Get_GET_Parameter_As_String( 'guid' );

      $address = array(
        'apartment' => '',
        'building' => '',
        'street' => '',
        'house' => '',
        'postcode' => '',
        'city' => '',
        'zone_id' => '',
        'country_id' => ''
      );

      $this->data[ 'address' ] = $address;

      // Get list of countries
      $this->data[ 'countries' ] = $this->location->Get_Countries($this->language->Get_Language_Code() );
      
      // Get list of geo zones
      $this->data[ 'zones' ] = $this->location->Get_Zones( $this->language->Get_Language_Code() );

      // Set links
      $this->data[ 'save_button_href' ] = $this->url->link( 'workplace/customers/address/create/create', 'customer_guid=' . $customer_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/customers/info', 'guid=' . $customer_guid, 'SSL' );

      //------------------------------------------------------------------------
      // Set page data
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

  }

  //----------------------------------------------------------------------------
  // Add new address
  //----------------------------------------------------------------------------

  public function Create()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_address_create', 'Create', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'address/address' );

    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Customer GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'customer_guid' ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Customer GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'customer_guid' ] = $this->data[ 'workplace_customers_address_create_' . 'customer_guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Customer GUID parameter found
      //----------------------------------------------------------------------

      // Store customer GUID
      $data[ 'customer_guid' ] = trim($this->request->Get_GET_Parameter_As_GUID( 'customer_guid' ) );

    }

    //------------------------------------------------------------------------
    // Country ID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_ID( 'country_id' ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Country ID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'country_id' ] = $this->data[ 'workplace_customers_address_create_' . 'country_id' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Country ID parameter found
      //----------------------------------------------------------------------

      // Store country ID
      $data[ 'country_id' ] = trim( $this->request->Get_POST_Parameter_As_ID( 'country_id' ) );

      // Test country ID validity
      if ( $data[ 'country_id' ] == 0 )
      {

        //--------------------------------------------------------------------
        // ERROR: Country ID invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'country_id' ] = $this->data[ 'workplace_customers_address_create_' . 'country_id' . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else
      {

        //--------------------------------------------------------------------
        // Country ID valid
        //--------------------------------------------------------------------

      }

    }

    //------------------------------------------------------------------------
    // Zone ID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_ID( 'zone_id' ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Zone ID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'zone_id' ] = $this->data[ 'workplace_customers_address_create_' . 'zone_id' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Zone ID parameter found
      //----------------------------------------------------------------------

      // Store
      $data[ 'zone_id' ] = trim( $this->request->Get_POST_Parameter_As_ID( 'zone_id' ) );

      // Test zone ID validity
      if ( $data[ 'zone_id' ] == 0 )
      {

        //--------------------------------------------------------------------
        // ERROR: Zone ID invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'zone_id' ] = $this->data['workplace_customers_address_create_' . 'zone_id' . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Zone ID valid
        //--------------------------------------------------------------------

      }
    }

    //------------------------------------------------------------------------
    // Postcode
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'postcode', 0, $this->model_address_address->Get_Address_Postcode_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Postcode not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'postcode' ] = $this->data[ 'workplace_customers_address_create_' . 'postcode' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Postcode parameter found and valid
      //----------------------------------------------------------------------

      // Store postcode
      $data[ 'postcode' ] = trim( $this->request->Get_POST_Parameter_As_String( 'postcode' ) );

    }

    //------------------------------------------------------------------------
    // District
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'district', 0, $this->model_address_address->Get_Address_District_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: District not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'district' ] = $this->data[ 'workplace_customers_address_create_' . 'district' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // District parameter found and valid
      //----------------------------------------------------------------------

      // Store district
      $data[ 'district' ] = trim( $this->request->Get_POST_Parameter_As_String( 'district' ) );

    }
    //------------------------------------------------------------------------
    // City
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'city', 1, $this->model_address_address->Get_Address_City_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: City not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'city' ] = $this->data[ 'workplace_customers_address_create_' . 'city' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else 
    {

      //----------------------------------------------------------------------
      // City parameter found
      //----------------------------------------------------------------------

      // Story city
      $data[ 'city' ] = trim( $this->request->Get_POST_Parameter_As_String( 'city' ) );

    }

    //------------------------------------------------------------------------
    // Street
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'street', 1, $this->model_address_address->Get_Address_Street_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Street not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'street' ] = $this->data[ 'workplace_customers_address_create_' . 'street' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Street parameter found
      //----------------------------------------------------------------------

      // Story street
      $data[ 'street' ] = trim( $this->request->Get_POST_Parameter_As_String( 'street' ) );

    }

    //------------------------------------------------------------------------
    // House
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'house', 1, $this->model_address_address->Get_Address_House_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: House not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'house' ] = $this->data[ 'workplace_customers_address_create_' . 'house' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // House parameter found
      //----------------------------------------------------------------------

      // Store house
      $data[ 'house' ] = trim( $this->request->Get_POST_Parameter_As_String( 'house' ) );

    }

    //------------------------------------------------------------------------
    // Building
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'building', 0, $this->model_address_address->Get_Address_Building_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Building not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'building' ] = $this->data[ 'workplace_customers_address_create_' . 'building' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Building parameter found
      //----------------------------------------------------------------------

      // Story building
      $data[ 'building' ] = trim( $this->request->Get_POST_Parameter_As_String( 'building' ) );

    }

    //------------------------------------------------------------------------
    // Apartment
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'apartment', 0, $this->model_address_address->Get_Address_Apartment_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Apartment not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'apartment' ] = $this->data[ 'workplace_customers_address_create_' . 'apartment' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Apartment parameter found and valid
      //----------------------------------------------------------------------

      // Story appartment
      $data[ 'apartment' ] = trim( $this->request->Get_POST_Parameter_As_String( 'apartment' ) );

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

      // Set success code
      $json[ 'return_code' ] = $this->model_address_address->Add( $data[ 'customer_guid' ], $data );

      // Set redirect URL
      $json[ 'redirect_url' ] = $this->url->link( 'workplace/customers/info', 'guid=' . $data[ 'customer_guid' ], 'SSL' );

    }

    // Send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function country()
  {

    $json = array();

    $country_info = $this->location->Get_Country_Info( $this->request->get[ 'country_id' ] );

    if ( $country_info ) 
    {

      $json = array(
        'country_id' => $country_info[ 'country_id' ],
        'name' => $country_info[ 'name' ],
        'iso_code_2' => $country_info[ 'iso_code_2' ],
        'iso_code_3' => $country_info[ 'iso_code_3' ],
        'address_format' => $country_info[ 'address_format' ],
        'postcode_required' => $country_info[ 'postcode_required' ],
        'zone' => $this->location->Get_Country_Zones( $this->request->get[ 'country_id' ] ),
        'status' => $country_info[ 'status' ]
      );
    
    }

    $this->response->Set_Json_Output( $json );
  
  }

  //----------------------------------------------------------------------------

  public function set_zones()
  {

    $json = array();

    $json[ 'zone' ] = $this->location->Get_Zones();

    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function set_country_by_zone()
  {

    $json = array();

    $zone_info = $this->location->Get_Country_Zone_Info( $this->request->get[ 'zone_id' ] );

    $json[ 'country_id' ] = $zone_info[ 'country_id' ];

    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>