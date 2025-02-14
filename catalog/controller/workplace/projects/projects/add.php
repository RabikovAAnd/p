<?php
class ControllerWorkplaceProjectsProjectsAdd extends Controller
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
      $this->messages->Load( $this->data, 'workplace', 'projects_projects_add', 'index', $this->language->Get_Language_Code() );

      // Load data model
      $this->load->model('projects/projects');

    // Get projects count
    $this->data[ 'project_count'] = $this->model_projects_projects->Search_Projects_Count(
      '',
      false,
      true,
      false
    );
      // Load item proposal
      $projects = $this->model_projects_projects->Get_List_Of_Projects(30, 1, '', false, true, false, '', $this->language->Get_Language_Code());

    // Iterate over all projects
    foreach ( $projects as $project )
    {
      // Set project data
      $this->data[ 'projects' ][] = array(
        'guid' => $project[ 'guid' ],
        'designator' => $project[ 'designator' ],
        'status' => $project[ 'status' ],
        'name' => $project[ 'name' ],
        'description' => $project[ 'description' ]
      );

    }

      // Compose links
      $this->data['workplace_add_project_button_href'] = $this->url->link('workplace/projects/projects/add/Add', 'guid=' .  $this->data['project_guid'], 'SSL');
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

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
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

      // Test for parameters not valid
      if (
        ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Boolean( 'designator' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Boolean( 'name' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Boolean( 'description' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Positive_Integer( 'page' ) === false )
      )
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
        // All parameters found, continue processing
        //----------------------------------------------------------------------

        // Get parameters
        $search_query = $this->request->Get_POST_Parameter_As_String( 'search' );
        $search_in_project_designator = $this->request->Get_POST_Parameter_As_Boolean( 'designator' );
        $search_in_project_name = $this->request->Get_POST_Parameter_As_Boolean( 'name' );
        $search_in_project_description = $this->request->Get_POST_Parameter_As_Boolean( 'description' );

        // Load data models
        $this->load->model( 'projects/projects' );

        if (
          $search_in_project_designator === false &&
          $search_in_project_name === false &&
          $search_in_project_description === false
        )
        {

          $json[ 'project_count' ] = 0;
          $json[ 'page_count' ] = 0;
          $json[ 'projects' ] = array();

        }
        else
        {

          // Get projects count
          $project_count = $this->model_projects_projects->Search_Projects_Count(
            $search_query,
            $search_in_project_designator,
            $search_in_project_name,
            $search_in_project_description
          );

          $json[ 'project_count' ] = $project_count;
          $json[ 'page_count' ] = intdiv( $project_count, 30 );

          // Get list of projects
          $projects =  $this->model_projects_projects->Get_List_Of_Projects(
            30,
            $this->request->Get_POST_Parameter_As_Integer( 'page' ),
            $search_query,
            $search_in_project_designator,
            $search_in_project_name,
            $search_in_project_description
          );

          // Process each project in the list
          foreach ( $projects as $project )
          {

            $json[ 'projects' ][] = array(
              'guid' => $project[ 'guid' ],
              'designator' => $project[ 'designator' ],
              'status' => $project[ 'status' ],
              'name' => $project[ 'name' ],
              'description' => $project[ 'description' ],
              'href' => $this->url->link( 'workplace/projects/info', 'guid=' . $project[ 'guid' ], 'SSL' )
            );

          }

          // Set success code
          $json[ 'return_code' ] = true;

        }

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }


  //----------------------------------------------------------------------------
  // Add project to project
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
      $this->messages->Load( $this->data, 'workplace', 'projects_projects_add', 'Add', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'projects/projects' );

      // Init json data
      $json = array();

      $json[ 'return_code' ] = false;

      // Init unit data
      $data = array();


      // Clear request data valid status
      $request_data_valid = true;


      //------------------------------------------------------------------------
      // Check parameter: Parent project GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parent project GUID parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'guid' ] = $this->data[ 'workplace_projects_projects_add_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        // Get project information
        $parent_project = $this->model_projects_projects->Get_Information( $this->request->Get_GET_Parameter_As_GUID( 'guid' ));

        // Test for information invalid
        if( $parent_project[ 'return_code' ] === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Parent project GUID parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $this->error[ 'guid' ] = $this->data[ 'workplace_projects_projects_add_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Parent project GUID parameter found
          //----------------------------------------------------------------------

          $data['guid'] = $parent_project[ 'data' ][ 'guid' ];

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Check parameter: Project GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'project_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Project parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'project_guid' ] = $this->data[ 'workplace_projects_projects_add_project_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Project parameter found
        //----------------------------------------------------------------------

        // Get project information
        $project = $this->model_projects_projects->Get_Information( $this->request->Get_POST_Parameter_As_GUID( 'project_guid' ));

        // Test for information invalid
        if( $project[ 'return_code' ] === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Project not valid
          //----------------------------------------------------------------------

          // Set error message text
          $this->error[ 'project_guid' ] = $this->data[ 'workplace_projects_projects_add_project_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Project found
          //--------------------------------------------------------------------

          $data[ 'project_guid' ]=$project[ 'data' ][ 'guid' ];

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Check for Parent Project and Project are the same
      //------------------------------------------------------------------------

      if ( $request_data_valid === true )
      {

        if ($data['guid'] == $data['project_guid'])
        {

          //----------------------------------------------------------------------
          // ERROR: Parent Project and Project are the same
          //----------------------------------------------------------------------

          // Set error message text
          $this->error[ 'same_project' ] = $this->data[ 'workplace_projects_projects_add_same_project_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Parent Project and Project are NOT the same
          //----------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
      }


      //------------------------------------------------------------------------
      // Check for Project Project  already exist
      //------------------------------------------------------------------------

      if ( $request_data_valid === true )
      {

        if ($this->model_projects_projects->Is_Exist_Project_Project($data['guid'], $data['project_guid']))
        {

          //----------------------------------------------------------------------
          // ERROR: Projects Project already exists
          //----------------------------------------------------------------------

          // Set error message text
          $this->error[ 'project_exists' ] = $this->data[ 'workplace_projects_projects_add_project_exists_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Projects Project  not exists
          //----------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
      }


      //------------------------------------------------------------------------
      // Try to add Project
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

        // Add new project
        $return_data = $this->model_projects_projects->Add_Project_To_Project( $data['guid'], $data[ 'project_guid' ] );

        // Test for error
        if ( $return_data === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Create Project failed
          //--------------------------------------------------------------------

          // Set error message
          $json[ 'error' ][ 'error' ] = 'Create and add project failed.';

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // ERROR: Create Project failed
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