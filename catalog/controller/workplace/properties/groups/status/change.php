<?php
class ControllerWorkplacePropertiesGroupsStatusChange extends Controller
{

  //----------------------------------------------------------------------------
  // Change group property status
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Change()
  {

    // Init json data
    $json = array();

    if (
      ($this->request->Is_GET_Parameter_GUID('guid') === false) ||
      ($this->request->Is_GET_Parameter_Exists('status') === false)
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

      // Get group property info
      $group_property_guid = $this->request->Get_GET_Parameter_As_GUID('guid');
      $status = $this->request->Get_GET_Parameter_As_String('status');

      // Load data model
      $this->load->model('properties/properties');

      if (
        ($status != 'inactive') &&
        ($status != 'active') ){
      
      //----------------------------------------------------------------------
      // ERROR: Status parameter not valid
      //----------------------------------------------------------------------
      
      } else
      {

        $this->model_properties_properties->Change_Group_Property_Status($group_property_guid, $status);

        $json['redirect_url'] = $this->url->link('workplace/properties/groups/list', '', 'SSL');

        // Set success code
        $json['return_code'] = true;

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