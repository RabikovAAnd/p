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

      // Set links
      $this->data[ 'clone_button_href' ] = $this->url->link( 'workplace/properties/groups/clone/Clone', 'group_guid='.$group_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/properties/groups/list', '', 'SSL' );

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

    // Load data models
    $this->load->model( 'properties/properties' );

    // Init json data
    $json = array();

    // Clear request data valid status
    $request_data_valid = true;
    
    // Get list of languages
    $languages =$this->language->Get_Languages();

    // Generate group GUID
    $new_group_guid = UUID_V4_T1();

    //--------------------------------------------------------------------------
    // Group guid
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_Exists( 'group_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Group guid not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'guid' ] = $this->data['workplace_categories_edit_' . 'group_guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Group guid parameter found
      //------------------------------------------------------------------------

      $old_group_guid = $this->request->Get_GET_Parameter_As_GUID( 'group_guid' );
      $data[ 'group' ]['data'] =$this->model_properties_properties->Get_Group_Information($old_group_guid,$this->language->Get_Language_Code() );
        
      // Test for parameter valid
      if( $data[ 'group' ]['data']['valid'] === false )
      {
        //----------------------------------------------------------------------
        // ERROR: Group not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'guid' ] = $this->data['workplace_categories_edit_' . 'group_guid' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;
      }
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

        // Clear request data valid status
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

          // Set error message text
          $json[ 'error' ][ 'group_name_' .  $language[ 'code' ] ] = $this->data[ 'workplace_add_group_' . 'group_name_' . $language[ 'code' ] . '_error' ];

          // Clear request data valid status
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

      // Clear request data valid status
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

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      $data[ 'clone_properties' ] = [];

      $group_properties = $this->request->Get_POST_Parameter_Array_Of_Boolean( 'groups_properties' );

      // Iterate over all properties 
      foreach( $group_properties as $group_property )
      {

        if( array_values( $group_property )[0] == true )
        {

          if($this->model_properties_properties->Is_Group_Property_Exists($old_group_guid,array_keys($group_property)[0])=== false)
          {

            //------------------------------------------------------------------
            // ERROR: Property not found
            //------------------------------------------------------------------

            // Set error message text
            $json[ 'error' ][ 'groups_properties_'.array_keys($group_property)[0] ] = $this->data['workplace_categories_edit_' . 'groups_properties' . '_error'];

          }
          else
          {
            $old_property_guid = (string)array_keys( $group_property )[0];
          
            // $data[ 'clone_properties' ]['description'][] = $this->model_properties_properties->Get_Property_Information( array_keys( $group_property ), $this->language->Get_Language_Code() );
            
            // Generate property GUID
            $new_property_guid = UUID_V4_T1();

            $old_property_info= $this->model_properties_properties->Get_Property_Information( $old_property_guid, $this->language->Get_Language_Code() );
            
            // Set new property info
            $data[ 'clone_properties' ][$new_property_guid]['guid']=$new_property_guid;
            $data[ 'clone_properties' ][$new_property_guid]['group_guid']=$new_group_guid;
            $data[ 'clone_properties' ][$new_property_guid]['unit_guid']=$old_property_info['units_guid'];
            $data[ 'clone_properties' ][$new_property_guid]['status']='inactive';
            // Get properties description
            $properties_description = $this->model_properties_properties->Get_Property_Description($old_property_guid);

            // Process properties description
            foreach ($properties_description as $property_description)
            {

              // Set properties description data
              $data[ 'clone_properties' ][$new_property_guid][ 'name_' .  strtolower($property_description['language_code'])] = $property_description['name'];

            }
          }

        }

      }

    }

    //--------------------------------------------------------------------------
    // Process data
    //--------------------------------------------------------------------------

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

      //------------------------------------------------------------------------
      // Parameters present and valid
      //------------------------------------------------------------------------

      // Create new group
      $this->model_properties_properties->Create_Group( $new_group_guid, $data );

      if(count( $data[ 'clone_properties' ])>0)
      {

        // Process properties description
        foreach ($data[ 'clone_properties' ] as $clone_property)
        {
          // Create new property
          $this->model_properties_properties->Create_Property(  $clone_property['guid'], $clone_property );
        }

      }

      // Set redirect URL
      $json[ 'redirect_url' ]= $this->url->link( 'workplace/properties/groups/list', '', 'SSL' );

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