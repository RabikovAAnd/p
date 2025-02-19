<?php
class ModelWarehouseWarehouse extends Model 
{

  private const warehouse_name_field_size = 254;
  private const warehouse_description_field_size = 254;
  private const warehouse_code_field_size = 254;
  private const bin_code_field_size = 254;

  //----------------------------------------------------------------------------
  // Return maximum string size of warehouse name database field
  //----------------------------------------------------------------------------

  public function Get_Warehouse_Name_Maximum_String_Size()
  {

    // Return maximum string size of warehouse name database field
    return ( self::warehouse_name_field_size );

  }
  //----------------------------------------------------------------------------
  // Return maximum string size of warehouse description database field
  //----------------------------------------------------------------------------

  public function Get_Warehouse_Description_Maximum_String_Size()
  {

    // Return maximum string size of warehouse description database field
    return ( self::warehouse_description_field_size );

  }
  //----------------------------------------------------------------------------
  // Return maximum string size of warehouse code database field
  //----------------------------------------------------------------------------

  public function Get_Warehouse_Code_Maximum_String_Size()
  {

    // Return maximum string size of warehouse code database field
    return ( self::warehouse_code_field_size );

  }
  
  public function Get_Bin_Code_Maximum_String_Size()
  {

    // Return maximum string size of bin code database field
    return ( self::bin_code_field_size );

  }
  

  //----------------------------------------------------------------------------
  // Create warehouse
  //----------------------------------------------------------------------------

  public function Create( $data = array() )
  {

    
    // Generate warehouse GUID
    $guid = UUID_V4_T1();

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "warehouses " .
      "SET " .
        "guid='" . $guid . "', " .
        "address_guid='" . $this->db->escape($data['address_guid']) . "', " .
        "name='" . $this->db->escape($data['name']) . "', " .
        "description='" . $this->db->escape($data['description']) . "', " .
        "code='" . $this->db->escape($data['code']) . "', " .
        "status='" . $this->db->escape($data['status']) . "', " .
        "creation_date=NOW() ";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Get warehouses
  //----------------------------------------------------------------------------

  public function Get_Address_Warehouses( $address_guid = '')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`warehouses` " .
      "WHERE " .
        "`warehouses`.`address_guid`='" . $this->db->escape( $address_guid ). "' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return warehouses
    return( $query->rows );

  }

  
  //----------------------------------------------------------------------------
  // Get warehouse
  //----------------------------------------------------------------------------

