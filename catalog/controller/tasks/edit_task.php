<?php
class ControllerTasksEditTask extends Controller
{
  
  private $error = array();
  
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
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      //! @todo ANVILEX KM: Check parameters

      // Load messages
      $this->messages->Load( $this->data, 'tasks', 'edit_task', 'index', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'tasks/tasks' );

      // Get task ID
      $task_id = $this->request->Get_GET_Parameter_As_String( 'id' );

      // Get task information
      $this->data[ 'task' ] = $this->model_tasks_tasks->Get( $task_id );

      // Get customers
      $this->data[ 'customers' ] = $this->customer->getCustomers();

      //! @todo ANVILEX KM: ???
      $this->data[ 'task_priority_no_category' ]  = 0;

      // Get task properties list
      $this->data[ 'priorities' ] = $this->model_tasks_tasks->Get_Priority_List( $this->language->Get_Language_Code() );

      // Compose links
      $this->data[ 'tasks_edit_task_save_button_href' ] = $this->url->link('tasks/edit_task/Edit_Task', '', 'SSL');
      $this->data[ 'tasks_edit_task_cancel_button_href' ] =  $this->url->link( substr( $this->session->Get( 'request_referer' ), strpos( $this->session->Get( 'request_prereferer' ), '=' ) + 1 ) , '', 'SSL');

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------
      
      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/tasks/edit_task.css' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'workplace/menu',
        'common/header'
      );

    }

  }
  
  //----------------------------------------------------------------------------

  public function Edit_Task()
  {
    
    // Load messages
    $this->messages->Load( $this->data, 'tasks', 'edit_task', 'Edit_Task', $this->language->Get_Language_Code() );
     
    // Init json data
    $json = array();
    $data = array();

     // Test for customer logged in
     if ($this->customer->Is_Logged() === false) {
 
       //------------------------------------------------------------------------
       // Customer not logged in
       //------------------------------------------------------------------------
 
       // Set redirect link
       $json['redirect_url'] = $this->url->link('account/login', '', 'SSL');
 
       // Set error code
       $json['return_code'] = false;
 
     } else {
 
       //------------------------------------------------------------------------
       // Customer logged in
       //------------------------------------------------------------------------
 
 
       $json['return_code'] = false;
         // Clear request data valid status
      $request_data_valid = true;


      //------------------------------------------------------------------------
      // Header
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'header' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Header parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'header' ] = $this->data[ 'tasks_edit_task_header_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Header parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'header' ] = trim( $this->request->Get_POST_Parameter_As_String( 'header' ) );

        // Test forst name validity
        if (
          ( utf8_strlen( $data[ 'header' ] ) < 1 ) || 
          ( utf8_strlen( $data[ 'header' ] ) > 32 )
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Header invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'header' ] = $this->data[ 'tasks_edit_task_header_error' ];

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
      // Description
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'description' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Description parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'description' ] = $this->data[ 'tasks_edit_task_description_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Description parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'description' ] = trim( $this->request->Get_POST_Parameter_As_String( 'description' ) );

        // Test description validity
        if (
          ( utf8_strlen( $data[ 'description' ] ) < 1 ) || 
          ( utf8_strlen( $data[ 'description' ] ) > 32 )
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Description invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $this->error[ 'description' ] = $this->data[ 'tasks_edit_task_description_error' ];

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
      // Priority
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'priority' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Priority parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'priority' ] = $this->data[ 'tasks_edit_task_priority_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Priority parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'priority' ] = $this->request->Get_POST_Parameter_As_Integer( 'priority' );

        // Test priority validity
        if (
          ( utf8_strlen( $data[ 'priority' ] ) < 1 ) 
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Priority invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $this->error[ 'priority' ] = $this->data[ 'tasks_edit_task_priority_error' ];

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
      if( ! $this->request->Is_POST_Parameter_Exists( 'date_start' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Date start parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'date_start' ] = $this->data[ 'tasks_edit_task_date_start_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Date start parameter found
        //----------------------------------------------------------------------
      if($this->request->Get_POST_Parameter_As_String( 'date_start' )!=''){

              // Store customer data
              $data[ 'date_start' ] = date("Y-m-d h:i:s", strtotime($this->request->Get_POST_Parameter_As_String( 'date_start' )));

      }else{
        $data[ 'date_start' ] =  '0000-00-00 00:00:00';
      }

        //--------------------------------------------------------------------
        // Date start valid
        //--------------------------------------------------------------------
      
        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      
        
      }

      //------------------------------------------------------------------------
      // Deadline
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'deadline' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Deadline parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'deadline' ] = $this->data[ 'tasks_edit_task_deadline_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Deadline parameter found
        //----------------------------------------------------------------------
        if($this->request->Get_POST_Parameter_As_String( 'deadline' )!=''){

          // Store customer data
          $data[ 'deadline' ] = date("Y-m-d h:i:s", strtotime($this->request->Get_POST_Parameter_As_String( 'deadline' )));
        }else{
          $data[ 'deadline' ] = '0000-00-00 00:00:00';
        }


          
        //--------------------------------------------------------------------
        // Deadline valid
        //--------------------------------------------------------------------
      
        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

        
        
      }

      //------------------------------------------------------------------------
      // Lead time
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'lead_time' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Lead time parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'lead_time' ] = $this->data[ 'tasks_edit_task_lead_time_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Lead time parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'lead_time' ] = $this->request->Get_POST_Parameter_As_Integer( 'lead_time' );

        // Test lead time validity
        if (
          (!$this->request->Is_POST_Parameter_Positive_Integer( 'lead_time') && ($this->request->Get_POST_Parameter_As_String('lead_time')!='')) 
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Lead time invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $this->error[ 'lead_time' ] = $this->data[ 'tasks_edit_task_lead_time_error' ];

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
      // Id time
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'task_id' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Lead time parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'task_id' ] = $this->data[ 'tasks_edit_task_task_id_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Lead time parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'task_id' ] = $this->request->Get_POST_Parameter_As_Integer( 'task_id' );

        // Test lead time validity
        if (
          (!$this->request->Is_POST_Parameter_Positive_Integer( 'task_id') ) 
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Lead time invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $this->error[ 'task_id' ] = $this->data[ 'tasks_edit_task_task_id_error' ];

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
      // Customer guid
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'customer_guid' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR:  Customer guid parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'customer_guid' ] = $this->data[ 'tasks_edit_task_customer_guid_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Customer guid parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'customer_guid' ] = trim( $this->request->Get_POST_Parameter_As_String( 'customer_guid' ) );

        // Test customer guid validity
        if ( utf8_strlen( $data[ 'customer_guid' ] ) > 32 )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Customer guid invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'customer_guid' ] = $this->data[ 'tasks_edit_task_customer_guid_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Customer guid valid
          //--------------------------------------------------------------------
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }
      
     // Is request data valid
     if ( $request_data_valid === false )
     {

       //------------------------------------------------------------------------
       // ERROR: Parameters not valid
       //------------------------------------------------------------------------

       $json[ 'error' ] = $this->error;
       
     }
     else
     {
      // Load data model
      $this->load->model('tasks/tasks');

      $json['return_code'] = $this->model_tasks_tasks->Edit_Task( $data );
       // Set redirect link

       if($this->session->Get('request_prereferer') != $this->session->Get('request_referer')){
        $json['redirect_url'] = $this->url->link(substr($this->session->Get('request_prereferer'), strpos($this->session->Get('request_prereferer'), '=')+1) , '', 'SSL');
       }
     }

      // Render page
     $this->response->Set_Json_Output($json);
    } 
  }
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
