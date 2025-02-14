<?php
class ControllerWorkplaceProjectsList extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'projects', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'projects/projects' );

    // Get projects count
    $project_count = $this->model_projects_projects->Search_Projects_Count(
      '',
      false,
      true,
      false
    );

    // Set project count
    $this->data[ 'project_count' ] = $project_count;

    // Set page count
    $this->data[ 'page_count' ] = intdiv( $project_count, 30 );

    // Get projects
    $projects = $this->model_projects_projects->Get_List_Of_Projects(
      30,
      1,
      '',
      false,
      true,
      false
    );

    // Initialise projects lidt
    $this->data[ 'projects' ] = array();

    // Iterate over all projects
    foreach ( $projects as $project )
    {
      // Set project data
      $this->data[ 'projects' ][] = array(
        'guid' => $project[ 'guid' ],
        'designator' => $project[ 'designator' ],
        'status' => $project[ 'status' ],
        'name' => $project[ 'name' ],
        'description' => $project[ 'description' ],
        'href' => $this->url->link( 'workplace/projects/info', 'guid=' . $project[ 'guid' ], 'SSL' ),
        'clone_project_button_href' => $this->url->link( 'workplace/projects/create', 'guid=' . $project[ 'guid' ], 'SSL' ),
        'edit_project_button_href' => $this->url->link( 'workplace/projects/edit', 'guid=' . $project[ 'guid' ], 'SSL' )
      );

    }

    // Set links
    $this->data[ 'create_project_href' ] = $this->url->link( 'workplace/projects/create', '', 'SSL' );

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
              'href' => $this->url->link( 'workplace/projects/info', 'guid=' . $project[ 'guid' ], 'SSL' ),
              'clone_project_button_href' => $this->url->link( 'workplace/projects/create', 'guid=' . $project[ 'guid' ], 'SSL' ),
              'edit_project_button_href' => $this->url->link( 'workplace/projects/edit', 'guid=' . $project[ 'guid' ], 'SSL' )
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

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>