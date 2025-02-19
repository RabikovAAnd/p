<?php
class ControllerWorkplacePropertiesGroupsEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for Group GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false)
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


      // Load messages
      $this->messages->Load($this->data, 'workplace', 'edit_group', 'index', $this->language->Get_Language_Code());

      // Get group guid
      $group_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Set links
      $this->data['edit_button_href'] = $this->url->link('workplace/properties/groups/edit/Edit', 'guid=' . $group_guid, 'SSL');
      $this->data['cancel_button_href'] =  $this->request->Get_Request_Referer();

      // Load data models
      $this->load->model('properties/properties');

      // Get group information
      $this->data['group'] = $this->model_properties_properties->Get_Group_Information($group_guid, $this->language->Get_Language_Code());
      $languages =$this->language->Get_Languages();
      foreach($languages as $language)
      {

          // Set group languages data
          $this->data['groups_languages'][] = array(
           'id' => 'group_name_' . $language['code'],
           'label' => $this->data['workplace_edit_group_' . $language['code'] . '_name_label'] ,
           'hint' => $this->data['workplace_edit_group_'.$language['code'] . '_name_hint'] ,
           'placeholder' =>$this->data['workplace_edit_group_'.$language['code'] . '_name_placeholder'] ,
           'code' =>$language['code'],
         );

      }

      // Get group description
      $groups_description = $this->model_properties_properties->Get_Group_Descriptions($group_guid);

      // Process groups description
      foreach ($groups_description as $group_description)
      {

        // Set groups description data
        $this->data['groups_description'][ strtolower($group_description['language_code'])] = array(
          'name' => $group_description['name'],
          'description' => $group_description['description'],
        );

      }

      $this->data['status_list'] = ['inactive', 'active', 'deleted'];

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
    $this->messages->Load($this->data, 'workplace', 'edit_group', 'edit', $this->language->Get_Language_Code());

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
      $json[ 'error' ][ 'guid' ] = $this->data['workplace_edit_group_' . 'guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Group GUID parameter found
      //----------------------------------------------------------------------

      $data[ 'guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'guid' ) );

    }

    $languages =$this->language->Get_Languages();

    foreach($languages as $language)
    {

      //------------------------------------------------------------------------
      // Name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'group_name_'.  $language['code']) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'group_name_'. $language['code'] ] = $this->data[ 'workplace_edit_group_' . 'group_name_'. $language['code'] . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store data
        $data[ 'group_name_' . $language['code'] ] = trim( $this->request->Get_POST_Parameter_As_String( 'group_name_' .  $language['code'] ) );

        // Test group name validity
        if (
          (utf8_strlen( $data[ 'group_name_' .  $language['code'] ] ) < 1 ) ||
          ( utf8_strlen( $data[ 'group_name_' .  $language['code'] ] ) > 255 )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: Name invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'group_name_' .  $language['code'] ] = $this->data[ 'workplace_edit_group_' . 'group_name_' .  $language['code'] . '_error' ];

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
    // Status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_Exists('status') === false)
    {

      //----------------------------------------------------------------------
      // ERROR: Status parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['status'] = $this->data['workplace_edit_group_' . 'status' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
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
      )
      {

        //--------------------------------------------------------------------
        // ERROR: Status invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json['error']['status'] = $this->data['workplace_edit_group_' . 'status' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
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
    if ($request_data_valid === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    }
    else
    {

      //--------------------------------------------------------------------
      // Parameters present and valid
      //--------------------------------------------------------------------

      // Load data models
      $this->load->model('properties/properties');

      // Create new group
      $this->model_properties_properties->Edit_Group($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/properties/groups/list', '', 'SSL');

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