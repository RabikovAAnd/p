<?php
class ModelWarehouseWarehouse extends Model 
{

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
