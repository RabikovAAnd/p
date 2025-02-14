<?php
class ModelCustomersSuppliers extends Model 
{
  private const supplier_article_field_size = 254;

  //----------------------------------------------------------------------------
  // Return maximum string size of supplier article database field
  //----------------------------------------------------------------------------

  public function Get_Supplier_Article_Maximum_String_Size()
  {
  
    // Return maximum string size of supplier article database field
    return( self::supplier_article_field_size );

  }

  //----------------------------------------------------------------------------
  // Get customer information
  //----------------------------------------------------------------------------

	public function Add_Supplier( $data = [] )
	{

		// Compose SQL query
    $sql =
    "INSERT INTO " .
      "item_suppliers " .
    "SET " .
      "item_guid='" . $this->db->escape( $data[ 'item_guid' ] ) . "', " .
      "supplier_guid='" . $this->db->escape( $data[ 'supplier_guid' ] ) . "', " .
      "order_code='" . $this->db->escape( $data[ 'supplier_article' ] ) . "'";

		// Query database
		$this->db->query( $sql );

		// Return data
		return( true );

	}
  
  //----------------------------------------------------------------------------

  public function Get_Item_Suppliers ( $item_guid = '' )
	{

		// Compose SQL query
    $sql =
     "SELECT * " .
     "FROM " .
      "item_suppliers " .
    "WHERE " .
      "item_guid='" . $this->db->escape( $item_guid ) . "'";

		// Query database
		$result=$this->db->query( $sql );

		// Return data
		return($result->rows);
  } 

  //----------------------------------------------------------------------------

  public function Is_Exist_Item_Supplier ($supplier_guid, $item_guid)
	{

		// Compose SQL query
    $sql =
     "SELECT * " .
     "FROM " .
      "item_suppliers " .
    "WHERE " .
      "item_guid='" . $this->db->escape( $item_guid ) . "' AND " .
      "supplier_guid='" . $this->db->escape( $supplier_guid ) . "'";


    $this->log->Log_Debug( 'sql ' . $sql);

    // Query database
    $result = $this->db->query( $sql );

    $this->log->Log_Debug( 'num_rows' . $result->num_rows);

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

  public function Delete_Item_Supplier( $item_guid, $supplier_guid )
  {

    // Compose SQL query
    $sql =
      "DELETE FROM " .
        "`item_suppliers` " .
      "WHERE " .
        "`item_suppliers`.`item_guid`='" . $this->db->escape( $item_guid ) . "' AND " .
        "`item_suppliers`.`supplier_guid`='" . $this->db->escape( $supplier_guid ) . "'";

    $this->log->Log_Debug( 'sql ' . $sql );

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------

  public function Get_List_Of_Suppliers( $page_length = 30, $search = '')
  {
   
    $sql =
      "SELECT " .
        "`customer`.guid AS guid, " .
        "`customer`.lastname AS lastname, " .
        "`customer`.firstname AS name, " .
        "`customer`.company_name AS company_name " .
      "FROM " .
        "`customer` " .
      "WHERE " . 
      "(customer.lastname LIKE '%" . $this->db->escape( $search ) . "%' OR " .
      "customer.company_name LIKE '%" . $this->db->escape( $search ) . "%' OR " .
      "customer.firstname LIKE '%" . $this->db->escape( $search ) . "%') AND " .
      "`customer`.`supplier` = 1 " .
      "LIMIT " . $this->db->escape( $page_length );
    
    $this->log->Log_Debug(   $sql);
    
    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );
  
  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
