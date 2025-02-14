<?php
class ControllerWorkplaceCustomersEndpointsProhibit extends Controller
{
  //----------------------------------------------------------------------------
  // Delete Endpoint
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Prohibit()
  {

    // Init json data
    $json = array();

    if (
      ($this->request->Is_GET_Parameter_GUID('customer_guid') === false) ||
      ($this->request->Is_GET_Parameter_GUID('endpoint_guid') === false)
    )
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
      
      // Get customer GUID
      $customer_guid = $this->request->Get_GET_Parameter_As_GUID('customer_guid');
      // Get endpoint GUID
      $endpoint_guid = $this->request->Get_GET_Parameter_As_GUID('endpoint_guid');

      // Load data model
      $this->load->model('endpoints/endpoints');

      // Delete Endpoint
      $this->model_endpoints_endpoints->Prohibit_Customer_Endpoint($customer_guid, $endpoint_guid);
      
      // Set success code
      $json['return_code'] = true;
      $json['redirect_url'] = $this->url->link('workplace/customers/info', 'guid=' . $customer_guid, 'SSL');

    }


    // Render page
    $this->response->Set_Json_Output($json);

  }


}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>