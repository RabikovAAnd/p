<?php
class ControllerWorkplaceDocumentsInfo extends Controller
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
      $this->messages->Load($this->data, 'workplace', 'documents_info', 'index', $this->language->Get_Language_Code());

      // Get document type guid
      $document_type_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      //----------------------------------------------------------------------
      // Group general data
      //----------------------------------------------------------------------

      // Load data models
      $this->load->model('documents/documents');

      // Get document type information
      $this->data[ 'document_type' ] = $this->model_documents_documents->Get_Document_Type_Info( $document_type_guid);
      $this->data[ 'current_name' ]=$this->model_documents_documents->Get_Document_Type_Description( $document_type_guid, $this->language->Get_Language_Code())[ 'name' ];
      // Get document type description
      $document_type_descriptions = $this->model_documents_documents->Get_Document_Type_Descriptions( $document_type_guid);
        
    // Process types descriptions 
    foreach ( $document_type_descriptions as $document_type_description )
    {

      // Set document type data
      $this->data[ 'document_type_descriptions' ][]= array(
        'element_href' => 'type' . $document_type_description[ 'guid' ],
        'guid' => $document_type_description[ 'guid' ],
        'name' =>  $document_type_description[ 'name' ],
        'description' => $document_type_description[ 'description' ],
        'language_code' => $document_type_description[ 'language_code' ],
      );

    }

      //set links
      $this->data['edit_button_href'] = $this->url->link( 'workplace/documents/edit', 'guid=' . $document_type_guid, 'SSL' );
      $this->data['active_button_href'] =$this->url->link( 'workplace/documents/status/change/Change', 'guid=' . $document_type_guid .'&status=active', 'SSL' );
      $this->data['inactive_button_href'] = $this->url->link( 'workplace/documents/status/change/Change', 'guid=' . $document_type_guid .'&status=inactive', 'SSL' );
      $this->data['remove_button_href'] = $this->url->link( 'workplace/documents/status/change/Change', 'guid=' . $document_type_guid .'&status=deleted', 'SSL' );
      // $this->data['add_property_button_href'] = $this->url->link('workplace/properties/add', 'guid=' . $group_guid, 'SSL');
    }

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

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>