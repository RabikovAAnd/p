<?php
class ControllerWorkplaceProcessesGroupsList extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'processes_groups', 'index', $this->language->Get_Language_Code() );

    // Load data model
    $this->load->model( 'processes' );

    // Initialise processes groups data section
    $this->data[ 'processes_groups' ] = array();

    // Get processes groups information
    $processes_groups = $this->model_processes->Get_Processes_Groups( $this->language->Get_Language_Code() );

    // Process all processes groups
    foreach ( $processes_groups as $processes_group )
    {

      // Set processes groups data
      $this->data[ 'processes_groups' ][] = array(
        'guid' => $processes_group[ 'guid' ],
        'status' => $processes_group[ 'status' ],
        'name' => $processes_group[ 'name' ],
        'description' => $processes_group[ 'description' ],
        'href' =>  $this->url->link( 'workplace/processes/groups/info', 'guid=' . $processes_group[ 'guid' ], 'SSL' ),
        'edit_button_href' =>  $this->url->link( 'workplace/processes/groups/edit', 'guid=' . $processes_group[ 'guid' ], 'SSL' ),
        'active_button_href' =>  $this->url->link( 'workplace/processes/groups/status/change/Change', 'guid=' . $processes_group[ 'guid' ] .'&status=active', 'SSL' ),
        'inactive_button_href' =>  $this->url->link( 'workplace/processes/groups/change/Change', 'guid=' . $processes_group[ 'guid' ] .'&status=inactive', 'SSL' ),
        'remove_button_href' =>  $this->url->link( 'workplace/processes/groups/change/Change', 'guid=' . $processes_group[ 'guid' ] .'&status=deleted', 'SSL' )
      );

    }

    // Set links
    $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/processes/groups/add', '', 'SSL' );

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document categories
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