<?php
class ModelItemsSubitemsProperties extends Model
{

  //----------------------------------------------------------------------------
  // Create subitem property
  //----------------------------------------------------------------------------

  public function Create( $data )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`item_subitem_properties` " .
      "SET " .
	      "`item_subitem_properties`.`subitem_guid`='" . $data[ 'subitem_guid' ] . "', " .
	      "`item_subitem_properties`.`property_guid`='" . $data[ 'property_guid' ] . "', " .
	      "`item_subitem_properties`.`property_name`='" . $data[ 'property_name' ] . "', " .
	      "`item_subitem_properties`.`property_value`='" . $data[ 'property_value' ] . "'";

    // Query database
    $this->db->query( $sql );

  }

  
  //----------------------------------------------------------------------------
  // Get item subitems 
  //----------------------------------------------------------------------------

  public function Get_Subitem_Properties( $subitem_index_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_subitem_properties`.`property_name` AS property_name, " .
        "`item_subitem_properties`.`property_value` AS property_value " .
      "FROM " .
        "`item_subitem_properties` " .
      "WHERE " .
        "`item_subitem_properties`.`subitem_guid`='" . $this->db->escape( $subitem_index_guid ) . "'";

    // Query database
    $results = $this->db->query( $sql );

    // Test for Subitems exists
    if ( $results->num_rows < 1 )
    {

      //------------------------------------------------------------------------
      // Subitems  not found
      //------------------------------------------------------------------------

      // Empty array
      $return_data[ 'data' ] = array();

      // Set not found status
      $return_data[ 'return_code' ] = true;

    }
    else
    {

      //------------------------------------------------------------------------
      // Subitems found
      //------------------------------------------------------------------------

      // Assign rows
      $return_data[ 'data' ] = $results->rows;

      // Set found status
      $return_data[ 'return_code' ] = true;

    }

    // Return data
    return( $return_data );

  }


}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>