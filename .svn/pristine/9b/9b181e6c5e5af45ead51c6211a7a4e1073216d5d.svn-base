<?php
class ControllerWorkplaceUnitsStatusChange extends Controller
{

  //----------------------------------------------------------------------------
  // Change Units Status
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

      // Get unit info
      $unit_guid = $this->request->Get_GET_Parameter_As_GUID('guid');
      $status = $this->request->Get_GET_Parameter_As_String('status');

      if (
        ($status != 'inactive') &&
        ($status != 'active') &&
        ($status != 'deleted')
      ){
        
      } else
      {

        //! @bug ANVILEX KM: 'return_code' redefinition
        $this->units->Change_Unit_Status($unit_guid, $status);

        $json['redirect_url'] =  $this->request->Get_Request_Referer();
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