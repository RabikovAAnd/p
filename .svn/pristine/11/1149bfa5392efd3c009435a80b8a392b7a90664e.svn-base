<?php
class ControllerWorkplaceProcessesGroupsInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'processes_groups_info', 'index', $this->language->Get_Language_Code() );

    // Test for Group GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID('guid') === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Process group GUID parameter not found
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Process group GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get process group guid
      $process_group_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      //------------------------------------------------------------------------
      // Process group general data
      //------------------------------------------------------------------------

      // Load data model
      $this->load->model( 'processes' );

      // Get group process information
      $this->data[ 'processes_group' ] = $this->model_processes->Get_Process_Group_Info( $process_group_guid, $this->language->Get_Language_Code() );

      // Get processes
      $processes =  $this->model_processes->Get_Group_Processes( $process_group_guid );

      // Process all processes
      foreach( $processes as $process )
      {

        $process_info = $this->model_processes->Get_Process_Info($process[ 'guid' ], $this->language->Get_Language_Code());

        // Set process data
        $this->data[ 'processes' ][] = array(
          'name' => $process_info[ 'name' ],
          'status' => $process[ 'status' ],
          'guid' => $process[ 'guid' ],
          'href' => $this->url->link( 'workplace/processes/info', 'guid=' . $process[ 'guid' ], 'SSL' ),
          'edit_button_href' => $this->url->link( 'workplace/processes/edit', 'guid=' . $process[ 'guid' ] .'&group_guid=' . $process_group_guid, 'SSL' ),
          'active_button_href' => $this->url->link( 'workplace/processes/status/change/Change', 'guid=' . $process[ 'guid' ] .'&status=active', 'SSL' ),
          'inactive_button_href' => $this->url->link( 'workplace/processes/status/change/Change', 'guid=' . $process[ 'guid' ] .'&status=inactive', 'SSL' ),
          'remove_button_href' => $this->url->link( 'workplace/processes/status/change/Change', 'guid=' . $process[ 'guid' ] .'&status=deleted', 'SSL' ),

        );

      }

      // Set links
      $this->data[ 'edit_button_href'] = $this->url->link( 'workplace/processes/groups/edit', 'guid=' . $process_group_guid, 'SSL' );
      $this->data[ 'add_process_button_href'] = $this->url->link( 'workplace/processes/add', 'group_guid=' . $process_group_guid, 'SSL' );

    }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'index, follow' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>