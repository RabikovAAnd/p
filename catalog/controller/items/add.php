<?php
class ControllerProductsAdd extends Controller
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
      if ( $this->customer->Check_Permission( 'pdm', 'item', 'create' ) == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------
        
        // Redirect
        $this->response->Redirect( $this->url->link( 'error/not_found' ) );

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Access grant, continue processing
        //----------------------------------------------------------------------
        
        // Load model
        $this->load->model( 'items/items' );

        // Add style
        $this->response->addStyle( 'catalog/view/stylesheet/products/info.css' );

        // Set document properties
        $this->response->setTitle( $this->messages->Get_String( 'items', 'add', 'document', 'title_text' ) );
        $this->response->setDescription( $this->messages->Get_String( 'items', 'add', 'document', 'description_text' ) );
        $this->response->setKeywords( '' );

    		// Set page headline
    		$this->data[ 'page_headline' ] = $this->messages->Get_String( 'items', 'add', 'page', 'headline_text' );

				// Try to create new item
				$status_code = $this->model_items_items->Create();
				
				if ( $status_code[ 'return_code' ] == false )
				{
					
					//--------------------------------------------------------------------
					// ERROR: can not create new item
					//--------------------------------------------------------------------
					
				}
				else
				{
					
					//--------------------------------------------------------------------
					// Item successfull created
					//--------------------------------------------------------------------

					// Item ID
//    			$this->data[ 'page_mpn_input_label_text' ] = $this->messages->Get_String( 'items', 'add', 'mpn_input', 'label_text' );
//    			$this->data[ 'page_mpn_input_placeholder_text' ] = $this->messages->Get_String( 'items', 'add', 'mpn_input', 'placeholder_text' );
//    			$this->data[ 'page_mpn_input_placeholder_value' ] = '';

					// Item MPN
    			$this->data[ 'page_mpn_input_label_text' ] = $this->messages->Get_String( 'items', 'add', 'mpn_input', 'label_text' );
    			$this->data[ 'page_mpn_input_placeholder_text' ] = $this->messages->Get_String( 'items', 'add', 'mpn_input', 'placeholder_text' );
    			$this->data[ 'page_mpn_input_placeholder_value' ] = '';
				
					// Item manufacturer
					
				}
				
        // Get next item ID
//        $this->data[ 'project_add_number_placeholder_value' ] = $this->model_items_items->Create();

        $this->data[ 'project_add_number_placeholder_text' ] = $this->language->get( 'pms_project_add_number_input_placeholder_text' );
        $this->data[ 'project_add_name_placeholder_text' ] = $this->language->get( 'pms_project_add_name_input_placeholder_text' );
        $this->data[ 'project_add_description_placeholder_text' ] = $this->language->get( 'pms_project_add_description_input_placeholder_text' );
        
        $this->data[ 'project_add_button_caption' ] = $this->language->get( 'pms_project_add_button_add_caption' );

        // Set page configuration
        $this->children = array(
          'common/footer',
          'common/header'
        );

        // Render page
//        $this->response->Set_HTTP_Output( $this->Render( 'products/add.tpl' ) );

      }
    
    }

  }

  //----------------------------------------------------------------------------
  // Add project to database
  //----------------------------------------------------------------------------
/*
  public function add()
  {

    // Init json data
    $json = array();

    // Test for suctomer logged
    if ( $this->customer->Is_Logged() == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set error code
      $json[ 'number' ] = '-';
      $json[ 'name' ] = '-';
      $json[ 'return_code' ] = 'forbidden';

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test customer permission
      if ( $this->customer->Check_Permission( 'pms', 'projects', 'add' ) == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'number' ] = '-';
        $json[ 'name' ] = '-';
        $json[ 'return_code' ] = 'denied';

      }
      else
      {

        // Load model
        $this->load->model( 'projects/projects' );

        // Test for parameter value setted
		    if ( isset( $this->request->post[ 'number' ] ) == false )
		    {

          //--------------------------------------------------------------------
          // ERROR: Parameter not set
          //--------------------------------------------------------------------

          // Set error code
          $json[ 'number' ] = '-';
          $json[ 'name' ] = '-';
          $json[ 'return_code' ] = 'error';

        }
        else
        {

          // Get parameters
          $number = strtoupper( trim( $this->request->post[ 'number' ] ) );
          $name = ( isset( $this->request->post[ 'name' ] ) == false ) ? '' : trim( $this->request->post[ 'name' ] );
          $description = ( isset( $this->request->post[ 'description' ] ) == false ) ? '' : trim( $this->request->post[ 'description' ] );
          
          // Test project number validity
          if ( $this->model_projects_projects->Is_Project_Number_Valid( $number ) == false )
          {

            //------------------------------------------------------------------
            // ERROR: Invalid project format
            //------------------------------------------------------------------

            // Set error code
            $json[ 'number' ] = $number;
            $json[ 'name' ] = $name;
            $json[ 'return_code' ] = 'error';

          }
          else
          {

            //------------------------------------------------------------------
            // Project format valid, continue processing
            //------------------------------------------------------------------
          
            // Test for project number already exists in database
            if ( $this->model_projects_projects->Is_Exists( $number ) == true )
            {
            
              //----------------------------------------------------------------
              // ERROR: URL already exists
              //----------------------------------------------------------------

              // Set error code
              $json[ 'number' ] = $number;
              $json[ 'name' ] = $name;
              $json[ 'return_code' ] = 'exists';

            }
            else
            {

              //----------------------------------------------------------------
              // Project added successfull
              //----------------------------------------------------------------

              $number_exploded = explode( '.', $number );

              // Compose data
              $data[ 'year' ] = substr( $number_exploded[ 0 ], 1 );
              $data[ 'number' ] = $number_exploded[ 1 ];
              $data[ 'name' ] = $name;
              $data[ 'description' ] = $description;
              $data[ 'type' ] = '0';
              $data[ 'status' ] = '0';
              
              // Add email address to database
              if ( $this->model_projects_projects->Add( $data ) == false )
              {

                //--------------------------------------------------------------
                // ERROR: Adding failed
                //--------------------------------------------------------------

                // Set error code
                $json[ 'number' ] = $number;
                $json[ 'name' ] = $name;
                $json[ 'return_code' ] = 'error';

              }
              else
              {

                //----------------------------------------------------------------
                // Email address added successfull
                //----------------------------------------------------------------

                // Set success code
                $json[ 'number' ] = $number;
                $json[ 'name' ] = $name;
                $json[ 'return_code' ] = 'success';

              }

            }

          }

        }

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }
*/
  //----------------------------------------------------------------------------
  // End of file
  //----------------------------------------------------------------------------
  
}
?>