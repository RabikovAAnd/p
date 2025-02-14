<?php
class ControllerWorkplaceUnitsGroupsEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'units_groups_edit', 'index', $this->language->Get_Language_Code() );

    // Test for Group GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Group GUID parameter not found
      //----------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Group GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get group guid
      $group_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get units group information
      $unit_group = $this->units->Get_Unit_Group_Info( $group_guid, $this->language->Get_Language_Code() );
      $this->data[ 'unit_group' ] = $unit_group[ 'data' ];

      // Initialise group languages
      $this->data[ 'group_languages' ] = array();

      // Get languages
      $languages = $this->language->Get_Languages();
      
      // Process all languages
      foreach( $languages as $language )
      {

        // Get units group information
        $unit_group = $this->units->Get_Unit_Group_Info( $group_guid, $language[ 'code' ] );

        // Set group languages data
        $this->data[ 'group_languages' ][] = array(
          'code' => $language[ 'code' ],
          'name' => ( isset( $unit_group[ 'data' ][ 'name' ] ) === true ) ? $unit_group[ 'data' ][ 'name' ] : '',
          'label' => $this->data[ 'workplace_units_groups_edit'. '_name_label' ] . ' (' .$language[ 'code' ] . ')' ,
          'hint' => $this->data[ 'workplace_units_groups_edit_' . $language[ 'code' ] . '_name_hint' ],
          'placeholder' => $this->data[ 'workplace_units_groups_edit_' . $language[ 'code' ] . '_name_placeholder' ]
        );

      }

      // Set list of statuses
      $this->data[ 'status_list' ] = [ 'inactive', 'active', 'deleted' ];

      // Set links
      $this->data[ 'edit_button_href' ] = $this->url->link( 'workplace/units/groups/edit/edit', 'guid=' . $group_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] =  $this->request->Get_Request_Referer();

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

  //----------------------------------------------------------------------------
  // Edit group
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'edit_group', 'edit', $this->language->Get_Language_Code() );

    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Group GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Group GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_edit_group_' . 'guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Group GUID parameter found
      //----------------------------------------------------------------------

      // Set unit group GUID
      $data[ 'guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'guid' ) );

    }

    // Get list of languages
    $languages =$this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      //------------------------------------------------------------------------
      // Unit group name
      //------------------------------------------------------------------------

      // Test for parameter exists
//      if( $this->request->Is_POST_Parameter_Certain_Size_String( 'group_name_'.  $language[ 'code' ], 1, $this->model_documents_documents->Get_Document_Type_Name_Maximum_String_Size() ) === false )
      if( $this->request->Is_POST_Parameter_Certain_Size_String( 'group_name_'.  $language[ 'code' ], 1, 255 ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'group_name_' .  $language[ 'code' ] ] = $this->data[ 'workplace_documents_types_edit_name_error' ] . " (" . $language[ 'guid' ] .")";

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Unit group name parameter found
        //----------------------------------------------------------------------

        // Store unit group name
        $data[ 'name' ][ $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'group_name_' .  $language[ 'code' ] ) );

      }

    }

    //------------------------------------------------------------------------
    // Status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Enum( 'status', [ 'inactive', 'active', 'deleted' ] ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Status parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_edit_group_' . 'status' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Status parameter found
      //----------------------------------------------------------------------

      // Set document type status
      $data[ 'status' ] = trim($this->request->Get_POST_Parameter_As_String( 'status' ) );

    }

    //------------------------------------------------------------------------
    // Process data
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

      // Update unit group
      $this->units->Update_Unit_Group( $data );

      // Set redirect URL
      $json[ 'redirect_url' ] = $this->url->link( 'workplace/units/groups/list', '', 'SSL' );

      // Set success code
      $json[ 'return_code' ] = true;

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>