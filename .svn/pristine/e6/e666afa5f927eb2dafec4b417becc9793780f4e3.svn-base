<?php
class ControllerWorkplaceDocumentsEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for document type GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false) {

      //----------------------------------------------------------------------
      // ERROR: Document type GUID parameter not found
      //----------------------------------------------------------------------


    } else {

      //------------------------------------------------------------------------
      // Document type GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'documents_types_edit', 'index', $this->language->Get_Language_Code());

      // Get document type guid
      $type_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Load models
      $this->load->model('documents/documents');

      // Get type info
      $this->data['type_info'] = $this->model_documents_documents->Get_Document_Type_Info( $type_guid);
      $this->data['current_language'] = strtolower($this->language->Get_Language_Code());

      // Get type description
      $type_descriptions = $this->model_documents_documents->Get_Document_Type_Descriptions( $type_guid);

      // Process type description
      foreach ($type_descriptions as $type_description) {

        // Set type description data
        $this->data['type_descriptions'][strtolower($type_description['language_code'])] = array(
          'name' => $type_description['name'],
          'description' => $type_description['description'],
        );
      }
      
      $languages = $this->language->Get_Languages();
      foreach($languages as $language) {
          // Set type languages data
          $this->data['type_languages'][] = array(
           'id' => 'name_' . $language['code'],
           'label' => $this->data['workplace_documents_types_edit_name_label'] . " (" . $language['guid'] .")" ,
           'hint' => $this->data['workplace_documents_types_edit_'.$language['code'] . '_name_hint'] ,
           'placeholder' =>$this->data['workplace_documents_types_edit_'.$language['code'] . '_name_placeholder'] ,
           'code' =>$language['code'],
         );
      }
      $this->data['status_list'] = ['inactive', 'active', 'deleted'];

      // Set links
      $this->data['edit_button_href'] = $this->url->link('workplace/documents/edit/Edit', 'type_guid=' . $type_guid, 'SSL');
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
    $this->messages->Load($this->data, 'workplace', 'documents_types_edit', 'Edit', $this->language->Get_Language_Code());

    // Init customer data
    $data = array();

    // Clear request data valid sataus
    $request_data_valid = true;
      
   
      //------------------------------------------------------------------------
      // Type GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_GET_Parameter_GUID( 'type_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Type GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'guid' ] = $this->data['workplace_documents_types_edit_' . 'type_guid' . '_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Type GUID parameter found
        //----------------------------------------------------------------------

        $data[ 'guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'type_guid' ) );

      }
    
    $languages =$this->language->Get_Languages();
      
    foreach($languages as $language)
    {
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
        $json[ 'error' ][ 'name_' .  $language['code'] ] = $this->data[ 'workplace_documents_types_edit_name_error' ] . " (" . $language['guid'] .")";

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
          $json[ 'error' ][ 'name_' .  $language['code'] ] = $this->data[ 'workplace_documents_types_edit_name_error' ] . " (" . $language['guid'] .")";
          
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
      $json['error']['status'] = $this->data['workplace_documents_types_edit_' . 'status' . '_error'];

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
        $json['error']['status'] = $this->data['workplace_documents_types_edit_' . 'status' . '_error'];

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
      $this->load->model('documents/documents');

      // Edit Category
      $this->model_documents_documents->Edit_Document_Type($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link( 'workplace/documents/types', '', 'SSL' );

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