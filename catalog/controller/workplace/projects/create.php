<?php
class ControllerWorkplaceProjectsCreate extends Controller
{
  private $error = array();

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'add_project', 'index', $this->language->Get_Language_Code() );

    // Load data model
    $this->load->model( 'items/items' );
    $this->load->model( 'customers/customers' );
    $this->load->model( 'manufacturers/manufacturers' );
    $this->load->model( 'projects/projects' );

    // Test for Project GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // Project GUID parameter not found, create new Project
      //----------------------------------------------------------------------
      $this->data[ 'project_clone' ] = false;
    }
    else
    {

      //----------------------------------------------------------------------
      // Project GUID present and valid, clone Project
      //----------------------------------------------------------------------

      // Get Project GUID
      $project_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get project information
      $this->data[ 'project' ]= $this->model_projects_projects->Get_Information( $project_guid );
      //----------------------------------------------------------------------
      if ( $this->data[ 'project' ][ 'return_code' ] === false )
      {

        //--------------------------------------------------------------------
        // ERROR: Project not found
        //--------------------------------------------------------------------
        $this->data[ 'project_clone' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Project found
        //--------------------------------------------------------------------
        $this->data[ 'project_clone' ] = true;
        $this->data['cancel_button_href'] = $this->url->link('workplace/projects/info', 'guid=' . $project_guid, 'SSL');

      }

    }

    // Set links
    $this->data[ 'workplace_add_project_button_href' ] = $this->url->link( 'workplace/projects/create/Add_Project', '', 'SSL' );

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
  // Create new item
  //----------------------------------------------------------------------------

  public function Add_Project()
  {

    // Init json data
    $json = array();

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
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

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'add_project', 'Add_Project', $this->language->Get_Language_Code() );

      // Load data model
      $this->load->model( 'projects/projects' );

      // Init project data
      $project_data[ 'designator' ] = "";
      $project_data[ 'name' ] = "";
      $project_data[ 'descriptor' ] = "";
      $project_data[ 'favorite' ] = false;

      // Clear request data valid status
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Project designator
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Boolean( 'auto_designator' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Auto designator parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'auto_designator' ] = $this->data[ 'workplace_add_project_auto_number_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Auto designator parameter found
        //----------------------------------------------------------------------

        // Test for use manual entered project designator
        if( $this->request->Get_POST_Parameter_As_Boolean( 'auto_designator' ) === false )
        {

          //------------------------------------------------------------------------
          // Project designator should be entered manual
          //------------------------------------------------------------------------

          // Test for parameter exists
          if( $this->request->Is_POST_Parameter_Exists( 'designator' ) === false )
          {

            //----------------------------------------------------------------------
            // ERROR: Designator parameter not found
            //----------------------------------------------------------------------

            // Set error message text
            $json[ 'error' ][ 'designator' ] = $this->data[ 'workplace_add_project_number_error' ];

            // Clear request data valid status
            $request_data_valid = false;

          }
          else
          {

            //----------------------------------------------------------------------
            // Designator parameter found
            //----------------------------------------------------------------------

            // Get project designator
            $project_designator = trim( $this->request->Get_POST_Parameter_As_String( 'designator' ) );

            //! @bug ANVILEX KM: Implement designator checking
            if ( utf8_strlen( $project_designator ) !=  $this->model_projects_projects->Get_Project_Designator_String_Size() )
            {

              // Set error message text
              $json[ 'error' ][ 'designator' ] = $this->data[ 'workplace_add_project_number_not_valid_error' ];

              // Clear request data valid status
              $request_data_valid = false;

            }
            else
            {

              // Test project designator format for validity
              if ( $this->model_projects_projects->Is_Project_Number_Valid( $project_designator ) === false )
              {

                //----------------------------------------------------------------
                // ERROR: Project designator invalid
                //----------------------------------------------------------------

                // Set error message text
                $json[ 'error' ][ 'designator' ] = $this->data[ 'workplace_add_project_number_not_valid_error' ];

                // Clear request data valid status
                $request_data_valid = false;

              }
              else
              {

                //----------------------------------------------------------------
                // Project designator format valid
                //----------------------------------------------------------------

                // Test for project already exists
                if ( $this->model_projects_projects->Is_Exists( $project_designator ) === true )
                {

                  //--------------------------------------------------------------
                  // ERROR: Project already exists
                  //--------------------------------------------------------------

                  // Set error message text
                  $json[ 'error' ][ 'designator' ] = $this->data[ 'workplace_add_project_number_already_exists_error' ];

                  // Clear request data valid status
                  $request_data_valid = false;

                }
                else
                {

                  //--------------------------------------------------------------
                  // Project not exists
                  //--------------------------------------------------------------

                  // Store project designator
                  $project_data[ 'designator' ] = $project_designator;

                }

              }

            }

          }

        }
        else
        {

          //------------------------------------------------------------------------
          // Project designator should be created automatically
          //------------------------------------------------------------------------

          // Store project designator
          $project_data[ 'designator' ] = $this->model_projects_projects->Get_Next_Project_Number();

        }
      
      }

      //------------------------------------------------------------------------
      // Project name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'name' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name' ] = $this->data[ 'workplace_add_project_name_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Project name parameter found
        //----------------------------------------------------------------------

        // Get project name
        $project_name = trim( $this->request->Get_POST_Parameter_As_String( 'name' ) );

        // Test name validity
        if ( ( utf8_strlen( $project_name ) > $this->model_projects_projects->Get_Project_Name_Maximum_String_Size() ) ||
        ( utf8_strlen( $project_name ) < 1) )
        {

          //--------------------------------------------------------------------
          // ERROR: Name invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'name' ] = $this->data[ 'workplace_add_project_name_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Name valid
          //--------------------------------------------------------------------

          // Store project name
          $project_data[ 'name' ] = $project_name;

        }

      }

      //------------------------------------------------------------------------
      // Project description
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'description' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Description parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_add_project_description_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Description parameter found
        //----------------------------------------------------------------------

        // Store project description
        $project_description = trim( $this->request->Get_POST_Parameter_As_String( 'description' ) );

        // Test description validity
        if ( utf8_strlen( $project_description ) > $this->model_projects_projects->Get_Project_Description_Maximum_String_Size() )
        {

          //--------------------------------------------------------------------
          // ERROR: Description invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_add_project_description_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Description valid
          //--------------------------------------------------------------------

          // Store project description
          $project_data[ 'description' ] = $project_description;

        }

      }

      //------------------------------------------------------------------------
      // Favorite
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Boolean( 'favorite' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Favorite parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'favorite' ] = $this->data[ 'workplace_add_project_favorite_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Favorite parameter found and valid
        //----------------------------------------------------------------------

        // Store customer data
        $project_data[ 'favorite' ] = $this->request->Get_POST_Parameter_As_Boolean( 'favorite' );

      }

      //------------------------------------------------------------------------
      // Process request
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

        // Generate item GUID
        $guid = UUID_V4_T1();

        // Try to create new project
        $return_data = $this->model_projects_projects->Add_Project($guid, $project_data );

        // Test for project not created
        if ( $return_data[ 'return_code' ] === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Project not created
          //--------------------------------------------------------------------

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Project created
          //--------------------------------------------------------------------

          // Test for project should be added to favorite projects
          if( $project_data[ 'favorite' ] === true )
          {

            // Add item to customer favorites list
            $this->model_projects_projects->Add_To_Favorites( $this->customer->Get_GUID(), $return_data[ 'guid' ] );

          }

          // Set redirect URL
          $json[ 'redirect_url' ] = $this->url->link( 'workplace/projects/info', 'guid=' . $guid, 'SSL' );

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