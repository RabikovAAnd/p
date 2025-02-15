<?php
class ControllerProjectsActivityReport extends Controller
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
      if ( $this->customer->Check_Permission( 'pms', 'activity', 'report' ) == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------

        // Redirect
        $this->response->Redirect( $this->url->link( 'error/forbidden', 403 ) );

      }
      else
      {

        //----------------------------------------------------------------------
        // Access grant, continue processing
        //----------------------------------------------------------------------

//      		trigger_error( 'FORM: ' . $this->request->get[ 'project_id' ] );

        // Test for project id setted
		    if ( isset( $this->request->get[ 'project_id' ] ) === true )
		    {

          //--------------------------------------------------------------------
          // Parameter set
          //--------------------------------------------------------------------

					// Test for project id numeric
					if ( is_numeric( $this->request->get[ 'project_id' ] ) === true )
					{

						// Set project id
						$project_id = (int)$this->request->get[ 'project_id' ];
						
					}

        }


				if ( isset( $project_id ) === false )
				{
					
					//--------------------------------------------------------------------
					// ERROR:
					//--------------------------------------------------------------------
					
//      		trigger_error( 'FORM: project_id not setted' );
					
				}
				else
				{
					
        	// Load model
        	$this->load->model( 'projects/projects' );
				
        	// Get project information
        	$project = $this->model_projects_projects->Get_Project_By_ID( $project_id );

          // Test return code for error
          if ( $project[ 'return_code' ] === false )
          {
          	
          	// ERROR: Project not found

      			trigger_error( 'FORM: Can not get project' );

          }
          else
          {

        		//----------------------------------------------------------------------
        		// Set form data
        		//----------------------------------------------------------------------

        		// Add style
        		$this->response->addStyle( 'catalog/view/stylesheet/projects.css' );

        		// Set document properties
        		$this->response->setTitle( $this->language->get( 'pms_project_activity_report_document_title' ) );
        		$this->response->setDescription( '' );
        		$this->response->setKeywords( '' );

        		// Set documet body strings
        		$this->data[ 'heading_title' ] = $this->language->get( 'pms_project_activity_report_page_heading' );

        		$this->data[ 'project_id' ] = $project[ 'data' ][ 'id' ];
        		$this->data[ 'project_number' ] = $project[ 'data' ][ 'full_number' ];
        		$this->data[ 'project_name' ] = $project[ 'data' ][ 'name' ];
        		$this->data[ 'project_description' ] = $project[ 'data' ][ 'description' ];
        
        		$this->data[ 'project_activity_date_0' ] = date( 'd.m.y' );
        		$this->data[ 'project_activity_date_1' ] = date( 'd.m.y', strtotime( "-1 day" ) );
        		$this->data[ 'project_activity_date_2' ] = date( 'd.m.y', strtotime( "-2 day" ) );
        		$this->data[ 'project_activity_date_3' ] = date( 'd.m.y', strtotime( "-3 day" ) );
       	 		$this->data[ 'project_activity_date_4' ] = date( 'd.m.y', strtotime( "-4 day" ) );

        		$this->data[ 'project_activity_report_description_placeholder_text' ] = $this->language->get( 'pms_project_add_description_input_placeholder_text' );

        		$this->data[ 'project_activity_report_add_button_caption' ] = $this->language->get( 'pms_project_report_activity_add_button_caption' );

        		// Set document error messages
        		$this->data[ 'project_add_result_added_text' ] = $this->language->get( 'pms_project_add_result_added_text' );
        		$this->data[ 'project_add_result_error_text' ] = $this->language->get( 'pms_project_add_result_error_text' );
        		$this->data[ 'project_add_result_exists_text' ] = $this->language->get( 'pms_project_add_result_exists_text' );
        		$this->data[ 'project_add_result_unknown_text' ] = $this->language->get( 'pms_project_add_result_unknown_text' );

        		// Set page configuration
        		$this->children = array(
          		'common/footer',
          		'common/header'
        		);

					}

				}
								
      }

    }

  }

	//----------------------------------------------------------------------------
	// JSON: Add activity
	//----------------------------------------------------------------------------
	
  public function add()
  {

    // Init json data
    $json = array();

    // Test for customer logged
    if ( $this->customer->Is_Logged() == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set error code
      $json[ 'error' ] = true;
//      $json[ 'return_code' ] = 'forbidden';

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test customer permission
      if ( $this->customer->Check_Permission( 'pms', 'activity', 'report' ) == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'error' ] = true;
//        $json[ 'return_code' ] = 'denied';

      }
      else
      {

				//----------------------------------------------------------------------
				// Access grant
				//----------------------------------------------------------------------

				//----------------------------------------------------------------------
				// Get request parameters
				//----------------------------------------------------------------------

				$project_id = $this->request->Get_Parameter( 'post', 'integer', 'project_id' );
				$date = $this->request->Get_Parameter( 'post', 'integer', 'date' );
				$hours = $this->request->Get_Parameter( 'post', 'integer', 'hours' );
				$tens = $this->request->Get_Parameter( 'post', 'integer', 'tens' );
				$minutes = $this->request->Get_Parameter( 'post', 'integer', 'minutes' );
				$description = $this->request->Get_Parameter( 'post', 'string', 'description' );
						
				//----------------------------------------------------------------------
				// Verify parameters
				//----------------------------------------------------------------------
				
				if ( ( $project_id[ 'valid' ] === false ) ||
				     ( $date[ 'valid' ] === false ) ||
				     ( $hours[ 'valid' ] === false ) ||
				     ( $tens[ 'valid' ] === false ) ||
				     ( $minutes[ 'valid' ] === false ) ||
				     ( $description[ 'valid' ] === false ) )
				{
					
					//--------------------------------------------------------------------
					// ERROR
					//--------------------------------------------------------------------
					
        	// Set error code
        	$json[ 'error' ] = true;

				}
				else
				{
					
					// Veryfy range of teh values
					if ( ! ( ( $date[ 'value' ] >= 0 ) && ( $date[ 'value' ] <= 4 ) &&
					     ( $hours[ 'value' ] >= 0 ) && ( $hours[ 'value' ] <= 12 ) &&
					     ( $tens[ 'value' ] >= 0 ) && ( $tens[ 'value' ] <= 5 ) &&
					     ( $minutes[ 'value' ] >= 0 ) && ( $minutes[ 'value' ] <= 9 ) && 
					     ( ! ( ( $hours[ 'value' ] == 0 ) && ( $tens[ 'value' ] == 0 ) && ( $minutes[ 'value' ] == 0 ) ) ) ) )
					{
					
						//------------------------------------------------------------------
						// Invalid parameter range
						//------------------------------------------------------------------
						
        		// Set error code
        		$json[ 'error' ] = true;

					}
					else
					{

						//------------------------------------------------------------------
						// Parameters valid
						//------------------------------------------------------------------
					
        		// Load model
        		$this->load->model( 'projects/projects' );

						// Set data
						$data = array(
							'customer_id' => $this->customer->Get_ID(),
							'project_id' => $project_id[ 'value' ],
							'activity_id' => 1, //0,
							'date' => date( 'd.m.y', strtotime( '-' . (string)$date[ 'value' ] .' day' ) ),
							'duration' => ( $hours[ 'value' ] * 60 ) + ( $tens[ 'value' ] * 10 ) + $minutes[ 'value' ],
							'description' => $description[ 'value' ]
						);
						
						// Add project activity
						if ( $this->model_projects_projects->Add_Time_Tracking( $data ) === false )
						{
							
							//----------------------------------------------------------------
							// ERROR
							//----------------------------------------------------------------

        			// Set error code
        			$json[ 'error' ] = true;

						}
						else
						{
							
							//----------------------------------------------------------------
							// Project activity successful logged
							//----------------------------------------------------------------
							
        			// Set success code
        			$json[ 'error' ] = false;
	
						}
												
					}

				}
								
			}
			
		}
		
    // Render page
    $this->response->Set_JSON_Output( $json );

	}
	
  //----------------------------------------------------------------------------
  // End of file
  //----------------------------------------------------------------------------

}
?>