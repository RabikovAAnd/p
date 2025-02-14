<?php
class ControllerWorkplacePropertiesEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for Property GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false)
    {

      //----------------------------------------------------------------------
      // ERROR: Property GUID parameter not found
      //----------------------------------------------------------------------


    }
    else
    {

      //------------------------------------------------------------------------
      // Property GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'properties_edit', 'index', $this->language->Get_Language_Code());

      // Get Property guid
      $property_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

    //------------------------------------------------------------------------
    // Load units list data
    //------------------------------------------------------------------------

    // Load data models
    $this->load->model('properties/properties');
    $this->load->model('items/items');

      // Get Property information
      $this->data['property'] = $this->model_properties_properties->Get_Property_Information($property_guid, $this->language->Get_Language_Code());
      $this->data['units'] = $this->units->Get_Unit_Groups();

      $this->data['property']['unit'] = $this->units->Get_Unit_Group_Info($this->data['property']['units_guid']);

      // Get group description
      $properties_description = $this->model_properties_properties->Get_Property_Description($property_guid);

      // Process groups description
      foreach ($properties_description as $property_description)
      {

        // Set groups description data
        $this->data['properties_description'][strtolower($property_description['language_code'])] = array(
          'name' => $property_description['name'],
          'description' => $property_description['description'],
        );

      }

      $languages = $this->language->Get_Languages();

      foreach($languages as $language)
      {

        // Set property languages data
        $this->data['property_languages'][] = array(
          'id' => 'name_' . $language['code'],
          'label' => $this->data['workplace_properties_edit_' . $language['code'] . '_name_label'] ,
          'hint' => $this->data['workplace_properties_edit_'.$language['code'] . '_name_hint'] ,
          'placeholder' =>$this->data['workplace_properties_edit_'.$language['code'] . '_name_placeholder'] ,
          'code' =>$language['code'],
        );
      }

      $this->data['status_list'] = ['inactive', 'active', 'deleted'];

      // Set links
      $this->data['edit_button_href'] = $this->url->link('workplace/properties/edit/Edit', 'guid=' . $property_guid .'&group_guid=' .  $this->data['property']['group_guid'], 'SSL');
      $this->data['cancel_button_href'] =  $this->request->Get_Request_Referer();

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords('');
      $this->response->setRobots('index, follow');

      // Set page configuration
      $this->children = array(
        'common/footer',
        'workplace/menu',
        'common/header'
      );

    }

  }

  //----------------------------------------------------------------------------
  // Edit group
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'properties_edit', 'Edit', $this->language->Get_Language_Code());

    // Init customer data
    $data = array();

    // Clear request data valid sataus
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
      $json[ 'error' ][ 'group_guid' ] = $this->data['workplace_properties_edit_' . 'group_guid' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Group GUID parameter found
      //----------------------------------------------------------------------

      $data[ 'group_guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'group_guid' ) );

    }
    $this->log->Log_Debug( 'group_guid' .  trim( $this->request->Get_GET_Parameter_As_GUID( 'group_guid' ) ));
      //------------------------------------------------------------------------
      // Property GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Property GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'guid' ] = $this->data['workplace_properties_edit_' . 'property_guid' . '_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Property GUID parameter found
        //----------------------------------------------------------------------

        $data[ 'guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'guid' ) );

      }
      $this->log->Log_Debug( 'guid' .  trim( $this->request->Get_GET_Parameter_As_GUID( 'guid' ) ));

      //------------------------------------------------------------------------
      // Unit GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_GUID( 'unit_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Unit GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'unit_guid' ] = $this->data['workplace_properties_edit_' . 'unit_guid' . '_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {
       // Test for parameter valid
      if ( $this->units->Is_Exists_Unit_Groups_By_GUID( trim( $this->request->Get_POST_Parameter_As_GUID( 'unit_guid' ) ) ) === false )
      {
        //----------------------------------------------------------------------
        // ERROR: Unit GUID not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'unit_guid' ] = $this->data['workplace_properties_edit_' . 'unit_guid' . '_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      }else
      {
        //----------------------------------------------------------------------
        // Unit GUID parameter found and valid
        //----------------------------------------------------------------------

        $data[ 'unit_guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'unit_guid' ) );

      }
    }

    $languages =$this->language->Get_Languages();
      
    foreach($languages as $language) {
    //------------------------------------------------------------------------
    // Name
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_POST_Parameter_Exists( 'name_'.  $language['code']) === false )
    {
      //----------------------------------------------------------------------
      // ERROR: Name parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'name_' .  $language['code'] ] = $this->data[ 'workplace_properties_edit_' . 'name_' .  $language['code'] . '_error' ];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Name parameter found
      //----------------------------------------------------------------------

      // Store data
      $data[ 'name_' .  $language['code'] ] = trim( $this->request->Get_POST_Parameter_As_String( 'name_' .  $language['code'] ) );

      // Test group name validity
      if (
        (utf8_strlen( $data[ 'name_' .  $language['code'] ] ) < 1 ) ||
        ( utf8_strlen( $data[ 'name_' .  $language['code'] ] ) > 255 )
      )
      {

        //--------------------------------------------------------------------
        // ERROR: Name invalid
        //--------------------------------------------------------------------

        // Set errer message text
        $json[ 'error' ][ 'name_' .  $language['code'] ] = $this->data[ 'workplace_properties_edit_' . 'name_' .  $language['code'] . '_error' ];
        
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
    // Status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_Exists('status') === false) {
      //----------------------------------------------------------------------
      // ERROR: Status parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['status'] = $this->data['workplace_properties_edit_' . 'status' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    } else
    {
      //----------------------------------------------------------------------
      // Status parameter found
      //----------------------------------------------------------------------

      // Store data
      $data['status'] = trim($this->request->Get_POST_Parameter_As_String('status'));

      // Test group status validity
      if (
        ($data['status'] != 'inactive') &&
        ($data['status'] != 'active') &&
        ($data['status'] != 'deleted')
      ) {
        //--------------------------------------------------------------------
        // ERROR: Status invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json['error']['status'] = $this->data['workplace_properties_edit_' . 'status' . '_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      } else
      {

        //--------------------------------------------------------------------
        // Status valid
        //--------------------------------------------------------------------

      }

    }
    //------------------------------------------------------------------------
    // Process data
    //------------------------------------------------------------------------

    // Is request data valid
    if ($request_data_valid === false) {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else
    {

      //--------------------------------------------------------------------
      // Parameters present and valid
      //--------------------------------------------------------------------

      // Load data models
      $this->load->model('properties/properties');

      // Create new group
      $this->model_properties_properties->Edit_Property($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/properties/groups/info', 'guid=' . $data[ 'group_guid' ], 'SSL');

      // Set success code
      $json['return_code'] = true;

    }

    // Encode and send json data
    $this->response->Set_Json_Output($json);

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>