<?php
class AccessControlList
{

  // Link to registry object
  private $registry;
  private $db;

  // TEMPORARY CODE
  public $endpoint_name = '';
  
  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store link to registery object
    $this->registry = $registry;

    $this->db = $registry->get( 'db' );

  }

  //----------------------------------------------------------------------------
  // Add endpoint
  //----------------------------------------------------------------------------

  public function Add_Endpoint( $endpoint_name = '' )
  {

    // TEMPORARY CODE
    $this->endpoint_name = $endpoint_name;

    // Compose SQL
    $sql =
      "INSERT INTO " .
        "`endpoints` " .
      "SET " .
        "`endpoints`.`guid`='" . $this->db->escape( UUID_V4_T1() ) . "', " .
        "`endpoints`.`name`='" . $this->db->escape( $endpoint_name ) . "' " .
      "ON DUPLICATE KEY UPDATE " .
        "`endpoints`.`name`='" . $this->db->escape( $endpoint_name ) . "'";

    // Query database
    $result = $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Check login requered access endpoint
  //----------------------------------------------------------------------------

  public function Get_Check_Login( $endpoint_name = '' ) : bool
  {

    // Compose SQL
    $sql =
      "SELECT " .
        "`endpoints`.`check_login` " .
      "FROM " .
        "`endpoints` " .
      "WHERE " .
        "`endpoints`.`name`='" . $this->db->escape( $endpoint_name ) . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Test number of rows
    if ( $result->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // ERROR: Endpoint not found
      //------------------------------------------------------------------------

      // Clear permission status
      $check_login = true;

    }
    else
    {

      //------------------------------------------------------------------------
      // Endpoint found
      //------------------------------------------------------------------------

      // Get login requered status
      $check_login = ( $result->row[ 'check_login' ] == '0' ) ? false : true;

    }

    // Return permission status
    return( $check_login );

  }

  //----------------------------------------------------------------------------
  // Check permission to access endpoint
  //----------------------------------------------------------------------------

  public function Get_Check_Permission( $endpoint_name = '' ) : bool
  {

    // Compose SQL
    $sql =
      "SELECT " .
        "`endpoints`.`check_permission` " .
      "FROM " .
        "`endpoints` " .
      "WHERE " .
        "`endpoints`.`name`='" . $this->db->escape( $endpoint_name ) . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Test number of rows
    if ( $result->num_rows != 1 )
    {

      //--------------------------------------------------------------------
      // ERROR: Endpoint not found
      //--------------------------------------------------------------------

      // Clear permission status
      $check_login = true;

    }
    else
    {

      //------------------------------------------------------------------------
      // Endpoint found
      //------------------------------------------------------------------------

      // Get login requered status
      $check_login = ( $result->row[ 'check_permission' ] == '0' ) ? false : true;

    }

    // Return permission status
    return( $check_login );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>