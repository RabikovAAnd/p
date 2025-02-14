<?php
class ControllerWorkplacePropertiesAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'properties_add', 'index', $this->language->Get_Language_Code() );

    // Test for properties group GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID('guid') === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Properties group GUID parameter not found
      //----------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Properties group GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get properties group guid
      $group_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get list of unit groups
//      $this->data[ 'units' ] = $this->units->Get_Unit_Groups( $this->language->Get_Language_Code() );
      $this->data[ 'units' ] = $this->units->Get_Unit_Groups();

      // Get list of languages
      $languages = $this->language->Get_Languages();

      // Iterate over all languages
      foreach( $languages as $language )
      {

        // Set property languages data
        $this->data['property_languages'][] = array(
          'id' => 'name_' . $language[ 'code' ],
          'label' => $this->data[ 'workplace_properties_add_' . $language[ 'code' ] . '_name_label' ],
          'hint' => $this->data[ 'workplace_properties_add_' . $language[ 'code' ] . '_name_hint' ],
          'placeholder' =>$this->data[ 'workplace_properties_add_' . $language[ 'code' ] . '_name_placeholder' ],
          'code' =>$language[ 'code' ]
        );

      }

      // Set links
      $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/properties/add/Add', 'group_guid=' . $group_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/properties/groups/info', 'guid=' . $group_guid, 'SSL' );

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
  // Add new property
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'properties_add', 'add', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'properties/properties' );

    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid sataus
    $request_data_valid = true;


    //--------------------------------------------------------------------------
    // Properties group GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'group_guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Properties group GUID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'group_guid' ] = $this->data['workplace_properties_add_' . 'group_guid' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Properties group GUID parameter found
      //------------------------------------------------------------------------

      // Store properties group GUID
      $data[ 'group_guid' ] = $this->request->Get_GET_Parameter_As_GUID( 'group_guid' );

    }

    //--------------------------------------------------------------------------
    // Unit GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_GUID( 'unit_guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Unit GUID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'unit_guid' ] = $this->data['workplace_properties_add_' . 'unit_guid' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Unit GUID parameter found
      //------------------------------------------------------------------------

      // Test for parameter valid
      if ( $this->units->Is_Exists_Unit_Groups_By_GUID( $this->request->Get_POST_Parameter_As_GUID( 'unit_guid' ) ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Unit GUID not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'unit_guid' ] = $this->data['workplace_properties_add_' . 'unit_guid' . '_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Unit GUID parameter found and valid
        //----------------------------------------------------------------------

        // Store unit GUID
        $data[ 'unit_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'unit_guid' );

      }

    }

    //--------------------------------------------------------------------------
    // Status
    //--------------------------------------------------------------------------

    //! @todo ANVILEX KM: Implement

    $data[ 'status' ] = 'active';

    //--------------------------------------------------------------------------
    // Multilanguage parameters
    //--------------------------------------------------------------------------

    // Get list of languages
    $languages =$this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language ) 
    {

      //------------------------------------------------------------------------
      // Property name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'name_'.  $language[ 'code' ], 1, $this->model_properties_properties->Get_Property_Name_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name_' .  $language['code'] ] = $this->data[ 'workplace_properties_add_' . 'name_' .  $language['code'] . '_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store property name
        $data[ 'name_' . $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'name_' . $language[ 'code' ] ) );

      }
    
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

      // Generate group GUID
      $guid = UUID_V4_T1();

      // Create new group
      $this->model_properties_properties->Create_Property( $guid, $data );

      // Set redirect URL
      $json[ 'redirect_url' ]= $this->url->link( 'workplace/properties/groups/info', 'guid=' . $data[ 'group_guid' ], 'SSL' );

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