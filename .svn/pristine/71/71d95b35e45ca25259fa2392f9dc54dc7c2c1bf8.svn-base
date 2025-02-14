<?php
class ControllerWorkplaceCustomersEndpointsAllow extends Controller
{
  //----------------------------------------------------------------------------
  // Allow Endpoint
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Allow()
  {

    // Init json data
    $json = array();

    if (
      ($this->request->Is_GET_Parameter_GUID('customer_guid') === false) ||
      ($this->request->Is_GET_Parameter_GUID('endpoint_guid') === false)
    ) {
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

      if ($this->model_endpoints_endpoints->Is_Exist_Customer_Endpoint($customer_guid, $endpoint_guid) == true) {

        // Set error code
        $json['return_code'] = false;
      } else
      {

        $this->model_endpoints_endpoints->Allow_Customer_Endpoint($customer_guid, $endpoint_guid);
       
        // Set success code
        $json['return_code'] = true;
        $json['redirect_url'] = $this->url->link( 'workplace/customers/info', 'guid=' .  $customer_guid, 'SSL' );
      }

 

    }


    // Render page
    $this->response->Set_Json_Output($json);

  }


}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>