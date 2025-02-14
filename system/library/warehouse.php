<?php
class Warehouse
{

  private $db;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Get reference to global objects
    $this->db = $registry->get( 'db' );

  }

  //----------------------------------------------------------------------------
  // Get product price
  //----------------------------------------------------------------------------

  public function getProductPrice( $product_id, $quantity=1 )
  {

    // Compose SQL query
    $sql = "SELECT price FROM product WHERE product_id='" . (int)$product_id . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Test record quantity
    if ( $result->num_rows != 1 )
    {

      // Set default value
      $product_price_info[ 'available' ] = false;
      $product_price_info[ 'currency_id' ] = 0;
      $product_price_info[ 'price' ] = 0;

    }
    else
    {

      // Get product price
      $product_price_info[ 'available' ] = true;
      $product_price_info[ 'currency_id' ] = 0;
      $product_price_info[ 'price' ] = $result->row[ 'price' ];

    }

    // Return product price information
    return( $product_price_info );

  }

  //----------------------------------------------------------------------------
  // Get product status
  //----------------------------------------------------------------------------

  public function Get_Item_Stocked_Quantity( $product_id, $warehouse_id = 0 )
  {

    // ANVILEX KM: Test for item id valid, query product table to verify id 

    // Compose SQL query
    $sql = 
      "SELECT " .
        "quantity " . 
      "FROM " .
        "warehouse_summary " .
      "WHERE " .
        "product_id='" . (int)$product_id . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Test record quantity
    if ( $result->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // ERROR: No item record found
      //------------------------------------------------------------------------

      // Set default value
      $product_stock_info[ 'available' ] = false;
      $product_stock_info[ 'valid' ] = false;
      $product_stock_info[ 'quantity' ] = 0;
      $product_stock_info[ 'price' ] = 0;

    }
    else
    {

      //------------------------------------------------------------------------
      // Item record found, contunue processing
      //------------------------------------------------------------------------

      // Get product price
      $product_stock_info[ 'available' ] = true;
      $product_stock_info[ 'valid' ] = true;
      $product_stock_info[ 'quantity' ] = $result->row[ 'quantity' ];
      $product_stock_info[ 'price' ] = 0;

    }

    // Return product quyntity information
    return( $product_stock_info );

  }

  //----------------------------------------------------------------------------
  // Transaction
  //----------------------------------------------------------------------------

  public function Transaction( $item_id, $quantity, $source_warehouse_id, $destination_warehouse_id )
  {

  }
  
  //----------------------------------------------------------------------------
  // Get product status
  //----------------------------------------------------------------------------

  public function getProductStatus( $product_id, $quantity=1 )
  {

    $product_stock_info[ 'status' ] = 0;

    // Return product price information
    return( $product_stock_info );

  }

  //----------------------------------------------------------------------------

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>