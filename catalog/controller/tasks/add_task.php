<?php

class ControllerTasksAddTask extends Controller
{
  
//  public $item_guid;
  
  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false ) 
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL') );

    } 
    else 
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      //! @todo ANVILEX KM: Check parameters

      // Load messages
      $this->messages->Load( $this->data, 'tasks', 'add_task', 'index', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'customers/customers' );
      $this->load->model( 'tasks/tasks' );

      // Set item GUID
      $this->data[ 'item_guid' ] = $this->request->Get_GET_Parameter_As_GUID( 'item_guid' );

      // Set customer data
      $this->data[ 'customer_guid' ] = $this->customer->Get_GUID();
      $this->data[ 'customers' ] = $this->model_customers_customers->Get_List_Of_Customers( 130, 1, '', true, true, false );

      //! todo ANVILEX KM: ???
      $this->data[ 'task_priority_no_category' ] = 0;

      // Set task priorities data
      $this->data[ 'priorities' ] = $this->model_tasks_tasks->Get_Priority_List( $this->language->Get_Language_Code() );

      // Compose links
      $this->data[ 'projects_add_task_button_href' ] = $this->url->link( 'tasks/add_task/Add_Task', '', 'SSL' );

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
  // ANVILEX KM: This method is not used
  //----------------------------------------------------------------------------
  
  public function Search()
  {
    if (!$this->customer->Is_Logged())
    {
      $this->response->Redirect($this->url->link('account/login', '', 'SSL'));
    }
    else
    {

      // Initialise json data
      $json = array();
      $json['return_code'] = false;

      if ($this->request->Is_POST_Parameter_Exists('search')){
      
        // Load data models
        $this->load->model( 'customers/customers' );
        $customers =  $this->model_customers_customers->Get_List_Of_Customers( 30, 1,  $this->request->Get_POST_Parameter_As_String('search'), true, true, false);
        
        foreach ($customers as $customer) 
        {
            $json['customers'][] = array(
              'guid' => $customer[ 'guid' ],
              'lastname'    => $customer[ 'lastname' ],
              'name'    => $customer[ 'name' ],

            );
          }
          $json['return_code'] = true;
//        }
      }

    }

    // Render page
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Add task
  //----------------------------------------------------------------------------

  public function Add_Task()
  {
    
    // Init json data
    $json = array();
    $task_data = array();
    
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

      // Load messages
      $this->messages->Load( $this->data, 'tasks', 'add_task', 'Add_Task', $this->language->Get_Language_Code() );

      // Clear request data valid status
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Header
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'header' ) === false )
      {
     
        //----------------------------------------------------------------------
        // ERROR: Header parameter not found
        //----------------------------------------------------------------------
     
        // Set error message text
        $json[ 'error' ][ 'header' ] = $this->data[ 'tasks_add_task_header_error' ];
        
        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Header parameter found
        //----------------------------------------------------------------------

        // Store task headline
        $task_data[ 'header' ] = trim( $this->request->Get_POST_Parameter_As_String( 'header' ) );

        // Test task headline validity
        if (
          ( utf8_strlen( $task_data[ 'header' ] ) < 1 ) || 
          ( utf8_strlen( $task_data[ 'header' ] ) > 64 )
        )
        {
       
          //--------------------------------------------------------------------
          // ERROR: Header invalid
          //--------------------------------------------------------------------
      
          // Set error message text
          $json[ 'error' ][ 'header' ] = $this->data[ 'tasks_add_task_header_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {
       
          //--------------------------------------------------------------------
          // Header valid
          //--------------------------------------------------------------------
     
          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
     
      }

      //------------------------------------------------------------------------
      // Task description
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'description' ) === false )
      {
     
        //----------------------------------------------------------------------
        // ERROR: Description parameter not found
        //----------------------------------------------------------------------
     
        // Set error message text
        $json[ 'error' ][ 'description' ] = $this->data[ 'tasks_add_task_description_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Description parameter found
        //----------------------------------------------------------------------

        // Store task description
        $task_data[ 'description' ] = trim( $this->request->Get_POST_Parameter_As_String( 'description' ) );

        // Test description validity
        if (
          ( utf8_strlen( $task_data[ 'description' ] ) < 1 ) || 
          ( utf8_strlen( $task_data[ 'description' ] ) > 4000 )
        )
        {
       
          //--------------------------------------------------------------------
          // ERROR: Description invalid
          //--------------------------------------------------------------------
      
          // Set error message text
          $json[ 'error' ][ 'description' ] = $this->data[ 'tasks_add_task_description_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {
       
          //--------------------------------------------------------------------
          // Description valid
          //--------------------------------------------------------------------
     
          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
     
      }

      //------------------------------------------------------------------------
      // Task priority
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'priority' ) === false )
      {
     
        //----------------------------------------------------------------------
        // ERROR: Priority parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'priority' ] = $this->data[ 'tasks_add_task_priority_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Priority parameter found
        //----------------------------------------------------------------------

        // Store task priority
        $task_data[ 'priority' ] = $this->request->Get_POST_Parameter_As_Integer( 'priority' );

        // Test priority validity
        //! @bug ANVILEX KM: Upper boundary must be also testet
        if ( utf8_strlen( $task_data[ 'priority' ] ) < 1 ) 
        {
       
          //--------------------------------------------------------------------
          // ERROR: Priority invalid
          //--------------------------------------------------------------------
      
          // Set error message text
          $json[ 'error' ][ 'priority' ] = $this->data[ 'tasks_add_task_priority_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {
       
          //--------------------------------------------------------------------
          // Priority valid
          //--------------------------------------------------------------------
     
          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
     
      }

      //------------------------------------------------------------------------
      // Date start
      //------------------------------------------------------------------------

      // Test for parameter exists
      //! @note ANVILEX KM: Better to use $this->request->Is_POST_Parameter_DateTime() method
      if( $this->request->Is_POST_Parameter_Exists( 'date_start' ) === false )
      {
     
        //----------------------------------------------------------------------
        // ERROR: Date start parameter not found
        //----------------------------------------------------------------------
     
        // Set error message text
        $json[ 'error' ][ 'date_start' ] = $this->data[ 'tasks_add_task_date_start_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Date start parameter found
        //----------------------------------------------------------------------

        // Test for date empty
        if( $this->request->Get_POST_Parameter_As_String( 'date_start' ) !='' )
        {

          // Store start date
          $task_data[ 'date_start' ] = date( "Y-m-d h:i:s", strtotime( $this->request->Get_POST_Parameter_As_String( 'date_start' ) ) );

        }
        else
        {
          
          // Set default start date
          $task_data[ 'date_start' ] =  '0000-00-00 00:00:00';
        
        }

        //----------------------------------------------------------------------
        // Date start valid
        //----------------------------------------------------------------------

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;
  
      }

      //------------------------------------------------------------------------
      // Deadline date
      //------------------------------------------------------------------------

      // Test for parameter exists
      //! @note ANVILEX KM: Better to use $this->request->Is_POST_Parameter_DateTime() method
      if( $this->request->Is_POST_Parameter_Exists( 'deadline' ) === false )
      {
     
        //----------------------------------------------------------------------
        // ERROR: Deadline parameter not found
        //----------------------------------------------------------------------
     
        // Set error message text
        $json[ 'error' ][ 'deadline' ] = $this->data[ 'tasks_add_task_deadline_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Deadline parameter found
        //----------------------------------------------------------------------

        if( $this->request->Get_POST_Parameter_As_String( 'deadline' ) != '' )
        {

          // Store deadline date
          $task_data[ 'deadline' ] = date("Y-m-d h:i:s", strtotime($this->request->Get_POST_Parameter_As_String( 'deadline' )));
        
        }
        else
        {
          
          // Set default deadline date
          $task_data[ 'deadline' ] = '0000-00-00 00:00:00';

        }

        //----------------------------------------------------------------------
        // Deadline valid
        //----------------------------------------------------------------------
   
        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      }
      
      //------------------------------------------------------------------------
      // Lead time
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'lead_time' ) === false )
      {
     
        //----------------------------------------------------------------------
        // ERROR: Lead time parameter not found
        //----------------------------------------------------------------------
     
        // Set error message text
        $json[ 'error' ][ 'lead_time' ] = $this->data[ 'tasks_add_task_lead_time_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Lead time parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $task_data[ 'lead_time' ] = $this->request->Get_POST_Parameter_As_Integer( 'lead_time' );

        // Test lead time validity
        if (
          ( $this->request->Is_POST_Parameter_Positive_Integer( 'lead_time' ) === false ) && 
          ( $this->request->Get_POST_Parameter_As_String( 'lead_time' ) != '' )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: Lead time invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'lead_time' ] = $this->data[ 'tasks_add_task_lead_time_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {
       
          //--------------------------------------------------------------------
          // Lead time valid
          //--------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
     
      }
  

      //------------------------------------------------------------------------
      // Customer GUID
      //------------------------------------------------------------------------
/*
      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'customer_full_name' ) )
      {

        
        //----------------------------------------------------------------------
        // ERROR:  Customer guid parameter not found
        //----------------------------------------------------------------------
     
        // Set error message text
        $this->error[ 'customer_full_name' ] = $this->data[ 'tasks_add_task_customer_full_name_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Customer guid parameter found
        //----------------------------------------------------------------------
   
        // Store customer data
        $task_data[ 'customer_full_name' ] = explode(" ", trim( $this->request->Get_POST_Parameter_As_String( 'customer_full_name' ) ), 2);

        $task_data[ 'customer_guid' ] = $this->customer->Get_Customer_Guid_by_Full_Name($task_data[ 'customer_full_name' ][1], $task_data[ 'customer_full_name' ][0]);
        
        // Test customer guid validity
        if ( utf8_strlen( $task_data[ 'customer_guid' ]  > 32 || $task_data[ 'customer_guid' ] ) < 1 )
        {
       
          //--------------------------------------------------------------------
          // ERROR: Customer guid invalid
          //--------------------------------------------------------------------
      
          // Set error message text
          $this->error[ 'customer_full_name' ] = $this->data[ 'tasks_add_task_customer_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {
       
          //--------------------------------------------------------------------
          // Customer guid valid
          //--------------------------------------------------------------------
     
          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
     
      }
*/
      //------------------------------------------------------------------------
      // Item GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false )
      {
     
        //----------------------------------------------------------------------
        // ERROR:  Item guid parameter not found
        //----------------------------------------------------------------------
     
        // Set error message text
        $json[ 'error' ][ 'item_guid' ] = $this->data[ 'tasks_add_task_item_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item guid parameter found and valid
        //----------------------------------------------------------------------

        // Store item data
        $task_data[ 'item_guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'item_guid' ) );
     
        // Set request data valid status
        $request_data_valid = $request_data_valid && true;
     
      }
   
      //------------------------------------------------------------------------
      // Process request
      //------------------------------------------------------------------------
      
      // Is request data valid
      if ( $request_data_valid === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameters not valid
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // All parameters valid
        //----------------------------------------------------------------------
        
        // Load data model
        $this->load->model( 'tasks/tasks' );
    
        // Set task creator
        $task_data[ 'creator_guid' ] = $this->customer->Get_GUID();

        // Create task
        $this->model_tasks_tasks->Add_Task( $task_data );

        // Set redirect link
        $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info' , 'guid=' . $task_data[ 'item_guid' ], 'SSL');

        // Set success code
        $json[ 'return_code' ] = true;
    
      }

      // Render page
      $this->response->Set_Json_Output( $json );
    
    } 
  
  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>