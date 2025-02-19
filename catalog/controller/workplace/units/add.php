<?php
class ControllerWorkplaceUnitsAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------
  // Caller: HTTP
  //----------------------------------------------------------------------------

  public function index()
  {
    // Test for Group GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'group_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Group GUID parameter not found
      //----------------------------------------------------------------------

    }
    else
    {
      // Load messages
      $this->messages->Load($this->data, 'workplace', 'units_add', 'index', $this->language->Get_Language_Code());


      // Get group guid
      $group_guid = $this->request->Get_GET_Parameter_As_GUID( 'group_guid' );

      // Get list of languages
      $languages = $this->language->Get_Languages();

      // Iterate over languages
      foreach( $languages as $language )
      {

        // Set unit languages data
        $this->data[ 'unit_languages' ][] = array(
          'name_id' => 'name_' . $language[ 'code' ],
          'symbol_id' => 'symbol_' . $language[ 'code' ],
          'symbol_label' => $this->data[ 'workplace_units_add_' . 'symbol_label' ],
          'language_label' => $this->data[ 'workplace_units_add_' . $language[ 'code' ] . '_language_label' ],
          'name_label' => $this->data[ 'workplace_units_add_' . 'name_label' ],
          'name_hint' => $this->data[ 'workplace_units_add_' . $language[ 'code' ] . '_name_hint' ],
          'name_placeholder' =>$this->data[ 'workplace_units_add_' . $language[ 'code' ] . '_name_placeholder' ],
          'code' => $language[ 'code' ]
        );

      }
      
      // Set links
      $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/units/add/Add', 'group_guid='. $group_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] =  $this->request->Get_Request_Referer();

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'workplace/menu',
        'common/header'
      );

    }
  }

  //----------------------------------------------------------------------------
  // Add new unit
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'units_add', 'add', $this->language->Get_Language_Code() );

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
      $json[ 'error' ][ 'group_guid' ] = $this->data[ 'workplace_units_add_' . 'guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Group GUID parameter found
      //----------------------------------------------------------------------
     
      $group_guid = trim( $this->request->Get_GET_Parameter_As_GUID( 'group_guid' ) );
     
      // Test for parameter exists
      if( $this->units->Is_Exists_Unit_Groups_By_GUID($group_guid) === false )
      {
          
        //----------------------------------------------------------------------
        // ERROR: Group GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'group_guid' ] = $this->data[ 'workplace_units_add_' . 'guid' . '_error' ];

      }else
      {
        // Set unit group GUID
        $data[ 'group_guid' ] =  $group_guid;
      }
  

    }

    //------------------------------------------------------------------------
    // Multilanguage parameters
    //------------------------------------------------------------------------

    // Get list of active languages
    $languages = $this->language->Get_Languages();

    // Iterate over active languages
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
        $json[ 'error' ][ 'symbol_' .  $language[ 'code' ] ] = $this->data[ 'workplace_units_add_' . 'symbol_' .  $language[ 'code' ] . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store category symbol
        $data[ 'symbol_' . $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'symbol_' . $language[ 'code' ] ) );

      }

      //------------------------------------------------------------------------
      // Unit name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Certain_Size_String( 'name_' . $language[ 'code' ], 1, 255 ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Unit name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name_' .  $language[ 'code' ] ] = $this->data[ 'workplace_units_add_' . 'name_' .  $language[ 'code' ] . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store category name
        $data[ 'name_' . $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'name_' . $language[ 'code' ] ) );

      }

    }

    //------------------------------------------------------------------------
    // Unit status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Boolean( 'status' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Unit status not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_units_add_' . 'status' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Unit status parameter found
      //------------------------------------------------------------------------

      // Store category status
      $data[ 'status' ] = trim( $this->request->Get_POST_Parameter_As_Boolean( 'status' ) ) ? 'active' : 'inactive';

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

      // Generate unit GUID
      $guid = UUID_V4_T1();

      // Create new group unit
      $this->units->Create_Unit( $guid, $data );

      // Set redirect URL to units information page
      $json[ 'redirect_url' ]= $this->url->link( 'workplace/units/groups/info', 'guid=' .  $data[ 'group_guid' ] , 'SSL' );

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