<?php
class ControllerWorkplaceItemsSuppliersAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'add_supplier', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'customers/suppliers' );

    // Get item guid
    $this->data[ 'item_guid' ] = $this->request->Get_GET_Parameter_As_String( 'item_guid' );

    $this->data[ 'suppliers' ] = $this->model_customers_suppliers->Get_List_Of_Suppliers( 30, '' );

    $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/items/info', 'guid=' .$this->data[ 'item_guid' ], 'SSL' );
    $this->data[ 'workplace_add_supplier_button_href' ] = $this->url->link( 'workplace/items/suppliers/add/Add_Supplier', '', 'SSL' );

    //------------------------------------------------------------------------
    // Rendner page
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
  // Search supplier
  //----------------------------------------------------------------------------

  public function Search()
  {

    // Initialise json data
    $json = array();

    // Test for customer not logged
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Custommer not logged in
      //------------------------------------------------------------------------

      // Set redirect link to login page
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

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
        $this->load->model( 'customers/suppliers' );

        // Get item properties groups
        $suppliers = $this->model_customers_suppliers->Get_List_Of_Suppliers( 30, $this->request->Get_POST_Parameter_As_String( 'search' ) );

        // Process all manufacturer
        foreach ( $suppliers as $supplier )
        {

          $json[ 'suppliers' ][] = array(
            'name' => $supplier[ 'name' ],
            'guid' => $supplier[ 'guid' ] ,
            'lastname' => $supplier[ 'lastname' ],
            'company_name' => $supplier[ 'company_name' ]
          );

        }

      }

      // Set success return code
      $json[ 'return_code' ] = true;

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //--------------------------------------------------------------------------
  // Add Supplier
  //----------------------------------------------------------------------------

  public function Add_Supplier()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'add_supplier', 'Add_Supplier', $this->language->Get_Language_Code() );

    // Load data model
    $this->load->model( 'customers/suppliers' );

    // Init send data
    $send_data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Test for parameter exists
    //------------------------------------------------------------------------

    //------------------------------------------------------------------------
    // Supplier
    //------------------------------------------------------------------------

    if( $this->request->Is_POST_Parameter_GUID( 'supplier' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: supplier parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'supplier' ] = $this->data[ 'workplace_add_supplier_supplier_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // supplier parameter found
      //----------------------------------------------------------------------

      // Store send data
      $send_data[ 'supplier_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'supplier' );

    }

    //------------------------------------------------------------------------
    // Item guid
    //------------------------------------------------------------------------

    if( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: item_guid parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'item_guid' ] = $this->data[ 'workplace_add_supplier_item_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // item_guid parameter found
      //----------------------------------------------------------------------

      // Store send data
      $send_data[ 'item_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

    }

    //------------------------------------------------------------------------
    // Supplier article
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_POST_Parameter_Exists( 'supplier_article' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Supplier article parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'supplier_article' ] = $this->data[ 'workplace_add_supplier_supplier_article_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Supplier article parameter found
      //----------------------------------------------------------------------

      // Get Supplier article
      $supplier_article = trim( $this->request->Get_POST_Parameter_As_String( 'supplier_article' ) );

      // Test name validity
      if ( utf8_strlen( $supplier_article ) > $this->model_customers_suppliers->Get_Supplier_Article_Maximum_String_Size() )
      {

        //--------------------------------------------------------------------
        // ERROR: Supplier article invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'supplier_article' ] = $this->data[ 'workplace_add_supplier_supplier_article_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Supplier article valid
        //--------------------------------------------------------------------

        // Store Supplier article
        $send_data[ 'supplier_article' ] = $supplier_article;

      }

    }

    //------------------------------------------------------------------------

    // Is request data valid
    if ( $request_data_valid === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Parameters not valid
      //----------------------------------------------------------------------

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Parameters present and valid
      //----------------------------------------------------------------------

      // Test for supplier already exists
      if( $this->model_customers_suppliers->Is_Exist_Item_Supplier( $send_data[ 'supplier_guid' ], $send_data[ 'item_guid' ] ) === true )
      {

        //--------------------------------------------------------------------
        // ERROR: Supplier already linked to item
        //--------------------------------------------------------------------

        // Set error code
        $json[ 'error' ][ 'exist' ] = $this->data[ 'workplace_add_supplier_exist_error' ];

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Supplier not linked to item, try to link it
        //--------------------------------------------------------------------

        // Add supplier
        $json[ 'return_code' ] = $this->model_customers_suppliers->Add_Supplier( $send_data );

        // Set redirect URL
        $json[ 'redirect_url' ] =  $this->url->link( 'workplace/items/info', 'guid=' . $send_data[ 'item_guid' ], 'SSL' );

      }

    }

    // Send json data
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>