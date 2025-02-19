<?php
class ControllerWorkplaceUnitsEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'units_edit', 'index', $this->language->Get_Language_Code() );

    // Test for unit GUID parameter exists
    if (( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )||
    ( $this->request->Is_GET_Parameter_GUID( 'group_guid' ) === false ))
    {
      
      //----------------------------------------------------------------------
      // ERROR: Unit GUID parameter not found
      //----------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Unit GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get unit guid
      $unit_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );
      $group_guid = $this->request->Get_GET_Parameter_As_GUID( 'group_guid' );

      // Get units group information
      $unit = $this->units->Get_Unit_Info_By_GUID( $unit_guid, $this->language->Get_Language_Code() );
      $this->data[ 'unit' ] = $unit[ 'data' ];

      // Initialise unit languages
      $this->data[ 'unit_languages' ] = array();

      // Get languages
      $languages = $this->language->Get_Languages();
      
      // Process all languages
      foreach( $languages as $language )
      {

        // // Get units group information
        $unit_data = $this->units->Get_Unit_Info_By_GUID( $unit_guid, $language[ 'code' ] );

        // Set group languages data
        $this->data[ 'unit_languages' ][] = array(
          'name_id' => 'name_' . $language[ 'code' ],
          'symbol_id' => 'symbol_' . $language[ 'code' ],
          'symbol_label' => $this->data[ 'workplace_units_edit_' . 'symbol_label' ],
          'language_label' => $this->data[ 'workplace_units_edit_' . $language[ 'code' ] . '_language_label' ],
          'name_label' => $this->data[ 'workplace_units_edit_' . 'name_label' ],
          'name_hint' => $this->data[ 'workplace_units_edit_' . $language[ 'code' ] . '_name_hint' ],
          'name_placeholder' =>$this->data[ 'workplace_units_edit_' . $language[ 'code' ] . '_name_placeholder' ],
          'code' => $language[ 'code' ],
          'symbol_value' => ( isset( $unit_data[ 'data' ][ 'symbol' ] ) === true ) ? $unit_data[ 'data' ][ 'symbol' ] : '',
          'name_value' => ( isset( $unit_data[ 'data' ][ 'name' ] ) === true ) ? $unit_data[ 'data' ][ 'name' ] : '',
        );

      }

      // Set list of statuses
      $this->data[ 'status_list' ] = [ 'inactive', 'active', 'deleted' ];

      // Set links
      $this->data[ 'edit_button_href' ] = $this->url->link( 'workplace/units/edit/edit', 'guid=' . $unit_guid . '&group_guid=' . $group_guid, 'SSL' );
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
  // Edit unit
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'units_edit', 'edit', $this->language->Get_Language_Code() );

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
    if ( $this->request->Is_GET_Parameter_GUID( 'group_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Group GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'group_guid' ] = $this->data[ 'workplace_units_edit_' . 'group_guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Group GUID parameter found
      //----------------------------------------------------------------------

      // Set unit group GUID
      $data[ 'group_guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'group_guid' ) );

    }

    //------------------------------------------------------------------------
    // Unit GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Unit GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_units_edit_' . 'guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Unit GUID parameter found
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
      // Unit symbol
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Certain_Size_String( 'symbol_' . $language[ 'code' ], 1, 255 ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Unit symbol parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'symbol_' .  $language[ 'code' ] ] = $this->data[ 'workplace_units_edit_' . 'symbol_' .  $language[ 'code' ] . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store Unit symbol
        $data[ 'symbol' ][ $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'symbol_' . $language[ 'code' ] ) );

      }

      //------------------------------------------------------------------------
      // Unit name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Certain_Size_String( 'name_'.  $language[ 'code' ], 1, 255 ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name_' .  $language[ 'code' ] ] = $this->data[ 'workplace_units_edit_name_error' ] . " (" . $language[ 'guid' ] .")";

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Unit name parameter found
        //----------------------------------------------------------------------

        // Store unit name
        $data[ 'name' ][ $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'name_' .  $language[ 'code' ] ) );
        $this->log->Log_Debug( "data[ name ][language[ code ]] = " .   $data[ 'name' ][ $language[ 'code' ] ]);
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
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_units_edit_' . 'status' . '_error' ];

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

      // Update unit 
      $this->units->Update_Unit( $data );

      // Set redirect URL
      $json[ 'redirect_url' ] = $this->url->link( 'workplace/units/groups/info', 'guid=' . $data[ 'group_guid' ] , 'SSL' );

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