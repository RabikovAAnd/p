<?php
class ControllerAccountAddressEdit extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------

  public function index()
  {
  
    // Load messages
    $this->messages->Load( $this->data, 'account', 'address_form_edit', 'index', $this->language->Get_Language_Code() );
  
    // Try to get parameter "guid"
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {
  
      //------------------------------------------------------------------------
      // ERROR: Parameter not set
      //------------------------------------------------------------------------
    
      $this->data[ 'address_href' ] = $this->url->link( 'account/address', '', 'SSL' );
      $this->data[ 'countries' ] = $this->location->Get_Countries( $this->language->Get_Language_Code() );
      $this->data[ 'zones' ] = $this->location->Get_Zones( $this->language->Get_Language_Code() );

      //----------------------------------------------------------------------
      // Render page
      //----------------------------------------------------------------------

      $this->response->setTitle( $this->language->get( 'heading_title' ) );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );
      $this->response->addStyle( 'catalog/view/stylesheet/account/address.css' );
  
      $this->children = array(
        'common/footer',
        'account/menu',
        'common/header'
      );
    
    }
    else
    {
  
      //------------------------------------------------------------------------
      // Parameter found, continue processing
      //------------------------------------------------------------------------
        
      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load model
      $this->load->model( 'address/address' );

      // Get address GUID
      $address_guid = $this->request->Get_GET_Parameter_As_String( 'guid' );
  
      $this->data[ 'address' ] = $this->model_address_address->Get_Address( $address_guid );
      
      $this->data[ 'address_href' ] = $this->url->link( 'account/address', '', 'SSL' );
        
      $this->data['countries'] = $this->location->Get_Countries( $this->language->Get_Language_Code() );
      $this->data['zones'] = $this->location->Get_Zones( $this->language->Get_Language_Code() );

      $this->data[ 'account_address_form_edit_save_button_href' ] = $this->url->link( 'account/address/edit/Edit', 'address_guid=' . $address_guid , 'SSL' );
      $this->data[ 'account_address_form_edit_delete_button_href' ] = $this->url->link( 'account/address/edit/inactivate', '', 'SSL' );

      //-----------------------------------------------------------------------
      // Render page
      //-----------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );
      $this->response->addStyle( 'catalog/view/stylesheet/account/address.css' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'account/menu',
        'common/header'
      );

    }

  }

  //----------------------------------------------------------------------------
  // Inactivate address
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function inactivate()
  {

    // Init json data
    $json = array();

    $this->load->model( 'address/address' );

    if ( $this->request->Is_POST_Parameter_Exists( 'guid' ) === false ) 
    {

      $json[ 'return_code' ] = false;

    }
    else
    {

      $guid = $this->request->post[ 'guid' ];

      // Set redirect link
      $json[ 'redirect_url' ] = $this->url->link( 'account/address', '', 'SSL' );

      // Set success code
      $json[ 'return_code' ] = $this->model_address_address->Inactivate( $guid );

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

//   //----------------------------------------------------------------------------
//   // Update address
//   //----------------------------------------------------------------------------
//   // Caller: AJAX
//   //----------------------------------------------------------------------------

//   public function update() 
//   {

//     // Init json data
//     $json = array();

//     // Test for customer not logged in
//     if ( $this->customer->Is_Logged() === false ) 
//     {

//       //------------------------------------------------------------------------
//       // Customer not logged in
//       //------------------------------------------------------------------------

//       // ???
// //      $this->session->data['redirect'] = $this->url->link( 'account/address', '', 'SSL' );

//       // Set redirect link
//       $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

//       // Set error code
//       $json[ 'return_code' ] = false;

//     }
//     else
//     {

//       //------------------------------------------------------------------------
//       // Customer logged in
//       //------------------------------------------------------------------------

//       $json[ 'return_code' ] = false;

//       if ( $this->parametersExists() ) 
//       {

//         if( count( $this->dataVerification() ) === 0 )
//         {

//           $guid = $this->request->post[ 'guid' ];

//           $data[ 'country_id' ] = $this->request->post[ 'country_id' ];
//           $data[ 'zone_id' ] = $this->request->post[ 'zone_id' ];
//           $data[ 'postcode' ] = $this->request->post[ 'postcode' ];
//           $data[ 'city' ] = $this->request->post[ 'city' ];
//           $data[ 'street' ] = $this->request->post[ 'street' ];
//           $data[ 'house' ] = $this->request->post[ 'house' ];
//           $data[ 'building' ] = $this->request->post[ 'building' ];
//           $data[ 'apartment' ] = $this->request->post[ 'apartment' ];

//           $this->load->model( 'address/address' );

//           $json[ 'redirect_url' ] = $this->url->link( 'account/address/list', '', 'SSL' );

//           $json[ 'return_code' ] = $this->model_address_address->Update( $this->customer->Get_GUID(), $guid, $data );


//         }
//         else
//         {

//           $json['error'] = $this->dataVerification();

//         }

//       }

//     }

//     // Send json data
//     $this->response->Set_Json_Output( $json );

//   }
 //----------------------------------------------------------------------------
  // Update address
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load($this->data, 'account', 'address_form_edit', 'Edit', $this->language->Get_Language_Code());

    // Load data models
    $this->load->model('address/address');

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Address GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    //! @bug ANVILEX KM: GET parameter for AJAX call. May be requered POST???
    if ($this->request->Is_GET_Parameter_GUID('address_guid') === false) 
    {

      //----------------------------------------------------------------------
      // ERROR: Address GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['address_guid'] = $this->data['account_address_form_edit_' . 'address_guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else 
    {

      //----------------------------------------------------------------------
      // Address GUID parameter found
      //----------------------------------------------------------------------

      $data['address_guid'] = trim($this->request->Get_GET_Parameter_As_GUID('address_guid'));

    }

    //------------------------------------------------------------------------
    // Country ID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_ID('country_id') === false) 
    {

      //----------------------------------------------------------------------
      // ERROR: Country ID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['country_id'] = $this->data['account_address_form_edit_' . 'country_id' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Country ID parameter found
      //----------------------------------------------------------------------

      // Store
      $data[ 'country_id' ] = trim( $this->request->Get_POST_Parameter_As_ID( 'country_id' ) );

      // Test country ID validity
      if ( $data[ 'country_id' ] == 0 )
      {

        //--------------------------------------------------------------------
        // ERROR: Country ID invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'country_id' ] = $this->data[ 'account_address_form_edit_' . 'country_id' . '_error' ];

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
    if ($this->request->Is_POST_Parameter_ID('zone_id') === false)
    {

      //----------------------------------------------------------------------
      // ERROR: Zone ID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['zone_id'] = $this->data['account_address_form_edit_' . 'zone_id' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Zone ID parameter found
      //----------------------------------------------------------------------

      // Store
      $data['zone_id'] = trim($this->request->Get_POST_Parameter_As_ID('zone_id'));

      // Test zone ID validity
      if ( $data['zone_id'] == 0 )
      {

        //--------------------------------------------------------------------
        // ERROR: Zone ID invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'zone_id' ] = $this->data[ 'account_address_form_edit_' . 'zone_id' . '_error' ];

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
    //! @ todo ANVILEX KM: Implement minimal length of post code
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'postcode', 1, $this->model_address_address->Get_Address_Postcode_Maximum_String_Size() ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Postcode not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['postcode'] = $this->data['account_address_form_edit_' . 'postcode' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Postcode parameter found and valid
      //----------------------------------------------------------------------

      $data['postcode'] = trim($this->request->Get_POST_Parameter_As_String('postcode'));

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
      $json['error']['district'] = $this->data['account_address_form_edit_' . 'district' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // District parameter found and valid
      //----------------------------------------------------------------------

      $data['district'] = trim($this->request->Get_POST_Parameter_As_String('district'));

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
      $json['error']['city'] = $this->data['account_address_form_edit_' . 'city' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // City parameter found and valid
      //----------------------------------------------------------------------

      $data['city'] = trim($this->request->Get_POST_Parameter_As_String('city'));

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
      $json['error']['street'] = $this->data['account_address_form_edit_' . 'street' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Street parameter found and valid
      //----------------------------------------------------------------------

      $data['street'] = trim($this->request->Get_POST_Parameter_As_String('street'));
      
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
      $json['error']['house'] = $this->data['account_address_form_edit_' . 'house' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // House parameter found
      //----------------------------------------------------------------------

      $data['house'] = trim($this->request->Get_POST_Parameter_As_String('house'));

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
      $json['error']['building'] = $this->data['account_address_form_edit_' . 'building' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } else {

      //----------------------------------------------------------------------
      // Building parameter found
      //----------------------------------------------------------------------

      $data['building'] = trim($this->request->Get_POST_Parameter_As_String('building'));

    }

    //------------------------------------------------------------------------
    // Apartment
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'apartment', 1, $this->model_address_address->Get_Address_Apartment_Maximum_String_Size() ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Apartment not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['apartment'] = $this->data['account_address_form_edit_' . 'apartment' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } else {

      //----------------------------------------------------------------------
      // Apartment parameter found
      //----------------------------------------------------------------------

      $data['apartment'] = trim($this->request->Get_POST_Parameter_As_String('apartment'));
      
    }

    //------------------------------------------------------------------------
    // Process request data
    //------------------------------------------------------------------------

    // Is request data valid
    if ($request_data_valid === false) 
    {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } 
    else 
    {

      //--------------------------------------------------------------------
      // Parameters present and valid
      //--------------------------------------------------------------------

      // Set success code
      $json[ 'return_code' ] = $this->model_address_address->Update( $this->customer->Get_GUID(), $data['address_guid'], $data );
      
      // Set redirect URL
      $json[ 'redirect_url' ] =  $this->url->link( 'account/address/list', '', 'SSL' );

    }


    // Send json data
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------

  public function country()
  {

    $json = array();

    $country_info = $this->location->Get_Country_Info( $this->request->get['country_id'] );

    if ($country_info)
    {

      $this->load->model('localisation/zone');

      $json = array(
        'country_id'        => $country_info['country_id'],
        'name'              => $country_info['name'],
        'iso_code_2'        => $country_info['iso_code_2'],
        'iso_code_3'        => $country_info['iso_code_3'],
        'address_format'    => $country_info['address_format'],
        'postcode_required' => $country_info['postcode_required'],
        'zone'              => $this->location->Get_Country_Zones($this->request->get['country_id']),
        'status'            => $country_info['status']
      );

    }

    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function set_zones()
  {

    $json = array();

    $json['zone'] = $this->location->Get_Zones();

    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function set_country_by_zone()
  {

    $json = array();

    $zone_info = $this->location->Get_Country_Zone_Info($this->request->get['zone_id']);

    $this->load->model('localisation/zone');

    $json['country_id'] = $zone_info['country_id'];

    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>