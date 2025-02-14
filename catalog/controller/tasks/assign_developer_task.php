<?php
class ControllerTasksAssignDeveloperTask extends Controller
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
      
      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'tasks', 'assign_developer_task', 'index', $this->language->Get_Language_Code() );

      $this->load->model( 'items/items' );
      $this->load->model( 'tasks/tasks' );

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      $task_id = $this->request->Get_GET_Parameter_As_String( 'id' );
      
      // Get order information
      $this->data['task'] = $this->model_tasks_tasks->Get($task_id);
      $this->data['task_data'] = "task_id=" . $this->data['task']['id'];
      $this->data['tasks_assign_developer_task_button_href'] = $this->url->link('tasks/assign_developer_task/Assign_Task', '', 'SSL');
      $this->data['tasks_assign_developer_task_cancel_button_href'] =  $this->url->link(substr($this->session->Get('request_referer'), strpos($this->session->Get('request_prereferer'), '=')+1) , '', 'SSL');
       
       $this->data['customers'] = $this->customer->getCustomers();
      
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
  // Confirm task
  //----------------------------------------------------------------------------

  public function Assign_Task()
  {
    
    // Load messages
    $this->messages->Load( $this->data, 'tasks', 'assign_developer_task', 'Assign_Task', $this->language->Get_Language_Code() );
    
    // Init json data
    $json = array();
    $data = array();
    $request_data_valid = true;
     // Test for customer logged in
     //------------------------------------------------------------------------
      // Task ID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'task_id' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR:  Task ID parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'task_id' ] = $this->data[ 'tasks_assign_developer_task_task_id_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        //  Task ID parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'task_id' ] = $this->request->Get_POST_Parameter_As_Integer( 'task_id' );

        // Test task id validity
        if (
          ( utf8_strlen( $data[ 'task_id' ] ) < 1 ) 
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR:  Task ID invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $this->error[ 'task_id' ] = $this->data[ 'tasks_assign_developer_task_task_id_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          //  Task ID valid
          //--------------------------------------------------------------------
        
          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
        
      }
      //------------------------------------------------------------------------
      // Message
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'message' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Message parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'message' ] = $this->data[ 'tasks_assign_developer_task_message_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Message parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'message' ] = trim( $this->request->Get_POST_Parameter_As_String( 'message' ) );

        // Test forst name validity
        if (
          ( utf8_strlen( $data[ 'message' ] ) > 32 )
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Message invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'message' ] = $this->data[ 'tasks_assign_developer_task_message_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Message valid
          //--------------------------------------------------------------------
        
          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
        
      }

     if ($request_data_valid === false )
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
        if($this->model_tasks_tasks->Get_Status($data[ 'task_id' ])==='new'){
          $json['return_code'] = $this->model_tasks_tasks->Change_Status( $data[ 'task_id' ] , 'wait_for_processing' );
          if($json['return_code'] && ($data[ 'message' ] != '')){
            $this->model_tasks_tasks->Add_Status_Message( $data[ 'task_id' ],  $data[ 'message' ], 'wait_for_processing' );
          }
          
        }
        else{
          $json['return_code'] = false;
        }

        // Set redirect link
        if($this->session->Get('request_prereferer') != $this->session->Get('request_referer')){
        $json['redirect_url'] = $this->url->link(substr($this->session->Get('request_prereferer'), strpos($this->session->Get('request_prereferer'), '=')+1) , '', 'SSL');
        }
       
     }

    // Render page
    $this->response->Set_Json_Output($json);

  } 
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
