<?php
class ControllerWorkplaceTasksList extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    //------------------------------------------------------------------------
    // Set page data
    //------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'tasks', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'tasks/tasks' );
    $this->load->model( 'items/items' );

    //------------------------------------------------------------------------
    //
    //------------------------------------------------------------------------

    $this->data['tasks_groups'][ 'assigned_tasks' ]['name'] = "Tasks assigned to me";
    $this->data['tasks_groups'][ 'assigned_tasks' ]['data'] = $this->model_tasks_tasks->Get_Task_List_Assigned_To_Customer( $this->customer->Get_GUID() );

    $this->data['tasks_groups'][ 'created_tasks' ]['name'] = "Tasks created by me";
    $this->data['tasks_groups'][ 'created_tasks' ]['data'] = $this->model_tasks_tasks->Get_Task_List_Created_By_Customer( $this->customer->Get_GUID() );

    // Compose links
    $this->data[ 'confirm_task_button_href' ] = $this->url->link( 'workplace/tasks/confirm_task', '', 'SSL' );
    $this->data[ 'discard_task_button_href' ] = $this->url->link( 'workplace/tasks/discard_task', '', 'SSL' );


    //------------------------------------------------------------------------
/*
    // Get tasks
    $tasks = $this->model_tasks_tasks->Get_Task_List( $this->customer->Get_GUID() );

    // Process each task
    foreach ( $tasks as $task )
    {

      // Get task creator information
      $creator_data=$this->customer->Get_Contact_Information( $task[ 'creator_guid' ] );

      // Get task worker information
      $customer_data=$this->customer->Get_Contact_Information( $task[ 'customer_guid' ] );

        //--------------------------------------------------------------------
        // Process buttons activity
        //--------------------------------------------------------------------

         // Task status decoder
         switch( $task[ 'status' ] )
         {

           //------------------------------------------------------------------
           // Unconfirmed task
           //------------------------------------------------------------------

           case 'unconfirmed':
             {

               // ANVILEX KM: Implement logic
               $delete_button_enabled = false;
               $edit_button_enabled = false;
               $start_button_enabled = false;
               $done_button_enabled = false;
               $observe_button_enabled = true;
               $delegate_button_enabled = false;
               $move_button_enabled = false;
               $close_button_enabled = false;
               $discard_button_enabled = true;

               $confirm_button_enabled = true;
               $assign_developer_button_enabled = false;
               $assign_verifier_button_enabled = false;
               $verify_button_enabled = false;
               $accept_button_enabled = false;
               $pause_button_enabled = false;
               $resume_button_enabled = false;
               $reopen_button_enabled = false;
               $decline_button_enabled = false;
               $reject_developer_button_enabled = false;
               // Leave status decoder
               break;

             }

           //------------------------------------------------------------------
           // New task
           //------------------------------------------------------------------

           case 'new':
             {

               // ANVILEX KM: Implement logic
               $delete_button_enabled = false;
               $edit_button_enabled = false;
               $start_button_enabled = false;
               $done_button_enabled = false;
               $observe_button_enabled = false;
               $delegate_button_enabled = false;
               $move_button_enabled = false;
               $close_button_enabled = false;
               $discard_button_enabled = false;
               $confirm_button_enabled = false;
               $assign_developer_button_enabled = true;
               $assign_verifier_button_enabled = false;
               $verify_button_enabled = false;
               $accept_button_enabled = false;
               $pause_button_enabled = false;
               $resume_button_enabled = false;
               $reopen_button_enabled = false;
               $decline_button_enabled = false;
               $reject_developer_button_enabled = false;
               // Leave status decoder
               break;

             }

           //------------------------------------------------------------------
           // Wait for processing task
           //------------------------------------------------------------------

           case 'wait_for_processing':
             {

               // ANVILEX KM: Implement logic
               $delete_button_enabled = false;
               $edit_button_enabled = false;
               $start_button_enabled = true;
               $done_button_enabled = false;
               $observe_button_enabled = false;
               $delegate_button_enabled = false;
               $move_button_enabled = false;
               $close_button_enabled = false;
               $discard_button_enabled = false;
               $confirm_button_enabled = false;
               $assign_developer_button_enabled = false;
               $assign_verifier_button_enabled = false;
               $verify_button_enabled = false;
               $accept_button_enabled = false;
               $pause_button_enabled = false;
               $resume_button_enabled = false;
               $reopen_button_enabled = false;
               $decline_button_enabled = false;
               $reject_developer_button_enabled = true;
               // Leave status decoder
               break;

             }

           //------------------------------------------------------------------
           // Processing task
           //------------------------------------------------------------------

           case 'processing':
             {

               // ANVILEX KM: Implement logic
               $delete_button_enabled = false;
               $edit_button_enabled = false;
               $start_button_enabled = false;
               $done_button_enabled = true;
               $observe_button_enabled = false;
               $delegate_button_enabled = false;
               $move_button_enabled = false;
               $close_button_enabled = false;
               $discard_button_enabled = false;
               $confirm_button_enabled = false;
               $assign_developer_button_enabled = false;
               $assign_verifier_button_enabled = false;
               $verify_button_enabled = false;
               $accept_button_enabled = false;
               $pause_button_enabled = true;
               $resume_button_enabled = false;
               $reopen_button_enabled = false;
               $decline_button_enabled = false;
               $reject_developer_button_enabled = false;
               // Leave status decoder
               break;

             }
             //------------------------------------------------------------------
             // Paused task
             //------------------------------------------------------------------

             case 'paused':
               {

                 // ANVILEX KM: Implement logic
                 $delete_button_enabled = false;
                 $edit_button_enabled = false;
                 $start_button_enabled = false;
                 $done_button_enabled = false;
                 $observe_button_enabled = false;
                 $delegate_button_enabled = false;
                 $move_button_enabled = false;
                 $close_button_enabled = false;
                 $discard_button_enabled = false;
                 $confirm_button_enabled = false;
                 $assign_developer_button_enabled = false;
                 $assign_verifier_button_enabled = false;
                 $verify_button_enabled = false;
                 $accept_button_enabled = false;
                 $pause_button_enabled = false;
                 $resume_button_enabled = true;
                 $reopen_button_enabled = false;
                 $decline_button_enabled = false;
                 $reject_developer_button_enabled = false;
                 // Leave status decoder
                 break;

               }

             //------------------------------------------------------------------
             // Complete task
             //------------------------------------------------------------------

             case 'complete':
               {

                 // ANVILEX KM: Implement logic
                 $delete_button_enabled = false;
                 $edit_button_enabled = false;
                 $start_button_enabled = false;
                 $done_button_enabled = false;
                 $observe_button_enabled = false;
                 $delegate_button_enabled = false;
                 $move_button_enabled = false;
                 $close_button_enabled = false;
                 $discard_button_enabled = false;
                 $confirm_button_enabled = false;
                 $assign_developer_button_enabled = false;
                 $assign_verifier_button_enabled = true;
                 $verify_button_enabled = false;
                 $accept_button_enabled = false;
                 $pause_button_enabled = false;
                 $resume_button_enabled = false;
                 $reopen_button_enabled = false;
                 $decline_button_enabled = false;
                 $reject_developer_button_enabled = false;
                 // Leave status decoder
                 break;

               }
               //------------------------------------------------------------------
               // Wait for verification task
               //------------------------------------------------------------------

               case 'wait_for_verification':
                 {

                   // ANVILEX KM: Implement logic
                   $delete_button_enabled = false;
                   $edit_button_enabled = false;
                   $start_button_enabled = false;
                   $done_button_enabled = false;
                   $observe_button_enabled = false;
                   $delegate_button_enabled = false;
                   $move_button_enabled = false;
                   $close_button_enabled = false;
                   $discard_button_enabled = false;
                   $confirm_button_enabled = false;
                   $assign_developer_button_enabled = false;
                   $assign_verifier_button_enabled = false;
                   $verify_button_enabled = true;
                   $accept_button_enabled = false;
                   $pause_button_enabled = false;
                   $resume_button_enabled = false;
                   $reopen_button_enabled = false;
                   $decline_button_enabled = false;
                   $reject_developer_button_enabled = false;
                   // Leave status decoder
                   break;

                 }
                 //------------------------------------------------------------------
                 // Verification task
                 //------------------------------------------------------------------

                 case 'verification':
                   {

                     // ANVILEX KM: Implement logic
                     $delete_button_enabled = false;
                     $edit_button_enabled = false;
                     $start_button_enabled = false;
                     $done_button_enabled = false;
                     $observe_button_enabled = false;
                     $delegate_button_enabled = false;
                     $move_button_enabled = false;
                     $close_button_enabled = false;
                     $discard_button_enabled = true;
                     $confirm_button_enabled = false;
                     $assign_developer_button_enabled = false;
                     $assign_verifier_button_enabled = false;
                     $verify_button_enabled = false;
                     $accept_button_enabled = true;
                     $pause_button_enabled = false;
                     $resume_button_enabled = false;
                     $reopen_button_enabled = true;
                     $decline_button_enabled = true;
                     $reject_developer_button_enabled = false;
                     // Leave status decoder
                     break;

                   }

                 //------------------------------------------------------------------
                 // Wait for fixing task
                 //------------------------------------------------------------------

                 case 'wait_for_fixing':
                   {

                     // ANVILEX KM: Implement logic
                     $delete_button_enabled = false;
                     $edit_button_enabled = false;
                     $start_button_enabled = true;
                     $done_button_enabled = false;
                     $observe_button_enabled = false;
                     $delegate_button_enabled = false;
                     $move_button_enabled = false;
                     $close_button_enabled = false;
                     $discard_button_enabled = false;
                     $confirm_button_enabled = false;
                     $assign_developer_button_enabled = false;
                     $assign_verifier_button_enabled = false;
                     $verify_button_enabled = false;
                     $accept_button_enabled = false;
                     $pause_button_enabled = false;
                     $resume_button_enabled = false;
                     $reopen_button_enabled = false;
                     $decline_button_enabled = false;
                     $reject_developer_button_enabled = false;
                     // Leave status decoder
                     break;

                   }

                 //------------------------------------------------------------------
                 // Closed task
                 //------------------------------------------------------------------

                 case 'closed':
                   {

                     // ANVILEX KM: Implement logic
                     $delete_button_enabled = false;
                     $edit_button_enabled = false;
                     $start_button_enabled = false;
                     $done_button_enabled = false;
                     $observe_button_enabled = false;
                     $delegate_button_enabled = false;
                     $move_button_enabled = false;
                     $close_button_enabled = false;
                     $discard_button_enabled = false;
                     $confirm_button_enabled = false;
                     $assign_developer_button_enabled = false;
                     $assign_verifier_button_enabled = false;
                     $verify_button_enabled = false;
                     $accept_button_enabled = false;
                     $pause_button_enabled = false;
                     $resume_button_enabled = false;
                     $reopen_button_enabled = false;
                     $decline_button_enabled = false;
                     $reject_developer_button_enabled = false;
                     // Leave status decoder
                     break;

                   }

                 //------------------------------------------------------------------
                 // Discarded task
                 //------------------------------------------------------------------

                 case 'discarded':
                   {

                     // ANVILEX KM: Implement logic
                     $delete_button_enabled = false;
                     $edit_button_enabled = false;
                     $start_button_enabled = false;
                     $done_button_enabled = false;
                     $observe_button_enabled = false;
                     $delegate_button_enabled = false;
                     $move_button_enabled = false;
                     $close_button_enabled = false;
                     $discard_button_enabled = false;
                     $confirm_button_enabled = false;
                     $assign_developer_button_enabled = false;
                     $assign_verifier_button_enabled = false;
                     $verify_button_enabled = false;
                     $accept_button_enabled = false;
                     $pause_button_enabled = false;
                     $resume_button_enabled = false;
                     $reopen_button_enabled = false;
                     $decline_button_enabled = false;
                     $reject_developer_button_enabled = false;
                     // Leave status decoder
                     break;

                   }
           //------------------------------------------------------------------
           // Other statuses
           //------------------------------------------------------------------

           default:
           {

             // ANVILEX KM: Implement logic
             $delete_button_enabled = true;
             $confirm_button_enabled = true;
             $edit_button_enabled = true;
             $start_button_enabled = true;
             $done_button_enabled = true;
             $observe_button_enabled = true;
             $delegate_button_enabled = true;
             $move_button_enabled = true;
             $close_button_enabled = true;
             $discard_button_enabled = true;
             $assign_developer_button_enabled = true;
             $assign_verifier_button_enabled = true;
             $verify_button_enabled = true;
             $accept_button_enabled = true;
             $pause_button_enabled = true;
             $resume_button_enabled = true;
             $reopen_button_enabled = true;
             $decline_button_enabled = true;
             $reject_developer_button_enabled = true;

             // Leave status decoder
             break;

           }

         }

      // Compose task information
      $this->data['tasks'][] = array(
        'id' => $task[ 'id' ],
        'header' => $task[ 'header' ],
        'description' => $task[ 'description' ],
        'status' => $task[ 'status' ],
        'priority' => $this->model_tasks_tasks->Get_Priority_Name( $task[ 'priority' ], $this->language->Get_Language_Code() ),
        'lead_time' => $task[ 'lead_time' ],
        'creator' => $creator_data[ 'lastname' ] . " " . $creator_data[ 'firstname' ],
        'customer' =>  $customer_data[ 'lastname' ] . " " . $customer_data[ 'firstname' ],
        'edit_task_href' => $this->url->link( 'tasks/edit_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'confirm_task_href' => $this->url->link( 'tasks/confirm_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'discard_task_href' => $this->url->link( 'tasks/discard_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'start_task_href' => $this->url->link( 'tasks/start_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'assign_developer_task_href' => $this->url->link( 'tasks/assign_developer_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'assign_verifier_task_href' => $this->url->link( 'tasks/assign_verifier_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'verify_task_href' => $this->url->link( 'tasks/verify_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'reject_task_href' => $this->url->link( 'tasks/reject_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'accept_task_href' => $this->url->link( 'tasks/accept_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'done_task_href' => $this->url->link( 'tasks/done_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'pause_task_href' => $this->url->link( 'tasks/pause_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'resume_task_href' => $this->url->link( 'tasks/resume_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'reopen_task_href' => $this->url->link( 'tasks/reopen_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'decline_task_href' => $this->url->link( 'tasks/decline_task', 'id=' . $task[ 'id' ], 'SSL' ),
        'item_guid' =>$task[ 'item_guid' ],
        'item_href' => $this->url->link( 'workplace/items/info', 'guid=' . $task[ 'item_guid' ], 'SSL' ),
        'item_mpn' =>$this->model_items_items->Get_Information($task[ 'item_guid' ])['mpn'],
        'create_date' => $task[ 'create_date' ],
        'date_start' => $task[ 'date_start' ],
        'deadline' => $task[ 'deadline' ],
        'delete_button_enabled' => $delete_button_enabled,
        'reject_button_enabled' => $reject_developer_button_enabled,
        'assign_developer_button_enabled' => $assign_developer_button_enabled,
        'assign_verifier_button_enabled' => $assign_verifier_button_enabled,
        'confirm_button_enabled' => $confirm_button_enabled,
        'edit_button_enabled' => $edit_button_enabled,
        'start_button_enabled' => $start_button_enabled,
        'done_button_enabled' => $done_button_enabled,
        'observe_button_enabled' => $observe_button_enabled,
        'delegate_button_enabled' => $delegate_button_enabled,
        'move_button_enabled' => $move_button_enabled,
        'close_button_enabled' => $close_button_enabled,
        'verify_button_enabled' => $verify_button_enabled,
        'accept_button_enabled' => $accept_button_enabled,
        'pause_button_enabled' => $pause_button_enabled,
        'resume_button_enabled' => $resume_button_enabled,
        'reopen_button_enabled' => $reopen_button_enabled,
        'decline_button_enabled' => $decline_button_enabled,
        'discard_button_enabled' => $discard_button_enabled
      );

    }

    $this->data['delete_task_button_href'] =$this->url->link('workplace/tasks/Delete_Task', '', 'SSL');
*/
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

  public function Delete_Task()
  {

    // Init json data
    $json = array();


    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json['redirect_url'] = $this->url->link('account/login', '', 'SSL');

      // Set error code
      $json['return_code'] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      $json['return_code'] = false;

      if ( $this->request->Is_POST_Parameter_Exists('task_id') === true )
      {

        // Load data model
        $this->load->model( 'tasks/tasks' );

        if ($this->model_tasks_tasks->Is_Exist_Customer_Task($this->request->Get_POST_Parameter_As_String('task_id')))
        {

          $json[ 'return_code' ] = $this->model_tasks_tasks->Delete_Task($this->request->Get_POST_Parameter_As_String('task_id'));
          $json[ 'return_code' ] =true;

          // Set redirect link
          $json[ 'redirect_url' ] = $this->url->link('workplace/front', '', 'SSL');

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