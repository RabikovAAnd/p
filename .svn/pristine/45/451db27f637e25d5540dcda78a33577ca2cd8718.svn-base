<?php
class ControllerWorkplaceUnitsGroupsList extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'units_groups', 'index', $this->language->Get_Language_Code() );

    // Initialise units groups data section
    $this->data[ 'unit_groups' ] = array();

    // Get unit groups information
    $unit_groups = $this->units->Get_Unit_Groups( $this->language->Get_Language_Code() );

    // Process all unit groups
    foreach ( $unit_groups as $unit_group )
    {

      // Set document type data
      $this->data[ 'unit_groups' ][] = array(
        'guid' => $unit_group[ 'guid' ],
        'status' => $unit_group[ 'status' ],
        'name' => isset( $unit_group[ 'name' ] ) ? $unit_group[ 'name' ] : $unit_group[ 'group_name' ],
        'description' => isset( $unit_group[ 'description' ] ) ? $unit_group[ 'description' ] : '',
        'href' =>  $this->url->link( 'workplace/units/groups/info', 'guid=' . $unit_group[ 'guid' ], 'SSL' ),
        'edit_button_href' =>  $this->url->link( 'workplace/units/groups/edit', 'guid=' . $unit_group[ 'guid' ], 'SSL' ),
        'active_button_href' =>  $this->url->link( 'workplace/units/groups/status/change/Change', 'guid=' . $unit_group[ 'guid' ] .'&status=active', 'SSL' ),
        'inactive_button_href' =>  $this->url->link( 'workplace/units/groups/change/Change', 'guid=' . $unit_group[ 'guid' ] .'&status=inactive', 'SSL' ),
        'remove_button_href' =>  $this->url->link( 'workplace/units/groups/change/Change', 'guid=' . $unit_group[ 'guid' ] .'&status=deleted', 'SSL' )
      );

    }

    // Set links
    $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/units/groups/add', '', 'SSL' );

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