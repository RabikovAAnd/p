<?php
class ControllerTimetrackingList extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for suctomer logged
    if ( $this->customer->Is_Logged() == false )
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

      // Test permission
      if ( $this->customer->Check_Permission( 'uam', 'timetracking', 'list' ) == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------

        // Redirect to error page
        $this->response->Redirect( $this->url->link( 'error/not_found' ) );

      }
      else
      {

        //----------------------------------------------------------------------
        // Access grant, continue processing
        //----------------------------------------------------------------------

        // Load model
        $this->load->model( 'projects/projects' );

        // Init projects array
        $this->data[ 'projects' ] = array();
        
        // Get projects
//        $projects = $this->model_projects_projects->Get_By_Filter( $filter );
        $project_activities = $this->model_projects_projects->Get_Project_Time_Tracking( $this->customer->Get_ID() );

        // Test return code
        if ( $project_activities[ 'return_code' ] == false )
        {

          //--------------------------------------------------------------------
          // ERROR: Request processing failed
          //--------------------------------------------------------------------

          $this->data[ 'error_message' ] = $data[ 'error_code' ];

        }
        else
        {

          //--------------------------------------------------------------------
          // Request processed successfull
          //--------------------------------------------------------------------

          // Iterate over all projects
          foreach ( $project_activities[ 'data' ] as $project_activity_id )
          {

            // Compose filter
            $filter = array();
            $filter[ 'id' ] = $project_activity_id[ 'id' ];
            $filter[ 'language_code' ] = $this->language->Get_Language_Code();

            // Get project activity information
            $project_activity = $this->model_projects_projects->Get_Project_Time_Tracking_Information( $filter );

            // Test return code for error
            if ( $project_activity[ 'return_code' ] == false )
            {

              //----------------------------------------------------------------
              // ERROR: Get project activity failed
              //----------------------------------------------------------------
              
              // Add project activity data
              $this->data[ 'projects' ][] = array(
                'id' => '0',
                'project_id' => '-',
                'project_number' => '-',
                'project_name' => '',
                'activity_name' => '',
                'activity_date' => '--.--.----',
                'activity_duration' => '--:--:--'
              );

            }
            else
            {

              //----------------------------------------------------------------
              // Get project activity successed
              //----------------------------------------------------------------

              // Add project data
              $this->data[ 'projects' ][] = array(
                'id' => $project_activity[ 'data' ][ 'id' ],
                'customer_id' => $project_activity[ 'data' ][ 'customer_id' ],
                'project_number' => $project_activity[ 'data' ][ 'project_number' ],
                'project_name' => $project_activity[ 'data' ][ 'project_name' ],
                'activity_name' => $project_activity[ 'data' ][ 'activity_name' ],
                'activity_date' => $project_activity[ 'data' ][ 'activity_date' ],
                'activity_duration' => $project_activity[ 'data' ][ 'activity_duration' ]
              );

            }

          }

        }

        // Set documet body strings
        $this->data[ 'heading_title' ] = $this->language->get( 'pms_project_activity_list_page_heading' );

        // Set document properties
        $this->response->setTitle( $this->language->get( 'pms_project_activity_list_document_title' ) );
        $this->response->setDescription( '' );
        $this->response->setKeywords( '' );

        // Add style
        $this->response->addStyle( 'catalog/view/stylesheet/projects.css' );

        // Set page configuration
        $this->children = array(
          'common/footer',
          'common/header'
        );

      }

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>