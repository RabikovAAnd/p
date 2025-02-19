<?php
class ControllerWorkplaceUnitsGroupsInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'units_groups_info', 'index', $this->language->Get_Language_Code() );

    // Test for Group GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID('guid') === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Units group GUID parameter not found
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Units group GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get group unit guid
      $group_unit_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      //------------------------------------------------------------------------
      // Units group general data
      //------------------------------------------------------------------------

      // Get group unit information
      $this->data[ 'group_unit' ] = $this->units->Get_Unit_Group_Info( $group_unit_guid, $this->language->Get_Language_Code() );

      // Get units
      $units =  $this->units->Get_Group_Units( $group_unit_guid );

      // Process all units
      foreach( $units as $unit )
      {

        // Set unit data
        $this->data[ 'units' ][] = array(
          'name' => $unit[ 'name' ],
          'status' => $unit[ 'status' ],
          'guid' => $unit[ 'guid' ],
          'href' => $this->url->link( 'workplace/units/info', 'guid=' . $unit[ 'guid' ], 'SSL' ),
          'edit_button_href' => $this->url->link( 'workplace/units/edit', 'guid=' . $unit[ 'guid' ]  . '&group_guid=' . $group_unit_guid, 'SSL' ),
          'active_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=active', 'SSL' ),
          'inactive_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=inactive', 'SSL' ),
          'remove_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=deleted', 'SSL' ),

        );

      }

      // Set links
      $this->data[ 'edit_button_href'] = $this->url->link( 'workplace/units/groups/edit', 'guid=' . $group_unit_guid, 'SSL' );
      $this->data[ 'add_unit_button_href'] = $this->url->link( 'workplace/units/add', 'group_guid=' . $group_unit_guid, 'SSL' );

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