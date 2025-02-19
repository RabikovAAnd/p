<?php
class ModelItemsSubitemsSubitems extends Model
{

  //----------------------------------------------------------------------------
  // 
  //----------------------------------------------------------------------------


  public function Get_Subitem_GUID( $subitem_index_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      " subitem_guid " .
      "FROM " .
      "item_subitems " .
    "WHERE " .
      "subitem_index_guid='" . $this->db->escape( $subitem_index_guid ) . "' " ;

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 1 )
    {

      //------------------------------------------------------------------------
      // subitem guid found
      //------------------------------------------------------------------------

      // Set alternative not found status
       $subitem_guid =$result->row[0];

    }
    else
    {

      //------------------------------------------------------------------------
      // subitem_guid not found
      //------------------------------------------------------------------------

      // Set subitem guid status

      $subitem_guid = '00000000000000000000000000000000';
    }

    // Return data
    return( $subitem_guid );

  }

  //----------------------------------------------------------------------------
  // Add Alternative to subitem
  //----------------------------------------------------------------------------

  public function Add_Alternative( $alternative_guid = '', $subitem_index_guid = '' )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "item_subitem_alternatives " .
      "SET " .
        "subitem_index_guid='" . $this->db->escape( $subitem_index_guid ) . "', " .
        "item_guid='" . $this->db->escape( $alternative_guid ) . "'"; 

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Check for subitem exists
  //----------------------------------------------------------------------------

  public function Is_Exist_Item_Subitem( $item_guid = '', $subitem_guid = '', $designator = '' )
  {

    // Compose SQL query
    $sql =
    "SELECT " .
      "* " .
    "FROM " .
      "item_subitems " .
    "WHERE " .
      "item_guid='" . $this->db->escape( $item_guid ) . "' AND " .
      "designator='" . $this->db->escape( $designator ) . "' AND " .
      "subitem_guid='" . $this->db->escape( $subitem_guid ) . "' AND " .
      "deleted=0";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // Project not found
      //------------------------------------------------------------------------

      // Set project not found status
      $item_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Project found
      //------------------------------------------------------------------------

      // Set project found status
      $item_found = true;

    }

    // Return data
    return( $item_found );

  }
  //----------------------------------------------------------------------------
  // Check for subitem exists
  //----------------------------------------------------------------------------

  public function Is_Subitem_Exist_By_Designator( $item_guid = '', $designator = '' )
  {

    // Compose SQL query
    $sql =
    "SELECT " .
      "`item_subitems`.`item_guid` " .
    "FROM " .
      "`item_subitems` " .
    "WHERE " .
      "`item_subitems`.`item_guid`='" . $this->db->escape( $item_guid ) . "' AND " .
      "`item_subitems`.`designator`='" . $this->db->escape( $designator ) . "' AND " .
      "`item_subitems`.`deleted`=0";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // Project not found
      //------------------------------------------------------------------------

      // Set project not found status
      $item_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Project found
      //------------------------------------------------------------------------

      // Set project found status
      $item_found = true;

    }

    // Return data
    return( $item_found );

  }
  //----------------------------------------------------------------------------
  // Get subitem referenced by Index_GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Exists_By_Index_GUID( $subitem_index_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_subitems`.`subitem_guid` AS guid " .
      "FROM " .
        "`item_subitems` " .
      "WHERE " .
        "`item_subitems`.`subitem_index_guid`='" . $subitem_index_guid . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Item not found
      //------------------------------------------------------------------------

      // Set not found status
      $item_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Item found
      //------------------------------------------------------------------------

      // Set item found status
      $item_found = true;

    }

    // Return status
    return( $item_found );

  }

  //----------------------------------------------------------------------------
  // Get subitem referenced by Index_GUID existence status information
  //----------------------------------------------------------------------------

  public function Get_Subitem_By_Index_GUID( $subitem_index_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT * " .
      "FROM " .
        "`item_subitems` " .
      "WHERE " .
        "`item_subitems`.`subitem_index_guid`='" . $subitem_index_guid . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'subitem_index_guid' ] = '00000000000000000000000000000000';
      $return_data[ 'item_guid' ] = '00000000000000000000000000000000';
      $return_data[ 'subitem_guid' ] = '00000000000000000000000000000000';
      $return_data[ 'designator' ] = '';
      $return_data[ 'quantity' ] = '';
      $return_data[ 'deleted' ] = '';

    }
    else
    {

      // Set product data
      $return_data[ 'valid' ] = true;
      $return_data[ 'subitem_index_guid' ] = $query->row[ 'subitem_index_guid' ];
      $return_data[ 'item_guid' ] = $query->row[ 'item_guid' ];
      $return_data[ 'subitem_guid' ] = $query->row[ 'subitem_guid' ];
      $return_data[ 'designator' ] = $query->row[ 'designator' ];
      $return_data[ 'quantity' ] = $query->row[ 'quantity' ];
      $return_data[ 'deleted' ] = $query->row[ 'deleted' ];
    }

    // Return status
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Delete subitem
  //----------------------------------------------------------------------------

  public function Delete_Item_Subitem( $subitem_index_guid = '' )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`item_subitems` " .
      "SET " .
        "`item_subitems`.`deleted`=1 " .
      "WHERE " .
        "`item_subitems`.`subitem_index_guid`='" . $this->db->escape( $subitem_index_guid ) . "' AND " .
        "`item_subitems`.`deleted`=0";

    // Query database
    $this->db->query( $sql );
 
     // Compose SQL query
     $sql =
     "DELETE FROM" .
       "`item_subitem_alternatives` " .
     "WHERE " .
       "`item_subitem_alternatives`.`subitem_index_guid`='" . $this->db->escape( $subitem_index_guid ) . "' ";

   // Query database
   $this->db->query( $sql );

    // Return success code
    return( true );

  }

  
  //----------------------------------------------------------------------------
  // Get item subitems 
  //----------------------------------------------------------------------------

  public function Get_Item_Subitems( $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_subitems`.`subitem_index_guid` AS subitem_index_guid, " .
        "`item_subitems`.`subitem_guid` AS subitem_guid, " .
        "`item_subitems`.`designator` AS designator, " .
        "`item_subitems`.`quantity` AS quantity " .
      "FROM " .
        "`item_subitems` " .
      "WHERE " .
        "`item_subitems`.`item_guid`='" . $this->db->escape( $item_guid ) . "' AND " .
        "`item_subitems`.`deleted`=0";

    // Query database
    $results = $this->db->query( $sql );

    // Test for Subitems exists
    if ( $results->num_rows < 1 )
    {

      //------------------------------------------------------------------------
      // Subitems  not found
      //------------------------------------------------------------------------

      // Set not found status
      $return_data[ 'return_code' ] = false;
      $return_data[ 'data' ]=[];
    }
    else
    {

      //------------------------------------------------------------------------
      // Subitems found
      //------------------------------------------------------------------------

      // Set found status
      $return_data[ 'return_code' ] = true;
      $return_data[ 'data' ] = $results->rows;

    }

    // Return data
    return( $return_data );

  }
  //----------------------------------------------------------------------------
  // Add subitem
  //----------------------------------------------------------------------------

  public function Add_Subitem( $data )
  {

    // Generate subitem index GUID
    $subitem_guid = UUID_V4_T1();

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`item_subitems` " .
      "SET " .
        "`item_subitems`.`subitem_index_guid`='" . $subitem_guid . "', " .
        "`item_subitems`.`item_guid`='" . $this->db->escape( $data[ 'item_guid' ] ) . "', " .
        "`item_subitems`.`subitem_guid`='" . $this->db->escape( $data[ 'subitem_guid' ] ) . "', " .
        "`item_subitems`.`designator`='" . $this->db->escape( $data[ 'designator' ] ) . "', " .
        "`item_subitems`.`quantity`=" . $this->db->escape( $data[ 'quantity' ] );

    // Query database
    $this->db->query( $sql );

    //! @todo ANVILEX KM: Check result
    
    // Set success code
    $return_data[ 'return_code' ] = true;
    $return_data[ 'subitem_guid' ] = $subitem_guid;

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Edit subitem
  //----------------------------------------------------------------------------

  public function Edit_Subitem( $data = [] )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`item_subitems` " .
      "SET " .
        "`item_subitems`.`designator`= '" . $this->db->escape( $data['designator'] ) . "', " .
        "`item_subitems`.`quantity`= '" . $this->db->escape( $data['quantity'] ) . "' " .
      "WHERE " .
        "`item_subitems`.`subitem_index_guid`='" . $this->db->escape( $data[ 'subitem_index_guid' ] ) . "' ";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Replace subitem
  //----------------------------------------------------------------------------

  public function Replace($data = [])
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`item_subitems` " .
      "SET " .
        "`item_subitems`.`subitem_guid`= '" . $this->db->escape($data['subitem_guid']) . "' " .
      "WHERE " .
        "`item_subitems`.`subitem_index_guid`='" . $this->db->escape($data['subitem_index_guid']) . "' ";

    // Query database
    $this->db->query($sql);

    // Return success code
    return (true);

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>