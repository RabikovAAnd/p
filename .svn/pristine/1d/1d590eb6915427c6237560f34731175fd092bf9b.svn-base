<?php

class ModelTasksTasks extends Model
{

  //----------------------------------------------------------------------------
  // Get task priority list
  //----------------------------------------------------------------------------

  public function Get_Priority_List( $language_code = 'XX' )
  {

    // Compose SQL request
    $sql =
      "SELECT " .
        "`tasks_priority`.`index` AS `index`, " .
        "`task_priority_description`.`name` AS `name` " .
      "FROM " .
        "`tasks_priority` " .
      "LEFT JOIN " .
        "`task_priority_description` " .
      "ON " .
        "`task_priority_description`.`priority_id`=`tasks_priority`.`index` " .
      "WHERE " .
          "`task_priority_description`.`language_code`='" . $this->db->escape( $language_code ) . "' " .
      "ORDER BY " .
        "`tasks_priority`.`index` " .
      "ASC";

    // Execute SQL query
    $result = $this->db->query( $sql );

    //! @todo ANVILEX KM: Add data validation

    // Return data
    return( $result->rows );

  }



  //----------------------------------------------------------------------------
  // Get priority name
  //----------------------------------------------------------------------------

  public function Get_Priority_Name( $priority_id = 0, $language_code = "XX" )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`task_priority_description`.`name` " .
      "FROM " .
        "`task_priority_description` " .
      "WHERE " .
        "`task_priority_description`.`priority_id`=" . (int)$priority_id . " AND " .
        "`task_priority_description`.`language_code`='" . $this->db->escape( $language_code ) . "' " .
      "LIMIT 1";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Return data
    return( $result->row[ 0 ] );

  }

  //****************************************************************************
  // Task status methods
  //****************************************************************************

  //****************************************************************************
  // Task related methods
  //****************************************************************************

  //----------------------------------------------------------------------------
  // Get task list created by customer
  //----------------------------------------------------------------------------

  public function Get_Task_List_Created_By_Customer( $creator_guid = '', /*$task_status = '',*/ $limit = 0 )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`tasks`.`id`, " .
        "`tasks`.`item_guid`, " .
        "`tasks`.`create_date`, " .
        "`tasks`.`creator_guid`, " .
        "`tasks`.`customer_guid`, " .
        "`tasks`.`header`, " .
        "`tasks`.`description`, " .
        "`tasks`.`date_start`, " .
        "`tasks`.`deadline`, " .
        "`tasks`.`lead_time`, " .
        "`tasks`.`priority`, " .
        "`tasks`.`status`, " .
        "`tasks_status`.`delete_button_enabled`, " .
        "`tasks_status`.`edit_button_enabled`, " .
        "`tasks_status`.`start_button_enabled`, " .
        "`tasks_status`.`done_button_enabled`, " .
        "`tasks_status`.`observe_button_enabled`, " .
        "`tasks_status`.`delegate_button_enabled`, " .
        "`tasks_status`.`move_button_enabled`, " .
        "`tasks_status`.`close_button_enabled`, " .
        "`tasks_status`.`discard_button_enabled`, " .
        "`tasks_status`.`confirm_button_enabled`, " .
        "`tasks_status`.`assign_developer_button_enabled`, " .
        "`tasks_status`.`assign_verifier_button_enabled`, " .
        "`tasks_status`.`verify_button_enabled`, " .
        "`tasks_status`.`accept_button_enabled`, " .
        "`tasks_status`.`pause_button_enabled`, " .
        "`tasks_status`.`resume_button_enabled`, " .
        "`tasks_status`.`reopen_button_enabled`, " .
        "`tasks_status`.`decline_button_enabled`, " .
        "`tasks_status`.`reject_button_enabled` " .
      "FROM " .
        "`tasks` " .
      "LEFT JOIN " .
        "`tasks_status` " .
      "ON " .
        "`tasks_status`.`name`=`tasks`.`status` " .
      "WHERE " .
        "`tasks`.`creator_guid`='" . $this->db->escape( $creator_guid ) . "' " .
//        "`tasks`.`status`='" . $this->db->escape( $task_status ) . "' " .
      "ORDER BY " .
