<?php
class ControllerWorkplaceDocumentsAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------
  // Caller: HTTP
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'documents_types_add', 'index', $this->language->Get_Language_Code());


    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over languages
    foreach( $languages as $language )
    {
      // Set documents types languages data
      $this->data[ 'document_type_languages' ][] = array(
        'id' => 'name_' . $language[ 'code' ],
        'label' => $this->data[ 'workplace_documents_types_add_' . 'name_label' ] . ' (' .$language[ 'guid' ] .')',
        'hint' => $this->data[ 'workplace_documents_types_add_' . $language[ 'code' ] . '_name_hint' ],
        'placeholder' =>$this->data[ 'workplace_documents_types_add_' . $language[ 'code' ] . '_name_placeholder' ],
        'code' => $language[ 'code' ]
      );

    }

    // Set links
    $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/documents/add/Add', '', 'SSL' );
    $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/documents/types', '', 'SSL' );

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
  // Add new type
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'documents_types_add', 'add', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'documents/documents' );

    // Init json data
    $json = array();

    // Clear request data valid sataus
    $request_data_valid = true;


    //------------------------------------------------------------------------
    // Multilanguage parameters
    //------------------------------------------------------------------------

    // Get list of active languages
    $languages = $this->language->Get_Languages();

    // Iterate over active languages
    foreach( $languages as $language )
    {

      //------------------------------------------------------------------------
      // Document Type name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Certain_Size_String( 'name_' . $language[ 'code' ], 1, $this->model_documents_documents->Get_Document_Type_Name_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Document Type name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name_' .  $language[ 'code' ] ] = $this->data[ 'workplace_documents_types_add_' . 'name_error' ] . ' (' .$language[ 'guid' ] . ')';

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document Type Name parameter found
        //----------------------------------------------------------------------

        // Store Document Type name
        $data[ 'name_' . $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'name_' . $language[ 'code' ] ) );

      }

    }

    //------------------------------------------------------------------------
    // Document Type status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Boolean( 'status' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Document Type status not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_documents_types_add_' . 'status' . '_error' ];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Document Type status parameter found
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

      // Generate category GUID
      $guid = UUID_V4_T1();

      // Create new category
      $this->model_documents_documents->Create_Document_Type( $guid, $data );

      // Set redirect URL to category information page
      $json[ 'redirect_url' ]= $this->url->link( 'workplace/documents/types', '', 'SSL' );

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