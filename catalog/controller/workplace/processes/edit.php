<?php
class ControllerWorkplaceProcessesEdit extends Controller
  {

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
    {

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'processes_edit', 'index', $this->language->Get_Language_Code());

    // Test for process GUID parameter exists
    if (
      ($this->request->Is_GET_Parameter_GUID('guid') === false) ||
      ($this->request->Is_GET_Parameter_GUID('group_guid') === false)
    )
      {

      //----------------------------------------------------------------------
      // ERROR: Process GUID parameter not found
      //----------------------------------------------------------------------

      } else
      {

      //------------------------------------------------------------------------
      // Process GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load data model
      $this->load->model('processes');

      // Get process guid
      $process_guid = $this->request->Get_GET_Parameter_As_GUID('guid');
      $group_guid = $this->request->Get_GET_Parameter_As_GUID('group_guid');

      // Get processes group information
      $this->data['process'] = $this->model_processes->Get_Process_Info($process_guid, $this->language->Get_Language_Code());

      // Initialise process languages
      $this->data['process_languages'] = array();

      // Get languages
      $languages = $this->language->Get_Languages();

      // Process all languages
      foreach ($languages as $language)
        {

        // // Get units group information
        $unit_data = $this->model_processes->Get_Process_Info($process_guid, $language['code']);

        // Set group languages data
        $this->data['process_languages'][] = array(
          'name_id' => 'name_' . $language['code'],
          'name_label' => $this->data['workplace_processes_edit_' . 'name_label'] . ' (' . $language['code'] . ')',
          'name_hint' => $this->data['workplace_processes_edit_' . $language['code'] . '_name_hint'],
          'name_placeholder' => $this->data['workplace_processes_edit_' . $language['code'] . '_name_placeholder'],
          'code' => $language['code'],
          'name_value' => $unit_data['name'],
        );

        }

      // Set list of statuses
      $this->data['status_list'] = ['inactive', 'active', 'deleted'];

      // Set links
      $this->data['edit_button_href'] = $this->url->link('workplace/processes/edit/edit', 'guid=' . $process_guid . '&group_guid=' . $group_guid, 'SSL');
      $this->data['cancel_button_href'] = $this->request->Get_Request_Referer();

      }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setRobots('index, follow');

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
    $this->messages->Load($this->data, 'workplace', 'processes_edit', 'edit', $this->language->Get_Language_Code());

    // Load data model
    $this->load->model('processes');

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
    if ($this->request->Is_GET_Parameter_GUID('group_guid') === false)
      {

      //----------------------------------------------------------------------
      // ERROR: Group GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['group_guid'] = $this->data['workplace_processes_edit_' . 'group_guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

      } else
      {

      //----------------------------------------------------------------------
      // Group GUID parameter found
      //----------------------------------------------------------------------

      // Set unit group GUID
      $data['group_guid'] = trim($this->request->Get_GET_Parameter_As_GUID('group_guid'));

      }

    //------------------------------------------------------------------------
    // Process GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false)
      {

      //----------------------------------------------------------------------
      // ERROR: Process GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['guid'] = $this->data['workplace_processes_edit_' . 'guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

      } else
      {

      //----------------------------------------------------------------------
      // Process GUID parameter found
      //----------------------------------------------------------------------

      // Set process group GUID
      $data['guid'] = trim($this->request->Get_GET_Parameter_As_GUID('guid'));

      }

    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach ($languages as $language)
      {

      //------------------------------------------------------------------------
      // Process name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Certain_Size_String('name_' . $language['code'], 1, 255) === false)
        {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['name_' . $language['code']] = $this->data['workplace_processes_edit_name_error'] . " (" . $language['guid'] . ")";

        // Clear request data valid status
        $request_data_valid = false;

        } else
        {

        //----------------------------------------------------------------------
        // Process name parameter found
        //----------------------------------------------------------------------

        // Store unit name
        $data['name'][$language['code']] = trim($this->request->Get_POST_Parameter_As_String('name_' . $language['code']));
        $this->log->Log_Debug("data[ name ][language[ code ]] = " . $data['name'][$language['code']]);
        }

      }

    //------------------------------------------------------------------------
    // Status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_Enum('status', ['inactive', 'active', 'deleted']) === false)
      {

      //----------------------------------------------------------------------
      // ERROR: Status parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['status'] = $this->data['workplace_processes_edit_' . 'status' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

      } else
      {

      //----------------------------------------------------------------------
      // Status parameter found
      //----------------------------------------------------------------------

      // Set document type status
      $data['status'] = trim($this->request->Get_POST_Parameter_As_String('status'));

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

      } else
      {

      //--------------------------------------------------------------------
      // Parameters present and valid
      //--------------------------------------------------------------------

      // Update process 
      $this->model_processes->Update_Process($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/processes/groups/info', 'guid=' . $data['group_guid'], 'SSL');

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