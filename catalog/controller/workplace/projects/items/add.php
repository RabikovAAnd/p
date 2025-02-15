<?php
class ControllerWorkplaceProjectsItemsAdd extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for project GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false) 
    {

      //----------------------------------------------------------------------
      // ERROR: Project GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to project not found page
      $this->response->Redirect($this->url->link( 'workspace/projects/list', '', 'SSL' ) );

    } 
    else 
    {

      // Get Project GUID parameter
      $this->data['project_guid'] = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'add_item', 'index', $this->language->Get_Language_Code() );

      // Load data model
      $this->load->model('items/items');

      // Load item proposal
      $items = $this->model_items_items->Get_List_Of_Items(30, 1, '', false, true, false, '', $this->language->Get_Language_Code());

      // Process all proposed items
      foreach ( $items as $item )
      {

        // Add item to the list
        $this->data['items'][] = array(
          'guid' => $item['guid'],
          'key' => $item['guid'] . '&' . $item['mpn'] . '&' . $item['manufacturer_name'],
          'mpn' => $item['mpn'],
          'name' => $item['name'],
          'manufacturer_name' => $item['manufacturer_name']
        );

      }

      // Compose links
      $this->data['workplace_add_item_button_href'] = $this->url->link('workplace/projects/items/add/Add', '', 'SSL');
      $this->data['cancel_button_href'] = $this->url->link('workplace/projects/info', 'guid=' .  $this->data['project_guid']  , 'SSL');

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
  // Search query
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Search()
  {

    // Initialise json data
    $json = array();

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
      // Custommer logged in
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: 'search' parameter not found
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter found, continue processing
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'items/items' );

        // Get proposed items
        $items = $this->model_items_items->Get_List_Of_Items( 30, 1, $this->request->Get_POST_Parameter_As_String( 'search' ), false, true, false, '', $this->language->Get_Language_Code());

        // Process all item
        foreach ( $items as $item )
        {

          // Set item data as subitem proposal
          $json[ 'items' ][] = array(
            'guid' => $item[ 'guid' ],
            'mpn' => $item[ 'mpn' ],
            'name' => $item[ 'name' ],
            'manufacturer_name' => $item[ 'manufacturer_name' ]
          );

        }

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Add item to project
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
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
      // Custommer logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'add_item', 'Add', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'projects/projects' );

      // Init json data
      $json = array();

      $json[ 'return_code' ] = false;

      // Init unit data
      $data = array();


      // Clear request data valid status
      $request_data_valid = true;


      //------------------------------------------------------------------------
      // Check parameter: Project GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Project GUID parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'guid' ] = $this->data[ 'workplace_add_item_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        if ($this->model_projects_projects->Is_Exists_By_GUID($this->request->Get_POST_Parameter_As_GUID('guid'))) 
        {

          //----------------------------------------------------------------------
          // Project GUID parameter found
          //----------------------------------------------------------------------

          $data['guid'] = $this->request->Get_POST_Parameter_As_GUID( 'guid' );

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
        else
        {

          //----------------------------------------------------------------------
          // ERROR: Project GUID parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $this->error[ 'guid' ] = $this->data[ 'workplace_add_item_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;
        }


      }

      //------------------------------------------------------------------------
      // Check parameter: Item GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'item_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Item parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'item_guid' ] = $this->data[ 'workplace_add_item_item_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item parameter found
        //----------------------------------------------------------------------

        // Get item information
        $item = $this->model_items_items->Get_Information( $this->request->Get_POST_Parameter_As_GUID( 'item_guid' ) );

        // Test for information invalid
        if( $item[ 'valid' ] === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Item not valid
          //----------------------------------------------------------------------

          // Set error message text
          $this->error[ 'item_guid' ] = $this->data[ 'workplace_add_item_item_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Item found
          //--------------------------------------------------------------------

          $data[ 'item_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Check for Project Item  already exist
      //------------------------------------------------------------------------

      if ( $request_data_valid === true )
      {

        if ($this->model_projects_projects->Is_Exist_Project_Item($data['guid'], $data['item_guid']))
        {

          //----------------------------------------------------------------------
          // ERROR: Project Item already exists
          //----------------------------------------------------------------------

          // Set error message text
          $this->error[ 'item_exists' ] = $this->data[ 'workplace_add_item_item_exists_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Project Item  not exists
          //----------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
      }


      //------------------------------------------------------------------------
      // Try to add item
      //------------------------------------------------------------------------

      // Is request data valid
      if ( $request_data_valid === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameters not valid
        //----------------------------------------------------------------------

        // Set error codes
        $json[ 'error' ] = $this->error;

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameters present and valid, add item
        //----------------------------------------------------------------------

        // Add new item
        $return_data = $this->model_projects_projects->Add_Item( $data['guid'], $data[ 'item_guid' ] );

        // Test for error
        if ( $return_data === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Create item failed
          //--------------------------------------------------------------------

          // Set error message
          $json[ 'error' ][ 'error' ] = 'Create and add item failed.';

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // ERROR: Create item failed
          //--------------------------------------------------------------------

          // Set redirect URL
          $json[ 'redirect_url' ] = $this->url->link( 'workplace/projects/info', 'guid=' . $data[ 'guid' ] , 'SSL' );

          // Set success code
          $json[ 'return_code' ] = true;

        }

      }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>