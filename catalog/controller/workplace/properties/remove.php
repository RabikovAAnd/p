<?php
class ControllerWorkplacePropertiesRemove extends Controller
{
  //----------------------------------------------------------------------------
  // Delete Property
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();

    if($this->request->Is_GET_Parameter_GUID('guid') === false)
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

      // Get property GUID
      $property_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Load data model
      $this->load->model('properties/properties');

      $json['redirect_url'] = $this->request->Get_Request_Referer();

      $this->model_properties_properties->Remove_Property($property_guid);
      
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