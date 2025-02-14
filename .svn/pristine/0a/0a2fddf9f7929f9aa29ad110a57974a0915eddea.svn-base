<?php
class ControllerWorkplaceDocumentsStatusChange extends Controller
{

  //----------------------------------------------------------------------------
  // Change document type status
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

      // Get category info
      $type_guid = $this->request->Get_GET_Parameter_As_GUID('guid');
      $status = $this->request->Get_GET_Parameter_As_String('status');

      // Load data model
      $this->load->model('documents/documents');

      if (
        ($status != 'inactive') &&
        ($status != 'active') &&
        ($status != 'deleted')
      ){
      
      //----------------------------------------------------------------------
      // ERROR: Status parameter not valid
      //----------------------------------------------------------------------
      
      } else
      {

        $this->model_documents_documents->Change_Document_Type_Status($type_guid, $status);

        $json['redirect_url'] = $this->url->link( 'workplace/documents/types', '', 'SSL' );

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