<?php
class ControllerWorkplaceCustomersAddressWarehouseBinAdd extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------

  public function index()
  {

    if ( $this->request->Is_GET_Parameter_GUID( 'warehouse_guid' ) === false ) 
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
      $this->messages->Load( $this->data, 'workplace', 'customers_address_warehouse_bin_add', 'index', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model('warehouse/warehouse');
      
      // Get warehouse GUID
      $warehouse_guid = $this->request->Get_GET_Parameter_As_String( 'warehouse_guid' );

  
      // Get warehouse
      $this->data[ 'warehouse' ] =  $this->model_warehouse_warehouse->Get_Warehouse( $warehouse_guid );


      // Set links
      $this->data[ 'save_button_href' ] = $this->url->link( 'workplace/customers/address/warehouse/bin/add/Add', 'warehouse_guid=' . $warehouse_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/customers/address/warehouse/info', 'guid=' . $warehouse_guid, 'SSL' );

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
  // Add new bin
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_address_warehouse_bin_add', 'Add', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'warehouse/warehouse' );
    
    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Warehouse GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'warehouse_guid' ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Warehouse GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'warehouse_guid' ] = $this->data[ 'workplace_customers_address_warehouse_bin_add_' . 'warehouse_guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    } 
    else 
    {

      //----------------------------------------------------------------------
      // Warehouse GUID parameter found
      //----------------------------------------------------------------------

      // Store warehouse GUID
      $warehouse_guid = trim($this->request->Get_GET_Parameter_As_GUID( 'warehouse_guid' ) );

      // Get warehouse information
      $warehouse = $this->model_warehouse_warehouse->Get_Warehouse( $warehouse_guid );

      // Test for parameter exists
      if ( $warehouse ['valid'] === false ) 
      {

        //----------------------------------------------------------------------
        // ERROR: Warehouse GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'warehouse_guid' ] = $this->data[ 'workplace_customers_address_warehouse_bin_add_' . 'warehouse_guid' . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {
        
        //----------------------------------------------------------------------
        // Warehouse GUID parameter found and valid
        //----------------------------------------------------------------------

        $data[ 'warehouse_guid' ] = $warehouse_guid;
      }
    }

   
    //------------------------------------------------------------------------
    // Code
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'code', 1, $this->model_warehouse_warehouse->Get_Bin_Code_Maximum_String_Size() ) === false ) 
    {

      //----------------------------------------------------------------------
      // ERROR: Code not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'code' ] = $this->data[ 'workplace_customers_address_warehouse_bin_add_' . 'code' . '_error' ];

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
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_customers_address_warehouse_bin_add_' . 'status' . '_error' ];

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
      $json[ 'return_code' ] = $this->model_warehouse_warehouse->Create_Bin($data);

      // Set redirect URL
      $json[ 'redirect_url' ] = $this->url->link( 'workplace/customers/address/warehouse/info', 'guid=' . $data[ 'warehouse_guid' ], 'SSL' );

    }

    // Send json data
    $this->response->Set_Json_Output( $json );

  }

 

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>