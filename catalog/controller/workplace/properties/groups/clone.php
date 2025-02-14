<?php
class ControllerWorkplacePropertiesGroupsClone extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------
  // Caller: HTTP
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'properties_groups_clone', 'index', $this->language->Get_Language_Code() );

    // Test for Group GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Group GUID parameter not found
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Group GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load data models
      $this->load->model( 'properties/properties' );

      // Set links
      $this->data[ 'clone_button_href' ] = $this->url->link( 'workplace/properties/groups/clone/Clone', '', 'SSL' );
      $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/properties/groups/list', '', 'SSL' );

      // Get group guid
      $group_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get list of languages
      $languages =$this->language->Get_Languages();

      // Iterate over all languages
      foreach( $languages as $language )
      {

        // Set group languages data
        $this->data[ 'groups_languages' ][] = array(
          'id' => 'group_name_' . $language[ 'code' ],
          'label' => $this->data[ 'workplace_properties_groups_clone_' . $language[ 'code' ] . '_name_label' ] ,
          'name' => $this->model_properties_properties->Get_Group_Description( $group_guid, strtoupper( $language['code'] ) ),
          'hint' => $this->data[ 'workplace_properties_groups_clone_'.$language[ 'code' ] . '_name_hint' ] ,
          'placeholder' =>$this->data[ 'workplace_properties_groups_clone_'.$language[ 'code' ] . '_name_placeholder' ]
        );

      }

      $this->data[ 'groups_properties' ] = $this->model_properties_properties->Get_Group_Properties( $group_guid, $this->language->Get_Language_Code() );

    }

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

  //----------------------------------------------------------------------------
  // Clone group
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Clone()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'add_group', 'add', $this->language->Get_Language_Code() );

    // Init json data
    $json = array();

    // Init page data
    $data = array();

    // Clear request data valid sataus
    $request_data_valid = true;
    
    // Get list of languages
    $languages =$this->language->Get_Languages();

    //--------------------------------------------------------------------------
    // Properties
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Exists( 'properties' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Properties not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'guid' ] = $this->data['workplace_categories_edit_' . 'properties' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Properties parameter found
      //------------------------------------------------------------------------

      $data[ 'guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'properties' ) );

    }

    foreach( $languages as $language )
    {

      //------------------------------------------------------------------------
      // Name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'group_name_'.  $language[ 'code' ] ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'group_name_'. $language[ 'code' ] ] = $this->data[ 'workplace_add_group_' . 'group_name_' . $language[ 'code' ] . '_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Compose parameter name
        $parameter_name = 'group_name_' . $language[ 'code' ];

        // Store data
        $data[ $parameter_name ] = trim( $this->request->Get_POST_Parameter_As_String( $parameter_name ) );

        // Test group name validity
        if (
          ( utf8_strlen( $data[ $parameter_name ] ) < 1 ) ||
          ( utf8_strlen( $data[ $parameter_name ] ) > 255 )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: Name invalid
          //--------------------------------------------------------------------

          // Set errer message text
          $json[ 'error' ][ 'group_name_' .  $language[ 'code' ] ] = $this->data[ 'workplace_add_group_' . 'group_name_' . $language[ 'code' ] . '_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Name valid
          //--------------------------------------------------------------------

        }

      }

    }

    //------------------------------------------------------------------------
    // Category status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Boolean( 'status' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Category status not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_add_group_' . 'status' . '_error' ];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Category status parameter found
      //------------------------------------------------------------------------

      // Store category status
      $data[ 'status' ] = $this->request->Get_POST_Parameter_As_Boolean( 'status' ) === true ? 'active' : 'inactive';

    }

    //------------------------------------------------------------------------
    // Groups properties to clone
    //------------------------------------------------------------------------

    if ( $this->request->Is_POST_Parameter_Array_Of_Boolean( 'groups_properties' ) === false )
    {

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      $array_parameter = $this->request->Get_POST_Parameter_Array_Of_Boolean( 'groups_properties' );

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

      // Load data models
      $this->load->model( 'properties/properties' );

      // Create new group
      // $this->model_properties_properties->Clone_Group( $guid, $data );

      // Set redirect URL
      // $json[ 'redirect_url' ]= $this->url->link( 'workplace/properties/groups/list', '', 'SSL' );

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