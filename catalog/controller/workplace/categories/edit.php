<?php
class ControllerWorkplaceCategoriesEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for Category GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Category GUID parameter not found
      //----------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Category GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'categories_edit', 'index', $this->language->Get_Language_Code() );

      // Load models
      $this->load->model( 'categories/categories' );
      $this->load->model( 'items/items' );

      // Get category guid
      $category_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get category information
      $this->data[ 'category' ] = $this->model_categories_categories->Get_Category_Information( $category_guid, $this->language->Get_Language_Code() );

      // Get categories description
      $categories_description = $this->model_categories_categories->Get_Category_Description( $category_guid );

      // Process groups description
      foreach ($categories_description as $category_description)
      {

        // Set groups description data
        $this->data[ 'categories_description' ][ strtolower( $category_description[ 'language_code' ] ) ] = array(
          'name' => $category_description[ 'name' ],
          'description' => $category_description[ 'description' ],
        );

      }

      // Get list of languages
      $languages = $this->language->Get_Languages();

      // Iterate over all panguages
      foreach( $languages as $language )
      {

        // Set category languages data
        $this->data[ 'category_languages' ][] = array(
          'id' => 'name_' . $language[ 'code' ],
          'label' => $this->data[ 'workplace_categories_edit_name_label' ] . " (" . $language[ 'guid' ] .")" ,
          'hint' => $this->data[ 'workplace_categories_edit_' . $language[ 'code' ] . '_name_hint' ] ,
          'placeholder' =>$this->data[ 'workplace_categories_edit_' . $language[ 'code' ] . '_name_placeholder' ] ,
          'code' =>$language[ 'code' ]
        );

      }

      $this->data[ 'status_list' ] = [ 'inactive', 'active', 'deleted' ];

      // Set links
      $this->data[ 'edit_button_href' ] = $this->url->link( 'workplace/categories/edit/edit', 'guid=' . $category_guid, 'SSL' );
      $this->data[ 'cancel_button_href' ] =  $this->request->Get_Request_Referer();

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
  // Edit group
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function edit()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'categories_edit', 'Edit', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'categories/categories' );

    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //--------------------------------------------------------------------------
    // Category GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Category GUID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_categories_edit_' . 'category_guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Category GUID parameter found
      //------------------------------------------------------------------------

      $data[ 'guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'guid' ) );

    }

    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      //------------------------------------------------------------------------
      // Name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'name_'. $language[ 'code' ], 1, $this->model_categories_categories->Get_Category_Name_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name_' . $language[ 'code' ] ] = $this->data[ 'workplace_categories_edit_' . 'name_' . $language[ 'code' ] . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store data
        $data[ 'name_' . $language[ 'code' ] ] = trim( $this->request->Get_POST_Parameter_As_String( 'name_' . $language['code'] ) );

      }

    }

    //------------------------------------------------------------------------
    // Status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Exists( 'status' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Status parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_categories_edit_' . 'status' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Status parameter found
      //----------------------------------------------------------------------

      // Store data
      $data[ 'status' ] = trim( $this->request->Get_POST_Parameter_As_String( 'status' ) );

      // Test group status validity
      if (
        ( $data[ 'status' ] != 'inactive' ) &&
        ( $data[ 'status' ] != 'active' ) &&
        ( $data[ 'status' ] != 'deleted' )
      )
      {

        //--------------------------------------------------------------------
        // ERROR: Status invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_categories_edit_' . 'status' . '_error' ];

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

      // Edit Category
      $this->model_categories_categories->Edit_Category( $data );

      // Set redirect URL
      $json[ 'redirect_url' ] = $this->url->link( 'workplace/categories/info', 'guid=' . $data[ 'guid' ], 'SSL' );

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