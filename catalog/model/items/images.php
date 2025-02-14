<?php
class ModelItemsImages extends Model
{

  //----------------------------------------------------------------------------
  // Add item image
  //----------------------------------------------------------------------------

  public function Add_Item_Image( $data )
  {

    // Generate item GUID
    $guid = UUID_V4_T1();

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`item_pictures` " .
      "SET " .
        "`item_pictures`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`item_pictures`.`item_guid`='" . $this->db->escape( $data[ 'item_guid' ] ) . "', " .
        "`item_pictures`.`type`='" . $this->db->escape( $data[ 'type' ] ) . "' " ;

    // Query database
    $this->db->query( $sql );

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`item_picture_data` " .
      "SET " .
        "`item_picture_data`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`item_picture_data`.`type`='" . $this->db->escape( $data[ 'type' ] ) . "', " .      
        "`item_picture_data`.`data`='" . $this->db->escape( $data[ 'image_data' ] ) . "'";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error code
    return( $return_code );

  }
  //----------------------------------------------------------------------------
  // Get Item images
  //----------------------------------------------------------------------------

  public function Get_Item_Images( $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_pictures`.`guid` AS guid, " .
        "`item_pictures`.`type` AS type, " .
        "`item_picture_data`.`data` AS data " .
      "FROM " .
        "`item_pictures` " .
      "LEFT JOIN " .
        "`item_picture_data` " .
      "ON " .
        "`item_pictures`.`guid`=`item_picture_data`.`guid` " .
      "WHERE " .
        "`item_pictures`.`item_guid`='" . $this->db->escape( $item_guid ) . "'";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>