<?php
class ControllerDatabaseDebug extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load model
    $this->load->model( 'database/database' );
//    $this->load->model( 'projects/projects' );

		// Try to process
//      $this->model_database_database->FixEndpoints();

		// Try to process
//      $this->model_database_database->Fix();

		// Try to process
//		$status_code = $this->model_projects_projects->Fix();

		// Try to process
//		$status_code = $this->model_database_database->Process_Contacts();

		// Try to process
//      $this->model_database_database->Update_GUID();

		// Try to process
//		$status_code = $this->model_database_database->Process_Items();

  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>