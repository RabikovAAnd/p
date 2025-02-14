<?php
class ModelProcesses extends Model 
{

  private const processes_name_field_size = 254;
  private const processes_description_field_size = 268435455;
  private const processes_groups_name_field_size = 254;
  private const processes_groups_description_field_size = 254;

  //----------------------------------------------------------------------------
  // Return maximum string size of processes name database field
  //----------------------------------------------------------------------------

  public function Get_Processes_Name_Maximum_String_Size()
  {

    // Return maximum string size of processes name database field
    return ( self::processes_name_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of processes description database field
  //----------------------------------------------------------------------------

  public function Get_Processes_Description_Maximum_String_Size()
  {

    // Return maximum string size of processes description database field
    return ( self::processes_description_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of processes description database field
  //----------------------------------------------------------------------------

  public function Get_Processes_Groups_Description_Maximum_String_Size()
  {

    // Return maximum string size of processes groups description database field
    return ( self::processes_description_field_size );

  }
  //----------------------------------------------------------------------------
  // Return maximum string size of processes groups name database field
  //----------------------------------------------------------------------------

  public function Get_Processes_Groups_Name_Maximum_String_Size()
  {

    // Return maximum string size of processes groups name database field
    return ( self::processes_name_field_size );

  }

  //----------------------------------------------------------------------------
  // Get processes groups
  //----------------------------------------------------------------------------

  public function Get_Processes_Groups( $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`processes_groups`.`guid` AS guid, " .
        "`processes_groups`.`status` AS status, " .
        "`processes_groups`.`creation_date` AS creation_date, " .
        "`processes_groups`.`modification_date` AS modification_date, " .
        "`processes_group_description`.`name` AS name, " .
        "`processes_group_description`.`description` AS description " .
      "FROM " .
        "`processes_groups` " .
      "LEFT JOIN " .
        "`processes_group_description` " .
      "ON " .
        "`processes_groups`.`guid`=`processes_group_description`.`group_guid` " .
      "WHERE " .
        "( `processes_group_description`.`language_code`='" . $this->db->escape( $language_code ) . "' ) OR " .
        "( `processes_group_description`.`language_code` IS NULL )";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return ( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Create new group of processes
  //----------------------------------------------------------------------------

  public function Create_Group( $guid = '', $data = [] )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`processes_groups` " .
      "SET " .
        "`processes_groups`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`processes_groups`.`status`= '" . $this->db->escape( $data[ 'status' ] ) . "', ".
        "`processes_groups`.`creation_date`= NOW(), " .
        "`processes_groups`.`modification_date`= NOW() ";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of active languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      // Test for name setted
      if( isset( $data[ 'name_' . $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`processes_group_description` " .
        "SET " .
          "`processes_group_description`.`group_guid`='" . $this->db->escape( $guid ) . "', " .
          "`processes_group_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`processes_group_description`.`name`='" . $this->db->escape( $data[ 'name_' . $language[ 'code' ] ] ) . "'";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success/error code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Get process group information
  //----------------------------------------------------------------------------

  public function Get_Process_Group_Info( $guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`processes_groups`.`guid` AS guid, " .
        "`processes_groups`.`status` AS status, " .
        "`processes_groups`.`creation_date` AS creation_date, " .
        "`processes_groups`.`modification_date` AS modification_date, " .
        "`processes_group_description`.`name` AS name, " .
        "`processes_group_description`.`description` AS description " .
      "FROM " .
        "`processes_groups` " .
      "LEFT JOIN " .
        "`processes_group_description` " .
      "ON " .
        "`processes_groups`.`guid`=`processes_group_description`.`group_guid` " .
      "WHERE " .
        "( `processes_groups`.`guid`='" . $this->db->escape( $guid ) . "' ) AND " .
        "( ( `processes_group_description`.`language_code`='" . $this->db->escape( $language_code ) . "') OR " .
        "( `processes_group_description`.`language_code` IS NULL ) )";

    // Query database
    $query = $this->db->query( $sql );

    // Test for process group exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // ERROR: process group not found
      //------------------------------------------------------------------------

      // Set default data
      $data[ 'return_code' ] = false;
      $data[ 'data' ] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // process group found
      //------------------------------------------------------------------------

      // Set process group data
      $data[ 'return_code' ] = true;
      $data[ 'data' ][ 'guid' ] = $query->row[ 'guid' ];
      $data[ 'data' ][ 'status' ] = $query->row[ 'status' ];
      $data[ 'data' ][ 'name' ] = $query->row[ 'name' ];
      $data[ 'data' ][ 'description' ] = $query->row[ 'description' ];
      $data[ 'data' ][ 'creation_date' ] = $query->row[ 'creation_date' ];
      $data[ 'data' ][ 'modification_date' ] = $query->row[ 'modification_date' ];

    }

    // Return process group information
    return( $data );

  }
 
  //----------------------------------------------------------------------------
  // Update process group
  //----------------------------------------------------------------------------

  public function Update_Process_Group( $data = array() )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`processes_groups` " .
      "SET " .
        "`processes_groups`.`status`='" . $this->db->escape( $data[ 'status' ] ) . "' " .
      "WHERE " .
        "`processes_groups`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      // Test for language exists
      if( isset( $data[ 'name' ][ $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`processes_group_description` " .
        "SET " .
          "`processes_group_description`.`group_guid`='" . $this->db->escape( $data[ 'guid' ] ) . "', " .
          "`processes_group_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`processes_group_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "' " .
        "ON DUPLICATE KEY UPDATE " .
          "`processes_group_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "'";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success code
    return( true );

  }
  
  //----------------------------------------------------------------------------
  // Get groups process
  //----------------------------------------------------------------------------

  public function Get_Group_Processes( $guid='' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`processes`.`guid` AS guid, " .
        "`processes`.`status` AS status " .
      "FROM " .
        "processes ".
      "WHERE " .
        "processes.group_guid='" . $this->db->escape( $guid ) . "'";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return processeses description
    return ($query->rows);

  }
  
  //----------------------------------------------------------------------------
  // Get process information
  //----------------------------------------------------------------------------

  public function Get_Process_Info( $process_guid, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      "`processes`.`guid` AS guid, " .
      "`processes`.`group_guid` AS group_guid, " .
      "`processes`.`status` AS status, " .
      "`processes`.`creation_date` AS creation_date, " .
      "`processes`.`modification_date` AS modification_date, " .
      "`processes_description`.`name` AS name, " .
      "`processes_description`.`language_code` AS language_code, " .
      "`processes_description`.`description` AS description " .
      "FROM " .
        "processes " .
      "LEFT JOIN " .
        "processes_description " .
      "ON " .
        "processes.guid=processes_description.guid " .
      "WHERE " .
        "processes.guid='" . $this->db->escape($process_guid) . "' AND " .
        "processes_description.language_code='" . $this->db->escape($language_code) . "'";

      // Query database
      $query = $this->db->query( $sql );

      // Test for process exists
      if ( $query->num_rows != 1 )
      {

        //------------------------------------------------------------------------
        // ERROR: process not found
        //------------------------------------------------------------------------

        // Set default data
        $data[ 'return_code' ] = false;
        $data[ 'guid' ] =  '00000000000000000000000000000000';
        $data[ 'group_guid' ] =  '00000000000000000000000000000000';
        $data[ 'status' ] =  'inactive';
        $data[ 'creation_date' ] = '0000-00-00 00:00:00';
        $data[ 'modification_date' ] =  '0000-00-00 00:00:00';
        $data[ 'language_code' ] = 'XX';
        $data[ 'name' ] = '';
        $data[ 'description' ] = '';

      }
      else
      {

        //------------------------------------------------------------------------
        // process found
        //------------------------------------------------------------------------

        // Set product data
        $data[ 'return_code' ] = true;
        $data[ 'guid' ] =  $query->row[ 'guid' ];
        $data[ 'group_guid' ] =  $query->row[ 'group_guid' ];
        $data[ 'status' ] =  $query->row[ 'status' ];
        $data[ 'creation_date' ] =  $query->row[ 'creation_date' ];
        $data[ 'modification_date' ] =  $query->row[ 'modification_date' ];
        $data[ 'language_code' ] =  $query->row[ 'language_code' ];
        $data[ 'name' ] =  $query->row[ 'name' ];
        $data[ 'description' ] = $query->row[ 'description' ];

      }

      // Return process information
      return( $data );

  }
  //----------------------------------------------------------------------------
  // Create new unit
  //----------------------------------------------------------------------------

  public function Create_Process( $guid = '', $data = [] )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`processes` " .
      "SET " .
        "`processes`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`processes`.`group_guid`='" . $this->db->escape( $data[ 'group_guid' ] ) . "', " .
        "`processes`.`creation_date`=NOW(), " .
        "`processes`.`status`= '" . $this->db->escape( $data[ 'status' ] ) . "' ";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of active languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      if( isset( $data[ 'name_' . $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`processes_description` " .
        "SET " .
          "`processes_description`.`guid`='" . $this->db->escape( $guid ) . "', " .
          "`processes_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`processes_description`.`name`='" . $this->db->escape( $data[ 'name_' . $language[ 'code' ] ] ) . "'";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success/error code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Update process
  //----------------------------------------------------------------------------

  public function Update_Process( $data = array() )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`processes` " .
      "SET " .
        "`processes`.`status`='" . $this->db->escape( $data[ 'status' ] ) . "', " .
        "`processes`.`modification_date`=NOW() " .
      "WHERE " .
        "`processes`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      // Test for language exists
      if( isset( $data[ 'name' ][ $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`processes_description` " .
        "SET " .
          "`processes_description`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "', " .
          "`processes_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`processes_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "' " .
        "ON DUPLICATE KEY UPDATE " .
          "`processes_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "'" ;

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success code
    return( true );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
