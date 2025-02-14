<?php
class ControllerWorkplacePropertiesGroupsRemove extends Controller
{


  //----------------------------------------------------------------------------
  // Delete Group
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();

    if (
      ($this->request->Is_GET_Parameter_GUID('guid') === false) ||
      ($this->request->Is_GET_Parameter_Boolean('remove') === false)
    ) {
      //----------------------------------------------------------------------
      // ERROR: Parameter not found
      //----------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else {

      //----------------------------------------------------------------------
      // Parameter found, continue processing
      //----------------------------------------------------------------------

      // Get item GUID
      $group_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Load data model
      $this->load->model('properties/properties');

      $json['redirect_url'] = $this->url->link('workplace/properties/groups/list', '', 'SSL');

      $properties = $this->model_properties_properties->Get_Group_Properties($group_guid, $this->language->Get_Language_Code());
      foreach ($properties as $property) {
        $this->model_properties_properties->Remove_Property($property['guid']);
      }
      $this->model_properties_properties->Remove($group_guid);
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