//        "`tasks`.`priority` " .
        "`tasks`.`create_date` " .      
      "DESC";

    // Test for limit setted
    if( $limit > 0 )
    {
      $sql .= " LIMIT " . $this->db->escape( $limit );
    }

//$this->log->Log_Debug( $sql );
    
    // Execute SQL query
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Get task list assigned to customer
  //----------------------------------------------------------------------------
  // Status:
  //   unconfirmed
  //   new
  //   wait_for_processing
  //   wait_for_fixing
  //   processing
  //   paused
  //   complete
  //   wait_for_verification
  //   verification
  //   closed
  //   discarded

  public function Get_Task_List_Assigned_To_Customer( $customer_guid = '', $task_status = '', $limit = 0 )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`tasks`.`id`, " .
        "`tasks`.`item_guid`, " .
        "`tasks`.`create_date`, " .
        "`tasks`.`creator_guid`, " .
        "`tasks`.`customer_guid`, " .
        "`tasks`.`header`, " .
        "`tasks`.`description`, " .
        "`tasks`.`date_start`, " .
        "`tasks`.`deadline`, " .
        "`tasks`.`lead_time`, " .
        "`tasks`.`priority`, " .
        "`tasks`.`status`, " .
        "`tasks_status`.`delete_button_enabled`, " .
        "`tasks_status`.`edit_button_enabled`, " .
        "`tasks_status`.`start_button_enabled`, " .
        "`tasks_status`.`done_button_enabled`, " .
        "`tasks_status`.`observe_button_enabled`, " .
        "`tasks_status`.`delegate_button_enabled`, " .
        "`tasks_status`.`move_button_enabled`, " .
        "`tasks_status`.`close_button_enabled`, " .
        "`tasks_status`.`discard_button_enabled`, " .
        "`tasks_status`.`confirm_button_enabled`, " .
        "`tasks_status`.`assign_developer_button_enabled`, " .
        "`tasks_status`.`assign_verifier_button_enabled`, " .
        "`tasks_status`.`verify_button_enabled`, " .
        "`tasks_status`.`accept_button_enabled`, " .
        "`tasks_status`.`pause_button_enabled`, " .
        "`tasks_status`.`resume_button_enabled`, " .
        "`tasks_status`.`reopen_button_enabled`, " .
        "`tasks_status`.`decline_button_enabled`, " .
        "`tasks_status`.`reject_button_enabled` " .
      "FROM " .
        "`tasks` " .
      "LEFT JOIN " .
        "`tasks_status` " .
      "ON " .
        "`tasks_status`.`name`=`tasks`.`status` " .
      "WHERE " .
        "`tasks`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' ";
      
    if ( $task_status != '' )
    {
      $sql .= "AND ";
      $sql .= "`tasks`.`status`='" . $this->db->escape( $task_status ) . "' ";
    }
      
    $sql .=   
      "ORDER BY " .
//        "`tasks`.`priority` " .
        "`tasks`.`create_date` " .      
      "DESC";

    // Test for limit setted
    if( $limit > 0 )
    {
      $sql .= " LIMIT " . $this->db->escape( $limit );
    }

//$this->log->Log_Debug( $sql );
    
    // Execute SQL query
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Create new task
  //----------------------------------------------------------------------------

  public function Add_Task( $data )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`tasks` " .
      "SET " .
        "`tasks`.`item_guid`='" . $this->db->escape( $data[ 'item_guid' ] ) . "', " .
        "`tasks`.`create_date`=NOW(), " .
        "`tasks`.`creator_guid`='" . $this->db->escape( $data[ 'creator_guid' ] ) . "', " .
