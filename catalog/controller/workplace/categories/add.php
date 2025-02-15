<?php
class ControllerWorkplaceCategoriesAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------
  // Caller: HTTP
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for category GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

    //--------------------------------------------------------------------------
    // ERROR: Category GUID parameter not found
    //--------------------------------------------------------------------------

    //! @todo ANVILEX KM: Redirect to category error page

  }
  else
  {

    //--------------------------------------------------------------------------
    // Category GUID parameter found, continue processing
    //--------------------------------------------------------------------------

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'categories_add', 'index', $this->language->Get_Language_Code());

    // Get category guid
    $category_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over languages
    foreach( $languages as $language )
    {

      // Set category languages data
      $this->data[ 'category_languages' ][] = array(
        'id' => 'name_' . $language[ 'code' ],
        'label' => $this->data[ 'workplace_categories_add_' . 'name_label' ] . ' (' .$language[ 'guid' ] .')',
        'hint' => $this->data[ 'workplace_categories_add_' . $language[ 'code' ] . '_name_hint' ],
        'placeholder' =>$this->data[ 'workplace_categories_add_' . $language[ 'code' ] . '_name_placeholder' ],
        'code' => $language[ 'code' ]
      );

    }

    // Set links
    $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/categories/add/Add', 'guid=' . $category_guid, 'SSL' );
    $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/categories/info', 'guid=' . $category_guid, 'SSL' );

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
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
  // Add new property
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'categories_add', 'add', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'categories/categories' );

    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //--------------------------------------------------------------------------
    // Parent category GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parent category GUID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'category_guid' ] = $this->data[ 'workplace_categories_add_' . 'category_guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parent category GUID parameter found
      //------------------------------------------------------------------------

      // Store parent category GUID
      $data[ 'parent_guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'guid' ) );

    }

    //------------------------------------------------------------------------
    // Multilanguage parameters
    //------------------------------------------------------------------------

    // Get list of active languages
    $languages = $this->language->Get_Languages();

    // Iterate over active languages
    foreach( $languages as $language )
    {

      //------------------------------------------------------------------------
      // Category name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Certain_Size_String( 'name_' . $language[ 'code' ], 1, $this->model_categories_categories->Get_Category_Name_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Category name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name_' .  $language[ 'code' ] ] = $this->data[ 'workplace_categories_add_' . 'name_' .  $language[ 'code' ] . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store category name
        $data[ 'name_' . $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'name_' . $language[ 'code' ] ) );

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
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_categories_add_' . 'status' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Category status parameter found
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
      $this->model_categories_categories->Create_Category( $guid, $data );

      // Set redirect URL to category information page
      $json[ 'redirect_url' ]= $this->url->link( 'workplace/categories/info', 'guid=' . $guid , 'SSL' );

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