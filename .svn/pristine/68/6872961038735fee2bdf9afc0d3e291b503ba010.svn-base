<?php
class ControllerDocumentsReplace extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if (
      ( $this->request->Is_GET_Parameter_GUID( 'document_guid' ) === false ) ||
      ( $this->request->Is_GET_Parameter_GUID( 'item_guid' ) === false )
    )
    {

      //------------------------------------------------------------------------
      // ERROR: Item GUID or document GUID not found
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'documents', 'replace', 'index', $this->language->Get_Language_Code() );

      // Load data model
      $this->load->model( 'documents/documents' );

      // Get document guid
      $document_guid = $this->request->Get_GET_Parameter_As_GUID( 'document_guid' );

      // Get item guid
      $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'item_guid' );

      //! @todo ANVILEX KM: Test document and item GUIDs for validity

      // Get document information
      $this->data[ 'document' ] = $this->model_documents_documents->Get_Information( $document_guid);

      // Test document GUID validity
      if ( $this->data[ 'document' ][ 'valid' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR:  Document guid invalid
        //----------------------------------------------------------------------

      }
      else
      {

        // Set links
        $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/items/info', 'guid='.$item_guid, 'SSL' );
        $this->data[ 'documents_replace_document_button_href' ] = $this->url->link( 'documents/replace/Replace', 'document_guid='.$document_guid . '&item_guid='.$item_guid, 'SSL' );

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

  }

  //----------------------------------------------------------------------------
  // Replace document data
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Replace()
  {

    // Load messages
    $this->messages->Load( $this->data, 'documents', 'replace', 'Replace', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'documents/documents' );
    $this->load->model( 'items/items' );

    // Init json data
    $json = array();

    // Init return status code
    $json[ 'return_code' ] = false;

    // Init item data
    $document_data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //--------------------------------------------------------------------------
    // Item guid parameter
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_GET_Parameter_GUID( 'item_guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Item guid parameter not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'item_guid' ] = $this->data[ 'documents_replace_item_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Item guid parameter found
      //------------------------------------------------------------------------

      // Get item GUID
      $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'item_guid' );

      //! @todo ANVILEX KM: Test for item GUID exists

      // Get item information
      $item = $this->model_items_items->Get_Information( $item_guid );

      // Test GUID validity
      if ( $item[ 'valid' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Item guid invalid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'item_guid' ] = $this->data[ 'documents_replace_item_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item guid valid
        //----------------------------------------------------------------------

      }

    }

    //--------------------------------------------------------------------------
    // Document guid parameter
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_GET_Parameter_GUID( 'document_guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR:  Document guid parameter not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'document_guid' ] = $this->data[ 'documents_replace_document_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Document guid parameter found
      //------------------------------------------------------------------------

      // Store document GUID
      $document_data[ 'document_guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'document_guid' ) );

      // Get document ingormation
      $document = $this->model_documents_documents->Get_Information( $document_data[ 'document_guid' ] );

      // Test GUID validity
      if ( $document[ 'valid' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR:  Document guid invalid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'document_guid' ] = $this->data[ 'documents_replace_document_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document guid valid
        //----------------------------------------------------------------------

      }

    }

    //--------------------------------------------------------------------------
    // Document file
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if( isset( $_FILES[ 'file_data' ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Document file parameter not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'file_data' ] = $this->data[ 'documents_replace_file_data_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Document file parameter found
      //------------------------------------------------------------------------

      //! @todo ANVILEX KM: Check for any upload errors in $_FILES[ 'file_data' ][ 'error' ]

      // Store document content
      $document_data[ 'content' ] = file_get_contents( $_FILES[ 'file_data' ][ 'tmp_name' ] );

      // Store document data
      $document_data[ 'filename' ] = $_FILES[ 'file_data' ][ 'name' ];
      $document_data[ 'mime' ] = $_FILES[ 'file_data' ][ 'type' ];
      $document_data[ 'size' ] = $_FILES[ 'file_data' ][ 'size' ];
      $document_data[ 'hash' ] = md5_file( $_FILES[ 'file_data' ][ 'tmp_name' ], false );

      if( $_FILES[ 'file_data' ][ 'size' ] >= 4294967295 )
      {

        //----------------------------------------------------------------------
        // ERROR: Document file parameter too big
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'file_data' ] = $this->data[ 'documents_replace_file_data_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document file valid
        //----------------------------------------------------------------------

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

      // Set error return code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameters present and valid, try to store document
      //------------------------------------------------------------------------

      // Replace Document data
      if ( $this->model_documents_documents->Replace( $document_data ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Document upload failed
        //----------------------------------------------------------------------

        // Set error return code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document successfully uploaded
        //----------------------------------------------------------------------

        // Set redirect URL
        $json[ 'redirect_url' ] =  $this->url->link( 'workplace/items/info', 'guid=' . $item_guid, 'SSL' );

        // Set success return code
        $json[ 'return_code' ] = true;

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>