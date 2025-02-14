<?php
class ControllerWorkplaceProjectsItemsRemove extends Controller
{

  //----------------------------------------------------------------------------
  // Remove lindex item from project
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link to login page
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load data model
      $this->load->model( 'projects/projects' );

      // Init item data
      $project_data = array();

      // Clear request data valid sataus
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Project guid
      //------------------------------------------------------------------------

      // Test for item GUID parameter exists
      if ( 
        ( $this->request->Is_GET_Parameter_GUID( 'project_guid' ) === false ) ||
        ( $this->request->Is_GET_Parameter_GUID( 'item_guid' ) === false )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameters not found
        //----------------------------------------------------------------------

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameters found and valid
        //----------------------------------------------------------------------

        // Get project GUID
        $project_guid = $this->request->Get_GET_Parameter_As_GUID( 'project_guid' );

        // Get item GUID
        $item_guid =  $this->request->Get_GET_Parameter_As_GUID( 'item_guid' );

      }

      //------------------------------------------------------------------------
      // Process request data
      //------------------------------------------------------------------------

      // Is request data valid
      if ( $request_data_valid === false )
      {

        //------------------------------------------------------------------------
        // ERROR: Parameters not valid
        //------------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Parameters present and valid
        //--------------------------------------------------------------------

        // Remove item from customer favorites list
        $return_data =$this->model_projects_projects->Remove_Item_From_Project( $project_guid, $item_guid );

        // Test for item not created
        if ( $return_data === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Item not created
          //--------------------------------------------------------------------

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Item created
          //--------------------------------------------------------------------

          // Set redirect URL
          $json[ 'delete' ] = 'item' . $item_guid;

          // Set success code
          $json[ 'return_code' ] = true;

        }

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>