  public function Get_Warehouse( $warehouse_guid = '')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`warehouses` " .
      "WHERE " .
        "`warehouses`.`guid`='" . $this->db->escape( $warehouse_guid ). "' ".
        " LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for warehouse exists
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'guid' ] = '00000000000000000000000000000000';
      $return_data[ 'address_guid' ] = '00000000000000000000000000000000';
      $return_data[ 'name' ] = '';
      $return_data[ 'description' ] = '';
      $return_data[ 'code' ] = '';
      $return_data[ 'status' ] = 'inactive';
      $return_data[ 'creation_date' ] = '0000-00-00 00:00:00';
      $return_data[ 'modification_date' ] = '0000-00-00 00:00:00';

    }
    else
    {

      $return_data[ 'valid' ] = true;
      $return_data[ 'guid' ] = $query->row[ 'guid' ];
      $return_data[ 'address_guid' ] = $query->row[ 'address_guid' ];
      $return_data[ 'name' ] = $query->row[ 'name' ];
      $return_data[ 'description' ] = $query->row[ 'description' ];
      $return_data[ 'code' ] = $query->row[ 'code' ];
      $return_data[ 'status' ] = $query->row[ 'status' ];
      $return_data[ 'creation_date' ] = $query->row[ 'creation_date' ];
      $return_data[ 'modification_date' ] = $query->row[ 'modification_date' ];

    }


    // Return warehouses
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Create bin
  //----------------------------------------------------------------------------

  public function Create_Bin( $data = array() )
  {

    
    // Generate warehouse GUID
    $guid = UUID_V4_T1();

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "warehouse_bins " .
      "SET " .
        "guid='" . $guid . "', " .
        "warehouse_guid='" . $this->db->escape($data['warehouse_guid']) . "', " .
        "code='" . $this->db->escape($data['code']) . "', " .
        "status='" . $this->db->escape($data['status']) . "', " .
        "creation_date=NOW() ";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error
    return( $return_code );

  }
  
  //----------------------------------------------------------------------------
  // Get warehouse bins
  //----------------------------------------------------------------------------

  public function Get_Warehouse_Bins( $warehouse_guid = '')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`warehouse_bins` " .
      "WHERE " .
        "`warehouse_bins`.`warehouse_guid`='" . $this->db->escape( $warehouse_guid ). "' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return bins
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get warehouse
  //----------------------------------------------------------------------------

  public function Get_Warehouse_Bin( $bin_guid = '')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`warehouse_bins` " .
      "WHERE " .
        "`warehouse_bins`.`guid`='" . $this->db->escape( $bin_guid ). "' ".
        " LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for warehouse exists
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'guid' ] = '00000000000000000000000000000000';
      $return_data[ 'warehouse_guid' ] = '00000000000000000000000000000000';
      $return_data[ 'code' ] = '';
      $return_data[ 'status' ] = 'inactive';
      $return_data[ 'creation_date' ] = '0000-00-00 00:00:00';
      $return_data[ 'modification_date' ] = '0000-00-00 00:00:00';

    }
    else
    {

      $return_data[ 'valid' ] = true;
      $return_data[ 'guid' ] = $query->row[ 'guid' ];
      $return_data[ 'warehouse_guid' ] = $query->row[ 'warehouse_guid' ];
      $return_data[ 'code' ] = $query->row[ 'code' ];
      $return_data[ 'status' ] = $query->row[ 'status' ];
      $return_data[ 'creation_date' ] = $query->row[ 'creation_date' ];
      $return_data[ 'modification_date' ] = $query->row[ 'modification_date' ];

    }


    // Return warehouses
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Update warehouse
  //----------------------------------------------------------------------------

  public function Update($data)
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "warehouses " .
      "SET " .
      "name='" . $this->db->escape($data['name']) . "', " .
      "description='" . $this->db->escape($data['description']) . "', " .
      "code='" . $this->db->escape($data['code']) . "', " .
      "modification_date=NOW() " . 
      "WHERE " .
        "guid='" . $this->db->escape($data['warehouse_guid']) . "'";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error code
    return ($return_code);

  }


  //----------------------------------------------------------------------------
  // Update warehouse
  //----------------------------------------------------------------------------

  public function Update_Bin($data)
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "warehouse_bins " .
      "SET " .
      "code='" . $this->db->escape($data['code']) . "', " .
      "modification_date=NOW() " . 
      "WHERE " .
        "guid='" . $this->db->escape($data['bin_guid']) . "'";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error code
    return ($return_code);

  }
    
  //----------------------------------------------------------------------------
	// Add item at warehouse
	//----------------------------------------------------------------------------
	
  public function Add( $data )
  {
/*
    // Test URL value
    if ( ( isset ( $data[ 'mpn' ] ) == false ) ||
         ( isset ( $data[ 'manufacturer' ] ) == false ) ||
         ( isset ( $data[ 'quantity' ] ) == false ) ||
         ( isset ( $data[ 'customer_id' ] ) == false ) )
    {

      //----------------------------------------------------------------------
      // ERROR: Bad data
      //----------------------------------------------------------------------

			trigger_error( 'mpn: ' . $data[ 'mpn' ] );
			trigger_error( 'mfg: ' . $data[ 'manufacturer' ] );
			trigger_error( 'qty: ' . $data[ 'quantity' ] );
			trigger_error( 'cid: ' . $data[ 'customer_id' ] );

      // Set error code
      $return_code = false;

    }
    else
    {

      // Compose SQL query
      $sql = "INSERT INTO `warehouse` SET ";
      $sql .= "`mpn`='" . $data[ 'mpn' ] . "', ";
      $sql .= "`manufacturer`='" . $data[ 'manufacturer' ] . "', ";
      $sql .= "`quantity`='" . (int)$data[ 'quantity' ] . "', ";
      $sql .= "`customer_id`='" .(int) $data[ 'customer_id' ] . "', ";
      $sql .= "`transaction_date`=NOW()";

      // Query database
      $this->db->query( $sql );

      // Set success code
      $return_code = true;

    }

    // Return status
    return( $return_code );
*/
	}
	
  //----------------------------------------------------------------------------
  // Add website into database
  //----------------------------------------------------------------------------

  public function Add1( $target_warehouse_id = 0, $item_id = 0, $quantity = 0 )
  {
/*
    // Test URL value
    if ( ( isset ( $data[ 'target_warehouse_id' ] ) == false ) ||
         ( isset ( $data[ 'source_warehouse_id' ] ) == false ) ||
         ( isset ( $data[ 'item_id' ] ) == false ) ||
         ( isset ( $data[ 'quantity' ] ) == false ) )
    {

      //----------------------------------------------------------------------
      // ERROR: Bad data
      //----------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      // Compose SQL query
      $sql = "INSERT INTO warehouse_transactions SET ";
      $sql .= "item_id='" . (int)$data[ 'item_id' ] . "', ";
      $sql .= "target_warehouse_id='" . (int)$data[ 'target_warehouse_id' ] . "', ";
      $sql .= "sourse_warehouse_id='" . (int)$data[ 'source_warehouse_id' ] . "', ";
      $sql .= "quantity='" . $data[ 'quantity' ] . "', ";
      $sql .= "transaction_date=NOW()";

      // Query database
      $this->db->query( $sql );

      // Set success code
      $return_code = true;

    }

    // Return status
    return( $return_code );
*/
  }
	
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
