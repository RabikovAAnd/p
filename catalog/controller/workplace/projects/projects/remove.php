<?php
class ControllerWorkplaceProjectsProjectsRemove extends Controller
{
  //----------------------------------------------------------------------------
  // Delete Project
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();

    if(($this->request->Is_GET_Parameter_GUID('guid') === false)||
    ($this->request->Is_GET_Parameter_GUID('project_guid') === false))
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

      // Get parent project GUID
      $parent_guid = $this->request->Get_GET_Parameter_As_GUID('guid');
      // Get project GUID
      $project_guid = $this->request->Get_GET_Parameter_As_GUID('project_guid');

      // Load data model
      $this->load->model('projects/projects');

      $json[ 'delete' ] = 'project' . $project_guid;

      $this->model_projects_projects->Remove_Project($parent_guid,$project_guid);
      
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