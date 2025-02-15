<?php
class ControllerWorkplaceProjectsEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Project GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page
      $this->response->Redirect( $this->url->link( 'workplace/projects/error', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Project GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'project_edit', 'index', $this->language->Get_Language_Code() );

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

      // Test for project information getted
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

        // Get item information
        $this->data[ 'project' ] = $project[ 'data' ];

        // Compose links
        $this->data[ 'workplace_project_edit_project_button_href' ] = $this->url->link( 'workplace/projects/edit/Save_Changes', '', 'SSL' );
        $this->data[ 'cancel_button_href' ] = $this->url->link('workplace/projects/info', 'guid=' . $project_guid , 'SSL');

        //--------------------------------------------------------------------
        // Render page
        //--------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle($this->data[ 'project' ] [ 'name' ] );
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
  // Edit project
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Save_Changes()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'project_edit', 'Save_Changes', $this->language->Get_Language_Code() );

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

      // Load data models
      $this->load->model( 'projects/projects' );

      // Init item data
      $project_data = array();

      // Clear request data valid status
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Project guid
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Project guid not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_project_edit_guid_not_exist_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Project guid parameter found
        //----------------------------------------------------------------------

        // Test project guid valid
        if ( $this->model_projects_projects->Is_Exists_By_GUID( trim( $this->request->Get_POST_Parameter_As_GUID( 'guid' ) ) ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Project guid is invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_project_edit_guid_not_exist_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Project guid is valid
          //--------------------------------------------------------------------

          // Assign project GUID
          $project_data[ 'guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'guid' ) );

        }

      }

      //------------------------------------------------------------------------
      // Number
      //------------------------------------------------------------------------

      // Test for parameter exists
//      if ( $this->request->Is_POST_Parameter_Exists( 'number' ) === false )
      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'number', 1, $this->model_projects_projects->Get_Project_Designator_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Number parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'number' ] = $this->data[ 'workplace_project_edit_number_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Number parameter found and valid
        //----------------------------------------------------------------------

        // Get project designator
        $designator = trim( $this->request->Get_POST_Parameter_As_String( 'number' ) );

        // Test project designator format for validity
        if ( $this->model_projects_projects->Is_Project_Number_Valid( $designator ) === false )
        {

          //------------------------------------------------------------------
          // ERROR: Project designator invalid
          //------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'number' ] = $this->data[ 'workplace_project_edit_number_not_valid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //------------------------------------------------------------------
          // Project number valid
          //------------------------------------------------------------------

          // Try to get project information
          $project = $this->model_projects_projects->Get_Information( $project_data[ 'guid' ]);

          //------------------------------------------------------------------
          // Project number format valid
          //------------------------------------------------------------------

          // Test for project number not changed
          if ( $designator != $project[ 'data' ][ 'designator' ] )
          {

            // Test for project already exists
            if ( $this->model_projects_projects->Is_Exists( $designator ) === true )
            {

              //--------------------------------------------------------------
              // ERROR: Project already exists
              //--------------------------------------------------------------

              // Set error message text
              $json[ 'error' ][ 'number' ] = $this->data[ 'workplace_project_edit_number_already_exists_error' ];

              // Clear request data valid status
              $request_data_valid = false;

            }
            else
            {

              //--------------------------------------------------------------
              // Project not exists
              //--------------------------------------------------------------

              // Store project number
              $project_data[ 'designator' ] = $designator;

            }

          }
          else
          {

            //--------------------------------------------------------------
            // Project number not changed
            //--------------------------------------------------------------

            // Store project number
            $project_data[ 'designator' ] = $designator;

          }

        }

      }

      //------------------------------------------------------------------------
      // Project name
      //------------------------------------------------------------------------

      // Test for project name parameter exists
      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'name', 1, $this->model_projects_projects->Get_Project_Name_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Project name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'name' ] = $this->data[ 'workplace_project_edit_name_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Project name parameter found and valud
        //----------------------------------------------------------------------

        // Store Name
        $project_data[ 'name' ] = trim( $this->request->Get_POST_Parameter_As_String( 'name' ) );

      }

      //------------------------------------------------------------------------
      // Project description
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'description', 1, $this->model_projects_projects->Get_Project_Description_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Project description parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'description' ] = $this->data[ 'workplace_project_edit_description_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Description parameter found and valid
        //----------------------------------------------------------------------

        // Store customer data
        $project_data[ 'description' ] = trim( $this->request->Get_POST_Parameter_As_String( 'description' ) );

      }

      //------------------------------------------------------------------------
      // Process request data
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

        // Test for project with same name already exists
        //! @note ANVILEX KM: Not clear why $project_data[ 'number' ] and $project_data[ 'guid' ] passed together
        if ( $this->model_projects_projects->Is_Edit_Project_Exists( $project_data[ 'guid' ], $project_data[ 'designator' ] ) )
        {

          //--------------------------------------------------------------------
          // ERROR: Item referenced by name GUID exists
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'project_exists' ] = $this->data[ 'workplace_project_edit_project_exists_error' ];

          // Set error code
          $json[ 'return_code' ] = false;

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Project referenced by name GUID not exists
          //--------------------------------------------------------------------

          // Try to add new item
          $return_data = $this->model_projects_projects->Edit( $project_data, $this->language->Get_Language_Code() );

          // Test for item not created
          if ( $return_data === false )
          {

            //--------------------------------------------------------------------
            // ERROR: Project not created
            //--------------------------------------------------------------------

            //! @todo ANVILEX KM: Set error message

            // Set error code
            $json[ 'return_code' ] = false;

          }
          else
          {

            //--------------------------------------------------------------------
            // Project created
            //--------------------------------------------------------------------

            // Set redirect URL
            $json[ 'redirect_url' ] = $this->url->link( 'workplace/projects/info', 'guid=' . $project_data[ 'guid' ], 'SSL' );

            // Set success code
            $json[ 'return_code' ] = true;

          }

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