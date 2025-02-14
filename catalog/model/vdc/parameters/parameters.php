<?php
class ModelVdcParametersParameters extends Model
{

  //----------------------------------------------------------------------------
  // Get parameters list
  //----------------------------------------------------------------------------

  public function Get_List()
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`parameters`.`guid` AS guid, " .
        "`parameters`.`parameter_id` AS parameter_id, " .
        "`parameters`.`name` AS name, " .
        "`parameters`.`name` AS description, " .
        "`parameters`.`datatype_id` AS datatype_name, " .
        "`parameters`.`unit_guid` AS units_name, " .
        "`parameters`.`access_mode_guid` AS access_mode_name, " .
        "`parameters`.`storage_type_guid` AS storage_type_name " .
      "FROM " .
        "`parameters` ";
//      "WHERE ".
//        "`parameters`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "'";

    // Query database
//    $result = $this->db->query( $sql );
    $result = $this->database->query( $sql );

    // Return result
    return( $result );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
