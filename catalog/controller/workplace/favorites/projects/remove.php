<?php
class ControllerWorkplaceFavoritesProjectsRemove extends Controller
{


  //----------------------------------------------------------------------------
  // Delete project
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove_From_Favorites()
  {

    // Init json data
    $json = array();

    if (
      ( $this->request->Is_POST_Parameter_GUID( 'guid' ) === false )||
    ($this->request->Is_POST_Parameter_Boolean('remove') === false)
    )
    {

      //----------------------------------------------------------------------
      // ERROR: Parameter not found
      //----------------------------------------------------------------------

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Parameter found, continue processing
      //----------------------------------------------------------------------

      // Get item GUID
      $guid = $this->request->Get_POST_Parameter_As_GUID( 'guid' );

      // Load data model
      $this->load->model( 'projects/projects' );

      if ( $this->model_projects_projects->Is_In_Favorites( $this->customer->Get_GUID(), $guid ) === true )
      {

        if ($this->request->Get_POST_Parameter_As_Boolean('remove') === true) {
          // Set redirect link
          $json[ 'delete' ] = 'project' . $guid;
        } else {
          // Set redirect URL
          $json['redirect_url'] = $this->url->link('workplace/projects/info', 'guid=' .  $guid, 'SSL');
        }

        

        //! @bug ANVILEX KM: 'return_code' redefinition
        $json[ 'return_code' ] = $this->model_projects_projects->Remove_From_Favorites( $this->customer->Get_GUID(), $guid );

        // Set success code
        $json[ 'return_code' ] = true;

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