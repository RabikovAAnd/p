<?php
class ModelEndpointsEndpoints extends Model
{
  //----------------------------------------------------------------------------
  // Get list of endpoints
  //----------------------------------------------------------------------------

  public function Get_Endpoints( )
  {

    // Compose SQL query
    $sql =
      "SELECT * " .
      "FROM " .
        "`endpoints` ";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }
  
  //----------------------------------------------------------------------------
  // Check for Endpoint in customers Endpoints list
  //----------------------------------------------------------------------------
  public function Is_Exist_Customer_Endpoint( $customer_guid = '', $endpoint_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`endpoints_acl`.`endpoint_guid` " .
      "FROM " .
        "`endpoints_acl` " .
      "WHERE " .
        "`endpoints_acl`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND " .
        "`endpoints_acl`.`endpoint_guid`='" . $this->db->escape( $endpoint_guid ) . "' " .
      "LIMIT 1";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Observed endpoint not found
      //------------------------------------------------------------------------

      // Set endpoint not found status
      $endpoint_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Observed endpoint found
      //------------------------------------------------------------------------

      // Set endpoint found status
      $endpoint_found = true;

    }

    // Return status
    return( $endpoint_found );

  }
  
  //----------------------------------------------------------------------------
  // Add Endpoint to customer Endpoints list
  //----------------------------------------------------------------------------
  public function Allow_Customer_Endpoint( $customer_guid = '00000000000000000000000000000000', $endpoint_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`endpoints_acl` " .
      "SET " .
        "`endpoints_acl`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "', " .
        "`endpoints_acl`.`endpoint_guid`='" . $this->db->escape( $endpoint_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  } 
  //----------------------------------------------------------------------------
  // Delete Endpoint from customer Endpoints list
  //----------------------------------------------------------------------------
  public function Prohibit_Customer_Endpoint( $customer_guid = '00000000000000000000000000000000', $endpoint_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
        "DELETE FROM " .
        "`endpoints_acl` " .
       "WHERE " .
        "`endpoints_acl`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND "  .
        "`endpoints_acl`.`endpoint_guid`='" . $this->db->escape( $endpoint_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>