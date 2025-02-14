<?php
class ControllerWorkplaceProjectsInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'project', 'index', $this->language->Get_Language_Code() );

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Item GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page
      $this->response->Redirect( $this->url->link( 'workspace/projects/info', '', 'SSL' ) );
      
    }
    else
    {

      //------------------------------------------------------------------------
      // Item GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load data models
      $this->load->model( 'projects/projects' );
      $this->load->model( 'items/items' );

      //----------------------------------------------------------------------
      // Item general data
      //----------------------------------------------------------------------

      // Get item guid
      $project_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );
      
      // Try to get project information
      $project = $this->model_projects_projects->Get_Information( $project_guid );
      
      if ( $project[ 'return_code' ] === false )
      {
        
        //--------------------------------------------------------------------
        // ERROR: Project not found
        //--------------------------------------------------------------------

      }
      else
      {
        
        //--------------------------------------------------------------------
        // Project information found
        //--------------------------------------------------------------------
        $this->data[ 'elements' ] =[1,2,3, 4];
        // Get item information
        $this->data[ 'project' ] = $project[ 'data' ];
        $this->data[ 'project' ][ 'favorite' ] = $this->model_projects_projects->Is_In_Favorites( $this->customer->Get_GUID(), $project_guid );

        // Compose links
        $this->data[ 'add_project_to_favorites_button_href' ] = $this->url->link( 'workplace/favorites/projects/add/Add_To_Favorites', '', 'SSL' );
        $this->data[ 'remove_project_from_favorites_button_href' ] = $this->url->link( 'workplace/favorites/projects/remove/remove_from_favorites', '', 'SSL' );
        $this->data[ 'edit_project_button_href' ] = $this->url->link( 'workplace/projects/edit', 'guid=' . $project_guid, 'SSL' );
        $this->data[ 'clone_project_button_href' ] = $this->url->link( 'workplace/projects/create', 'guid=' . $project_guid, 'SSL' );

        //--------------------------------------------------------------------
        // Items linked to project
        //--------------------------------------------------------------------

        // Initialise items section
        $this->data[ 'items' ] = array();

        // Get project items
        $items = $this->model_projects_projects->Get_Project_Items( $project_guid );

        // Process project items
        foreach ( $items as $item )
        {

          // Get item data
          $item_data = $this->model_items_items->Get_Information( $item[ 'item_guid' ] );

          // Set subitem data
          $this->data[ 'items' ][] = array(
            'element_href' => 'item' . $item_data[ 'guid' ],
            'item_id' => $item_data[ 'item_id' ],
            'guid' => $item_data[ 'guid' ],
            'mpn' => $item_data[ 'mpn' ],
            'mfg' => $item_data[ 'manufacturer_name' ],
            'item_href' => $this->url->link( 'workplace/items/info', 'guid=' . $item_data[ 'guid' ], 'SSL' ),
            'remove_href' => $this->url->link( 'workplace/projects/items/remove/Remove', 'project_guid=' . $project_guid . '&item_guid=' . $item_data[ 'guid' ], 'SSL' )
          );

        }

        // Get project projects
        $projects = $this->model_projects_projects->Get_Project_Projects( $project_guid );

        // Process project projects
        foreach ( $projects as $project )
        {

          // Get project data
          $project_data = $this->model_projects_projects->Get_Information( $project[ 'project_guid' ] );

          // Set project data
          $this->data[ 'projects' ][] = array(
            'element_href' => 'project' . $project_data[ 'data' ][ 'guid' ],
            'designator' => $project_data[ 'data' ][ 'designator' ],
            'guid' => $project_data[ 'data' ][ 'guid' ],
            'name' => $project_data[ 'data' ][ 'name' ],
            'status' => $project_data[ 'data' ][ 'status' ],
            'href' => $this->url->link( 'workplace/projects/info', 'guid=' . $project_data[ 'data' ][ 'guid' ], 'SSL' ),
            'remove_href' => $this->url->link( 'workplace/projects/projects/remove/Remove', 'guid=' . $project_guid . '&project_guid=' . $project_data[ 'data' ][ 'guid' ], 'SSL' )
          );

        }

        $this->data[ 'add_project_href' ] = $this->url->link( 'workplace/projects/projects/add', 'guid=' . $project_guid, 'SSL' );
        $this->data[ 'add_item_href' ] = $this->url->link( 'workplace/projects/items/add', 'guid=' . $project_guid, 'SSL' );

        //--------------------------------------------------------------------
        // Documents linked to project
        //--------------------------------------------------------------------

        // Initialise documents section
        $this->data[ 'documents' ] = array();

        // Get item linked documents
        $documents = $this->model_projects_projects->Get_Documents( $project_guid );

        // Process item linked documents
        foreach ( $documents as $document )
        {

          // Set document data
          $this->data[ 'documents' ][] = array(
            'name' => $document[ 'name' ],
            'date' => $document[ 'date' ],
            'number' => $document[ 'number' ],
            'version' => $document[ 'version' ],
            'revision' => $document[ 'revision' ],
            'href' => $this->url->link( 'documents/download', 'document_guid=' . $document[ 'guid' ], 'SSL' )
          );

        }

        //--------------------------------------------------------------------
        // Render page
        //--------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle( $this->data[ 'project' ] [ 'name' ] );
        $this->response->setDescription( $this->data[ 'project' ] [ 'description' ] );
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
  // Remove item from favorites list
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove_From_Favorites()
  {

    // Init json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
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

      // Test for item GUID parameter exists
      if ( $this->request->Is_POST_Parameter_GUID( 'guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameter not found
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter found
        //----------------------------------------------------------------------

        // Load data model
        $this->load->model( 'projects/projects' );

        // Get item GUID
        $project_guid = $this->request->Get_POST_Parameter_As_GUID( 'guid' );

        // Remove item from customer favorites list
        $this->model_projects_projects->Remove_From_Favorites( $this->customer->Get_GUID(), $project_guid );

        // Set redirect URL
        $json[ 'redirect_url' ] = $this->url->link( 'workplace/projects/info', 'guid=' . $project_guid, 'SSL' );

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Delete item subitem
  //----------------------------------------------------------------------------
/*
  public function Delete_Subitem()
  {

    // Init json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Set error code
      //! @todo ANVILEX KM: Clean code
      $json[ 'return_code' ] = false;

      if ( 
        $this->request->Is_POST_Parameter_Exists( 'subitem_guid' ) && 
        $this->request->Is_POST_Parameter_Exists( 'item_guid' ) && 
        $this->request->Is_POST_Parameter_Exists( 'designator' ) )
      {

        // Load data model
        $this->load->model( 'items/items' );

        if ( $this->model_items_items->Is_Exist_Item_Subitem( $this->request->Get_POST_Parameter_As_String('item_guid'), $this->request->Get_POST_Parameter_As_String('subitem_guid'), $this->request->Get_POST_Parameter_As_String('designator') ) )
        {

          $json['return_code'] = $this->model_items_items->Delete_Item_Subitem($this->request->Get_POST_Parameter_As_String('item_guid'), $this->request->Get_POST_Parameter_As_String('subitem_guid'), $this->request->Get_POST_Parameter_As_String('designator') );

          // Set redirect link
          $json['redirect_url'] = $this->url->link('workplace/items/info', 'guid=' . $this->request->Get_POST_Parameter_As_String('item_guid'), 'SSL');

        }

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }
*/
  //----------------------------------------------------------------------------
  // Delete task
  //----------------------------------------------------------------------------
/*
  public function Delete_Task()
  {

    // Init json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json['redirect_url'] = $this->url->link('account/login', '', 'SSL');

      // Set error code
      $json['return_code'] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Set error code
      //! @todo ANVILEX KM: Clean code
      $json['return_code'] = false;

      if ( $this->request->Is_POST_Parameter_Exists( 'task_id' ) )
      {

        // Load data model
        $this->load->model( 'projects/projects' );

        $json[ 'return_code' ] = $this->model_tasks_tasks->Delete_Task($this->request->Get_POST_Parameter_As_Integer( 'task_id' ) );

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }
*/
}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>