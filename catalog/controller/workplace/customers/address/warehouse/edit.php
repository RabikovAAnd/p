<?php
class ControllerWorkplaceCustomersAddressWarehouseEdit extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------

  public function index()
  {
   
    if ($this->request->Is_GET_Parameter_GUID('guid') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not set
      //------------------------------------------------------------------------


    } else {

      //------------------------------------------------------------------------
      // Parameter found, continue processing
      //------------------------------------------------------------------------

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'customers_address_warehouse_edit', 'index', $this->language->Get_Language_Code());

      // Load model
      $this->load->model('warehouse/warehouse');

      // Get warehouse GUID
      $warehouse_guid = $this->request->Get_GET_Parameter_As_String('guid');
      // Get warehouse
      $warehouse =  $this->model_warehouse_warehouse->Get_Warehouse( $warehouse_guid );

      // Set warehouse data
      $this->data[ 'warehouse' ] = array(
        'guid' => $warehouse[ 'guid' ],
        'name' => $warehouse[ 'name' ],
        'description' => $warehouse[ 'description' ],
        'code' => $warehouse[ 'code' ],
        'creation_date' => $warehouse[ 'creation_date' ],
        'status' => $warehouse[ 'status' ]
      );


      $this->data['save_button_href'] = $this->url->link('workplace/customers/address/warehouse/edit/Edit', 'warehouse_guid=' . $warehouse_guid, 'SSL');
      $this->data['cancel_button_href'] = $this->url->link('workplace/customers/address/warehouse/info', 'guid=' . $warehouse_guid, 'SSL');

      //-----------------------------------------------------------------------
      // Render page
      //-----------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
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
  // Update warehouse
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'customers_address_warehouse_edit', 'Edit', $this->language->Get_Language_Code());

    // Load data models
    $this->load->model('warehouse/warehouse');

    // Init warehouse data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Warehouse GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_GET_Parameter_GUID('warehouse_guid') === false) 
    {

      //----------------------------------------------------------------------
      // ERROR: Warehouse GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['warehouse_guid'] = $this->data['workplace_customers_address_warehouse_edit_' . 'warehouse_guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else 
    {
      
      $warehouse_guid = trim($this->request->Get_GET_Parameter_As_GUID('warehouse_guid'));

      // Test for parameter exists
      if ( $this->model_warehouse_warehouse->Get_Warehouse( $warehouse_guid )['valid'] === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Warehouse GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['warehouse_guid'] = $this->data['workplace_customers_address_warehouse_edit_' . 'warehouse_guid' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else 
      {
        //----------------------------------------------------------------------
        // Warehouse GUID parameter found
        //----------------------------------------------------------------------

        $data['warehouse_guid'] = $warehouse_guid;

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
      $json[ 'error' ][ 'name' ] = $this->data[ 'workplace_customers_address_warehouse_edit_' . 'name' . '_error' ];

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
      $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_customers_address_warehouse_edit_' . 'description' . '_error' ];

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
      $json[ 'error' ][ 'code' ] = $this->data[ 'workplace_customers_address_warehouse_edit_' . 'code' . '_error' ];

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
      $json['return_code'] = $this->model_warehouse_warehouse->Update($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/customers/address/warehouse/info', 'guid=' . $data['warehouse_guid'], 'SSL');

    }


    // Send json data
    $this->response->Set_Json_Output($json);

  }


}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>