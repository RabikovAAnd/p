<?php
class ControllerWorkplaceCustomersRelationshipsRemove extends Controller
{
  //----------------------------------------------------------------------------
  // Delete Relationship
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();

    if(($this->request->Is_GET_Parameter_GUID('guid') === false)||
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

      // Get parent customer GUID
      $parent_guid = $this->request->Get_GET_Parameter_As_GUID('guid');
      // Get customer GUID
      $customer_guid = $this->request->Get_GET_Parameter_As_GUID('customer_guid');

      // Load data model
      $this->load->model('customers/customers');

      $json[ 'delete' ] = 'customer' . $customer_guid;

      $this->model_customers_customers->Remove_Related_Customer($parent_guid,$customer_guid);
      
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