//        "`tasks`.`developer_guid`='00000000000000000000000000000000', " .
        "`tasks`.`customer_guid`='00000000000000000000000000000000', " .
        "`tasks`.`verifier_guid`='00000000000000000000000000000000', " .
        "`tasks`.`header`='" . $this->db->escape( $data[ 'header' ] ) . "', " .
        "`tasks`.`description`='" . $this->db->escape( $data[ 'description' ] ) . "', " .
        "`tasks`.`date_start`='" . $this->db->escape( $data[ 'date_start' ] ) . "', " .
        "`tasks`.`deadline`='" . $this->db->escape( $data[ 'deadline' ] ) . "', " .
        "`tasks`.`lead_time`='" . $this->db->escape( $data[ 'lead_time' ] ) . "', " .
        "`tasks`.`priority`='" . $this->db->escape( $data[ 'priority' ] ) . "', " .
        "`tasks`.`status`='unconfirmed'";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Edit task
  //----------------------------------------------------------------------------

  public function Task_Edit( $data )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`tasks` " .
      "SET " .
        "`tasks`.`customer_guid`='" . $this->db->escape( $data[ 'customer_guid' ] ) . "', " .
        "`tasks`.`header`='" . $this->db->escape( $data[ 'header' ] ) . "', " .
        "`tasks`.`description`='" . $this->db->escape( $data[ 'description' ] ) . "', " .
        "`tasks`.`date_start`='" . $this->db->escape( $data[ 'date_start' ] ) . "', " .
        "`tasks`.`deadline`='" . $this->db->escape( $data[ 'deadline' ] ) . "', " .
        "`tasks`.`lead_time`='" . $this->db->escape( $data[ 'lead_time' ] ) . "', " .
        "`tasks`.`priority`='" . $this->db->escape( $data[ 'priority' ] ) . "' "  .
      "WHERE " .
        "`tasks`.`id`=". $this->db->escape( $data[ 'task_id' ] );

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Delete task
  //----------------------------------------------------------------------------

  public function Delete_Task( $task_id )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`tasks` " .
      "SET " .
        "`tasks`.`status`='discarded' " .
      "WHERE " .
        "`tasks`.`id`=". $this->db->escape( $task_id );

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error
    return( $return_code );

  }

  //XXXXX

  //----------------------------------------------------------------------------
  // Get task information
  //----------------------------------------------------------------------------

  public function Get( $task_id )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "* " .
      "FROM " .
        "tasks " .
      "WHERE " .
        "id=" . $this->db->escape( $task_id );

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->row );

  }
//----------------------------------------------------------------------------
  // Get task status
  //----------------------------------------------------------------------------

  public function Get_Status( $task_id)
  {

    // Compose SQL query
    $sql =
      "SELECT status FROM " .
        "tasks " .
      "WHERE " .
        "id=". $this->db->escape( $task_id );

    // Query database
    $result = $this->db->query( $sql );

    // Return success/error
    return( $result->row[0] );

  }

  //----------------------------------------------------------------------------
  // Is Exists task status
  //----------------------------------------------------------------------------

  public function Is_Exist_Customer_Task($task_id)
  {

    // Compose SQL query
    $sql =
      "SELECT * FROM " .
        "tasks " .
      "WHERE " .
        "id=". $this->db->escape( $task_id );

      // Query database
      $result = $this->db->query( $sql );
    
     // Test record count
     if ( $result->num_rows == 0 )
     {

       //----------------------------------------------------------------------
       // Customer account not found
       //----------------------------------------------------------------------

       // Set error code
       $return_code = false;

     }
     else
     {

       //----------------------------------------------------------------------
       // Customer account found
       //----------------------------------------------------------------------

       // Set success code
       $return_code = true;

     }

    // Return success/error
    return( $return_code);

  }
  //----------------------------------------------------------------------------
  // Change task status
  //----------------------------------------------------------------------------

  public function Change_Status( $task_id, $status )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "tasks " .
      "SET " .
        "status='" . $this->db->escape( $status ) . "' " .
      "WHERE " .
        "id=". $this->db->escape( $task_id );

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Add task message
  //----------------------------------------------------------------------------

  public function Add_Status_Message( $task_id, $message, $status )
  {

     // Compose SQL query
     $sql =
     "INSERT INTO " .
       "tasks_messages " .
     "SET " .
     "task_id=" . $this->db->escape( $task_id ) . ", " .
     "status='" . $this->db->escape( $status ) . "', " .
     "message='" . $this->db->escape( $message ) . "', " .
     "create_date=NOW() ";

   // Query database
   $this->db->query( $sql );

   // Set success code
   $return_code = true;

   // Return success/error
   return( $return_code );
  }

  //----------------------------------------------------------------------------

  public function Get_Task_List_For_Item( $customer_guid, $item_guid )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "* " .
      "FROM " .
        "`tasks` " .
      "WHERE " .
//        "`tasks`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND " .
        "`tasks`.`item_guid`='" . $this->db->escape( $item_guid ) . "' " .
      "ORDER BY `tasks`.`create_date` ASC";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
