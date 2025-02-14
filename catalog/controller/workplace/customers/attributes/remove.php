<?php
class ControllerWorkplaceCustomersAttributesRemove extends Controller
{
  //----------------------------------------------------------------------------
  // Delete Attribute
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();

    if(($this->request->Is_GET_Parameter_GUID('index_guid') === false)||
    ($this->request->Is_GET_Parameter_GUID('customer_guid') === false))
    {
      //----------------------------------------------------------------------
      // ERROR: Parameter not found
      //----------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else
    {

      //----------------------------------------------------------------------
      // Parameter found, continue processing
      //----------------------------------------------------------------------

      // Get attribute GUID
      $index_guid = $this->request->Get_GET_Parameter_As_GUID('index_guid');
      // Get customer GUID
      $customer_guid = $this->request->Get_GET_Parameter_As_GUID('customer_guid');

      // Load data model
      $this->load->model('customers/customers');

      $json[ 'delete' ] = 'attribute' . $index_guid;

      $this->model_customers_customers->Remove_Customers_Attribute($customer_guid,$index_guid);
      
      // Set success code
      $json['return_code'] = true;

    }


    // Render page
    $this->response->Set_Json_Output($json);

  }


}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>