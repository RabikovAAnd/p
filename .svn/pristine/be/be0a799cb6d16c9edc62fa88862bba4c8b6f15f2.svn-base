<?php
class ControllerWorkplaceCustomersAddressWarehouseBinEdit extends Controller
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
      $this->messages->Load($this->data, 'workplace', 'customers_address_warehouse_bin_edit', 'index', $this->language->Get_Language_Code());

      // Load model
      $this->load->model('warehouse/warehouse');

      // Get bin GUID
      $bin_guid = $this->request->Get_GET_Parameter_As_String('guid');

      // Get  bin data
      $this->data[ 'bin' ] = $this->model_warehouse_warehouse->Get_Warehouse_Bin( $bin_guid );

      $this->data['save_button_href'] = $this->url->link('workplace/customers/address/warehouse/bin/edit/Edit', 'bin_guid=' . $bin_guid, 'SSL');
      $this->data['cancel_button_href'] = $this->url->link('workplace/customers/address/warehouse/info', 'guid=' . $this->data[ 'bin' ][ 'warehouse_guid' ], 'SSL');

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
    $this->messages->Load($this->data, 'workplace', 'customers_address_warehouse_bin_edit', 'Edit', $this->language->Get_Language_Code());

    // Load data models
    $this->load->model('warehouse/warehouse');

    // Init warehouse data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Bin GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_GET_Parameter_GUID('bin_guid') === false) 
    {

      //----------------------------------------------------------------------
      // ERROR: Bin GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['bin_guid'] = $this->data['workplace_customers_address_warehouse_bin_edit_' . 'bin_guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else 
    {
      
      $bin_guid = trim($this->request->Get_GET_Parameter_As_GUID('bin_guid'));
      $bin= $this->model_warehouse_warehouse->Get_Warehouse_Bin( $bin_guid );
      // Test for parameter exists
      if ( $bin['valid'] === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Bin GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['bin_guid'] = $this->data['workplace_customers_address_warehouse_bin_edit_' . 'bin_guid' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else 
      {
        //----------------------------------------------------------------------
        // Bin GUID parameter found
        //----------------------------------------------------------------------

        $data['bin_guid'] = $bin_guid;

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
      $json[ 'error' ][ 'code' ] = $this->data[ 'workplace_customers_address_warehouse_bin_edit_' . 'code' . '_error' ];

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
      $json['return_code'] = $this->model_warehouse_warehouse->Update_Bin($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/customers/address/warehouse/info', 'guid=' . $bin['warehouse_guid'], 'SSL');

    }


    // Send json data
    $this->response->Set_Json_Output($json);

  }


}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>