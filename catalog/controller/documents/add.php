<?php
class ControllerDocumentsAdd extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for item GUID parameter exists
      if ( $this->request->Is_GET_Parameter_GUID( 'item_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Item GUID not found
        //----------------------------------------------------------------------

      }
      else
      {

        //------------------------------------------------------------------------
        // Set page data
        //------------------------------------------------------------------------

        // Load messages
        $this->messages->Load( $this->data, 'documents', 'add', 'index', $this->language->Get_Language_Code() );

        // Load data model
        $this->load->model( 'items/items' );
        $this->load->model( 'documents/documents' );

        // ANVILEX KM: ???? That is this
        $this->data[ 'units' ] = $this->model_items_items->Get_Units( $this->language->Get_Language_Code() );

        // Get item guid
        $this->data[ 'item_guid' ] = $this->request->Get_GET_Parameter_As_GUID( 'item_guid' );

        // Set link
        $this->data[ 'documents_add_document_button_href' ] = $this->url->link( 'documents/add/Add_Document', '', 'SSL' );

        // Get document types
        $document_types = $this->model_documents_documents->Get_List_Of_Document_Types( 30, '' );

        // Process all manufacturer
        foreach ( $document_types as $document_type )
        {

          // Set document type
          $this->data[ 'document_types' ][] = array(
            'name' => $document_type[ 'name' ],
            'guid' => $document_type[ 'guid' ] ,
          );

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

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------

  public function Search()
  {

    // Test for customer not logged
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Custommer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Initialise json data
      $json = array();

      // Test for search query parameter setted
      if ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Search query parameter not set
        //----------------------------------------------------------------------

        // Set error return code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Search query parameter set
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'documents/documents' );

        $document_types =  $this->model_documents_documents->Get_List_Of_Document_Types( 30, $this->request->Get_POST_Parameter_As_String( 'search' ) );

        // Process all manufacturer
        foreach ( $document_types as $document_type )
        {

          $json[ 'document_types' ][] = array(
            'name' => $document_type[ 'name' ],
            'guid' => $document_type[ 'guid' ] ,
          );

        }

        // Set success return code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Add new document to the item
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add_Document()
  {

    // Init json data
    $json = array();

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Custommer not logged in
      //------------------------------------------------------------------------

      // Set redirect link to login page
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer already logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'documents', 'add', 'Add_Document', $this->language->Get_Language_Code() );

      // Init json data
      $json = array();

      // Init return status code
      $json[ 'return_code' ] = false;

      // Init item data
      $document_data = array();

      // Clear request data valid sataus
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Item guid
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_GUID( 'item_guid' ) )
      {

        //----------------------------------------------------------------------
        // ERROR:  Item guid parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'item_guid' ] = $this->data[ 'documents_add_item_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        //  Item guid parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $document_data[ 'item_guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'item_guid' ) );

        // Load data models
        $this->load->model( 'items/items' );

        // Test GUID validity
        if ( $this->model_items_items->Is_Exists_By_GUID( $document_data[ 'item_guid' ] ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR:  Item guid invalid
          //--------------------------------------------------------------------

          // Set error message text
          $this->error[ 'item_guid' ] = $this->data[ 'documents_add_item_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document version valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Document file
      //------------------------------------------------------------------------

      $this->log->Log_Debug('file_data' . count( $_FILES ) );

      // Test for parameter exists
      if( isset( $_FILES[ 'file_data' ] ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Document file parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'file_data' ] = $this->data[ 'documents_add_file_data_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document file parameter found
        //----------------------------------------------------------------------

        //! @todo ANVILEX KM: Check for any upload errors in $_FILES[ 'file_data' ][ 'error' ]

        // Store document content
        $document_data[ 'file_data' ] = file_get_contents( $_FILES[ 'file_data' ][ 'tmp_name' ] );

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
          $this->error[ 'file_data' ] = $this->data[ 'documents_add_file_data_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document file valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Document version
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'document_version' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Document version parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'document_version' ] = $this->data[ 'documents_add_document_version_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document version parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $document_data[ 'document_version' ] = trim( $this->request->Get_POST_Parameter_As_String( 'document_version' ) );

        // Test mpn validity
        if ( utf8_strlen( $document_data[ 'document_version' ] ) > 32 )
        {


          //--------------------------------------------------------------------
          // ERROR: Document version invalid
          //--------------------------------------------------------------------

          // Set error message text
          $this->error[ 'document_version' ] = $this->data[ 'documents_add_document_version_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document version valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Document revision
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'document_revision' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Document revision parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'document_revision' ] = $this->data[ 'documents_add_document_revision_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document revision parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $document_data[ 'document_revision' ] = trim( $this->request->Get_POST_Parameter_As_String( 'document_revision' ) );

        // Test mpn validity
        if ( utf8_strlen( $document_data[ 'document_revision' ] ) > 32 )
        {

          //--------------------------------------------------------------------
          // ERROR: Document revision invalid
          //--------------------------------------------------------------------

          // Set error message text
          $this->error[ 'document_revision' ] = $this->data[ 'documents_add_document_revision_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document revision valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Document date
      //------------------------------------------------------------------------

      if( ! $this->request->Is_POST_Parameter_Exists( 'document_date' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Document date parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'document_date' ] = $this->data[ 'documents_add_document_date_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document date parameter found
        //----------------------------------------------------------------------

        // Test for date empty
        if( $this->request->Is_POST_Parameter_Date( 'document_date' ) )
        {

          // Store start date
          $document_data[ 'document_date' ] = date( "Y-m-d", strtotime( $this->request->Get_POST_Parameter_As_String( 'document_date' ) ) );


        }
        else
        {

          // Set default start date
          $document_data[ 'document_date' ] =  '0000-00-00';

        }

        //----------------------------------------------------------------------
        // Document date valid
        //----------------------------------------------------------------------

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      }

      //------------------------------------------------------------------------
      // Document number
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'document_number' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Document number parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'document_number' ] = $this->data[ 'documents_add_document_number_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document number parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $document_data[ 'document_number' ] = trim( $this->request->Get_POST_Parameter_As_String( 'document_number' ) );

        // Test mpn validity
        if ( utf8_strlen( $document_data[ 'document_number' ] ) > 32 )
        {

          //--------------------------------------------------------------------
          // ERROR: Document number invalid
          //--------------------------------------------------------------------

          // Set error message text
          $this->error[ 'document_number' ] = $this->data[ 'documents_add_document_number_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document number valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Document type
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'document_type' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Document type parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'document_type' ] = $this->data[ 'documents_add_document_type_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document type parameter found
        //----------------------------------------------------------------------

        // Store document data
        $document_data[ 'document_type' ] = trim( $this->request->Get_POST_Parameter_As_String( 'document_type' ) );

        // Load data models
        $this->load->model( 'documents/documents' );

        // Test document type validity
        if ( (utf8_strlen( $document_data[ 'document_type' ] ) > 32)
        || (utf8_strlen( $document_data[ 'document_type' ] )<1)
      || !$this->model_documents_documents->Is_Exists_Document_Type($document_data[ 'document_type' ]))
        {

          //--------------------------------------------------------------------
          // ERROR: Document type invalid
          //--------------------------------------------------------------------

          // Set error message text
          $this->error[ 'document_type' ] = $this->data[ 'documents_add_document_type_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document type valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Document name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'document_name' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Document name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'document_name' ] = $this->data[ 'documents_add_document_name_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $document_data[ 'document_name' ] = trim( $this->request->Get_POST_Parameter_As_String( 'document_name' ) );

        // Test mpn validity
        if (
          ( utf8_strlen( $document_data[ 'document_name' ] ) < 1 ) ||
          ( utf8_strlen( $document_data[ 'document_name' ] ) > 32 )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: Document name invalid
          //--------------------------------------------------------------------

          // Set error message text
          $this->error[ 'document_name' ] = $this->data[ 'documents_add_document_name_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document name valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Document description
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'document_description' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Document description parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'document_description' ] = $this->data[ 'documents_add_document_description_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Document description parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $document_data[ 'document_description' ] = trim( $this->request->Get_POST_Parameter_As_String( 'document_description' ) );

        // Test mpn validity
        if ( utf8_strlen( $document_data[ 'document_description' ] ) > 32 )
        {

          //--------------------------------------------------------------------
          // ERROR: Document description invalid
          //--------------------------------------------------------------------

          // Set error message text
          $this->error[ 'document_description' ] = $this->data[ 'documents_add_document_description_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document description valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

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

        // Set error return code
        $json[ 'return_code' ] = false;

        // Set error codes
        $json[ 'error' ] = $this->error;

      }
      else
      {

        //--------------------------------------------------------------------
        // Parameters present and valid, try to store document
        //--------------------------------------------------------------------

        // Load data model
        $this->load->model( 'documents/documents' );

        // Add new item
//        if ( $this->model_documents_documents->Add_Item_Document( $document_data, $this->language->Get_Language_Code() ) === false )
        if ( $this->model_documents_documents->Add_Item_Document( $document_data ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Document upload failed
          //--------------------------------------------------------------------

          // Set error codes
          $json[ 'error' ] = $this->error;

          // Set error return code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Document successfully uploaded
          //--------------------------------------------------------------------

          // Set redirect URL
          $json[ 'redirect_url' ] =  $this->url->link( 'workplace/items/info', 'guid=' . $document_data[ 'item_guid' ], 'SSL' );

          // Set success return code
          $json[ 'return_code' ] = true;

        }

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