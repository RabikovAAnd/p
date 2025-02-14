<?php
class ControllerWorkplaceCustomersAddressWarehouseAdd extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------

  public function index()
  {

    if ( $this->request->Is_GET_Parameter_GUID( 'address_guid' ) === false ) 
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
      $this->messages->Load( $this->data, 'workplace', 'customers_address_warehouse_add', 'index', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model('address/address');
      
      // Get address GUID
      $address_guid = $this->request->Get_GET_Parameter_As_String( 'address_guid' );

      // Get address information
      $address = $this->model_address_address->Get_Address( $address_guid );
      $country_name = $this->location->Get_Country_Info( $address['country_id'] )['name'];
      $zone_name = $this->location->Get_Country_Zone_Info( $address['zone_id'] )['name'];

      $address_text = $address['street'] . ' ' . $address['house'];
      if ($address['building'] != '') {
        $address_text = $address_text . ', ' . $address['building'];
      }
      if ($address['apartment'] != '') {
        $address_text = $address_text . ', ' . $address['apartment'];
      }
      if ($address['district'] != '') {
        $address_text = $address_text . ', ' . $address['district'];
      }
      if ($address['city'] != '') {
        $address_text = $address_text . ' ' . $address['city'];
      }
      if ($country_name != '') {
        $address_text = $address_text . ', ' . $country_name;
      }
      $this->data['address'] = array(
        'guid' => $address['guid'],
        'country_name' => $country_name,
        'zone_name' => $zone_name,
        'postcode' => $address['postcode'],
        'district' => $address['district'],
        'city' => $address['city'],
        'street' => $address['street'],
        'house' => $address['house'],
        'building' => $address['building'],
        'apartment' => $address['apartment'],
        'active' => $address['active'],

        'address_text' => $address_text,
      );

      // Set links
      $this->data[ 'save_button_href' ] = $this->url->link( 'workplace/customers/address/warehouse/add/Add', 'address_guid=' . $address_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/customers/address/info', 'guid=' . $address_guid, 'SSL' );

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
  // Add new warehouse
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_address_warehouse_add', 'Add', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'address/address' );
    $this->load->model( 'warehouse/warehouse' );
    
    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Address GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'address_guid' ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Address GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'address_guid' ] = $this->data[ 'workplace_customers_address_warehouse_add_' . 'address_guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Address GUID parameter found
      //----------------------------------------------------------------------

      // Store address GUID
      $address_guid = trim($this->request->Get_GET_Parameter_As_GUID( 'address_guid' ) );

      // Get address information
      $address = $this->model_address_address->Get_Address( $address_guid );
      // Test for parameter exists
      if ( $address ['valid'] === false ) 
      {

        //----------------------------------------------------------------------
        // ERROR: Address GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'address_guid' ] = $this->data[ 'workplace_customers_address_warehouse_add_' . 'address_guid' . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {
        
        //----------------------------------------------------------------------
        // Description parameter found and valid
        //----------------------------------------------------------------------

        $data[ 'address_guid' ] = $address_guid;
      }
    }

    
    //------------------------------------------------------------------------
    // Name
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'name', 1, $this->model_warehouse_warehouse->Get_Warehouse_Name_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Name not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'name' ] = $this->data[ 'workplace_customers_address_warehouse_add_' . 'name' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Name parameter found and valid
      //----------------------------------------------------------------------

      // Store name
      $data[ 'name' ] = trim( $this->request->Get_POST_Parameter_As_String( 'name' ) );

    }

    //------------------------------------------------------------------------
    // Description
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'description', 0, $this->model_warehouse_warehouse->Get_Warehouse_Description_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Description not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_customers_address_warehouse_add_' . 'description' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Description parameter found and valid
      //----------------------------------------------------------------------

      // Store description
      $data[ 'description' ] = trim( $this->request->Get_POST_Parameter_As_String( 'description' ) );

    }

    //------------------------------------------------------------------------
    // Code
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'code', 1, $this->model_warehouse_warehouse->Get_Warehouse_Code_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Code not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'code' ] = $this->data[ 'workplace_customers_address_warehouse_add_' . 'code' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else 
    {

      //----------------------------------------------------------------------
      // Code parameter found
      //----------------------------------------------------------------------

      // Story code
      $data[ 'code' ] = trim( $this->request->Get_POST_Parameter_As_String( 'code' ) );

    }


    //------------------------------------------------------------------------
    // Status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Boolean( 'status' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Status not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_customers_address_warehouse_add_' . 'status' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Status parameter found
      //------------------------------------------------------------------------

      // Store status
      $data[ 'status' ] = trim( $this->request->Get_POST_Parameter_As_Boolean( 'status' ) ) ? 'active' : 'inactive';

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
      $json[ 'return_code' ] = $this->model_warehouse_warehouse->Create($data );

      // Set redirect URL
      $json[ 'redirect_url' ] = $this->url->link( 'workplace/customers/address/info', 'guid=' . $data[ 'address_guid' ], 'SSL' );

    }

    // Send json data
    $this->response->Set_Json_Output( $json );

  }

 

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>