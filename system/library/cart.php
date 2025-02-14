<?php
class Cart
{

  //----------------------------------------------------------------------------
  // Private variables
  //----------------------------------------------------------------------------
  
  private $config;
  private $session;
  private $db;
  private $log;
  private $warehouse;
  private $customer;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------
  
  public function __construct( $registry )
  {

    // Store link to global objects
    $this->config = $registry->get( 'config' );
    $this->customer = $registry->get( 'customer' );
    $this->session = $registry->get( 'session' );
    $this->db = $registry->get( 'db' );
    $this->log = $registry->get( 'log' );
    $this->warehouse = $registry->Get( 'warehouse' );
//    $this->tax = $registry->get('tax');
//    $this->weight = $registry->get('weight');

  }

  //----------------------------------------------------------------------------
  // Cart exists status
  //----------------------------------------------------------------------------
  
  public function Is_Exist() : bool
  {

    // Return code
    $return_code = false;

    // Compose SQL query
    $sql = 
      "SELECT " .
        "COUNT(*) AS count " .
      "FROM " . 
        "`cart` " .
      "WHERE " .
//        "`cart`.`session_id`='" . $this->session->getId() . "' AND " .
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test for cart not exists
    $return_code = ( $result->row[ 'count' ] !== 0 );

    // Return status
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Return cart is empty status
  //----------------------------------------------------------------------------

  public function Is_Empty()
  {

    // Return status
    return( $this->Get_Lines_Count() == 0 );
    
  }

  //----------------------------------------------------------------------------
  // Create cart
  //----------------------------------------------------------------------------

  public function Create()
  {

    // Compose SQL query
    $sql = 
      "INSERT INTO " .
        "`cart` " .
      "SET " .
        "`cart`.`session_id`='" . $this->session->getId() . "', " .
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "', " .
        "`cart`.`date_create`=NOW(), " .
        "`cart`.`currency_code`='EUR'";

    // Execute SQL query
    $this->db->query( $sql );
  
  }
  
  //----------------------------------------------------------------------------
  // Clear cart
  //----------------------------------------------------------------------------

  public function Clear()
  {

    // Compose SQL query
    $sql = 
      "DELETE FROM " .
        "`cart_products` " .
      "WHERE " .
        "`cart_products`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $this->db->query( $sql );

    // Compose SQL query
    $sql = 
      "DELETE FROM " .
        "`cart` " .
      "WHERE ";
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Get cart
  //----------------------------------------------------------------------------

  public function Get_Cart_Information()
  {

    // Compose SQL query
    $sql = 
      "SELECT " . 
        "`cart`.`extern_order_number`, " .
        "`cart`.`comment`, " .
        "`cart`.`payment_address_guid`, " .
        "`cart`.`delivery_address_guid`, " .
        "`cart`.`payment_method_id`, " .
        "`cart`.`delivery_method_id`, " .
        "`cart`.`net`, " .
        "`cart`.`vat`, " .
        "`cart`.`total`, " .
        "`cart`.`currency_code` " .
      "FROM " .
        "`cart` " .
      "WHERE " .
//        "`cart`.`session_id`='" . $this->session->getId() . "' AND " .
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test rows count
    if ( $result->num_rows != 1 )
    {
            
      // Set default values
      $data = array(

        'valid' => false,
        
        'extern_order_number' => '',
        'comment' => '',
        'payment_address_guid' => '00000000000000000000000000000000',
        'delivery_address_guid' => '00000000000000000000000000000000',
        'payment_method_id' => 0,
        'delivery_method_id' => 0,

//        'handling_fee' => 0,
//        'payment_fee' => 0,
//        'packing_fee' => 0,
//        'shipping_fee' => 0,
        
        'net' => 0,
        'vat' => 0,
        'total' => 0,
        'currency_code' => 'XXX'

      );

    }
    else
    {

      //------------------------------------------------------------------------
      // Record found, extract data
      //------------------------------------------------------------------------

      // Set data
      $data = array(

        'valid' => true,

        'extern_order_number' => $result->row[ 'extern_order_number' ],
        'comment' => $result->row[ 'comment' ],
        'payment_address_guid' => $result->row[ 'payment_address_guid' ],
        'delivery_address_guid' => $result->row[ 'delivery_address_guid' ],
        'payment_method_id' => $result->row[ 'payment_method_id' ],
        'delivery_method_id' => $result->row[ 'delivery_method_id' ],

//        'handling_fee' => $result->row[ 'handling_fee' ],
//        'payment_fee' => $result->row[ 'payment_fee' ],
//        'packing_fee' => $result->row[ 'packing_fee' ],
//        'shipping_fee' => $result->row[ 'shipping_fee' ],
        
        'net' => $result->row[ 'net' ],
        'vat' => $result->row[ 'vat' ],
        'total' => $result->row[ 'total' ],
        'currency_code' => $result->row[ 'currency_code' ]

      );

    }

    // Return cart data
    return( $data );

  }

  //----------------------------------------------------------------------------
  // Get cart totals
  //----------------------------------------------------------------------------

  public function Get_Totals()
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "SUM(`cart_products`.`net`) AS net, " .
        "SUM(`cart_products`.`vat`) AS vat, " .
        "SUM(`cart_products`.`total`) AS total " .
      "FROM " . 
        "`cart_products` " . 
      "WHERE " .
//        "`cart_products`.`session_id`='" . $this->session->getId() . "' AND ";
        "`cart_products`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test rows count
    if ( $result->num_rows === 0 )
    {

      //------------------------------------------------------------------------
      // No rows found
      //------------------------------------------------------------------------
      
      // Set default value
      $totals[ 'valid' ] = false;
      $totals[ 'net' ] = 0;
      $totals[ 'vat' ] = 0;
      $totals[ 'total' ] = 0;
      $totals[ 'currency' ] = '';


    }
    else
    {

      //------------------------------------------------------------------------
      // Rows found
      //------------------------------------------------------------------------

      // Set totals
      $totals[ 'valid' ] = true;
      $totals[ 'net' ] = $result->row[ 'net' ];
      $totals[ 'vat' ] = $result->row[ 'vat' ];
      $totals[ 'total' ] = $result->row[ 'total' ];
      $totals[ 'currency' ] = 'EUR'; //$result->row[ 'currency' ];

    }

    // Return totals
    return( $totals );

  }

  //----------------------------------------------------------------------------
  // Return cart lines count
  //----------------------------------------------------------------------------

  public function Get_Lines_Count()
  {

    // Compose SQL query
    $sql = 
      "SELECT " .
        "COUNT(*) AS count " .
      "FROM " .
        "`cart_products` " .
      "WHERE " .
//        "`cart_products`.`session_id`='" . $this->session->getId() . "' AND";
        "`cart_products`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test rows count
    if ( $result->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // No products found, cart is empty
      //------------------------------------------------------------------------

      // Set default value
      $count = 0;

    }
    else
    {

      //------------------------------------------------------------------------
      // Products found
      //------------------------------------------------------------------------

      // Set count value
      $count = $result->row[ 'count' ];

    }

    // Return product count
    return( $count );

  }

  //----------------------------------------------------------------------------
  // Get cart lines
  //----------------------------------------------------------------------------

  public function Get_Lines()
  {

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`cart_products`.`item_guid`, " .
        "`product`.`product_id` AS id, " .
        "`product`.`guid` AS guid, " .
        "`product`.`mpn` AS mpn, " .
        "`product`.`manufacturer_id` AS manufacturer_id, " .
        "`manufacturer`.`name` AS manufacturer_name, " .
        "`manufacturer`.`manufacturer_id` AS manufacturer_id, " .
        "`cart_products`.`quantity` AS quantity, " .
        "`cart_products`.`price` AS price, " .
        "`cart_products`.`net` AS net, " .
        "`cart_products`.`vat_rate` AS vat_rate, " .
        "`cart_products`.`vat` AS vat, " .
        "`cart_products`.`total` AS total " .
      "FROM " .
        "`cart_products` " .
      "LEFT JOIN " .
        "`product` " .
      "ON " .
        "`product`.`guid`=`cart_products`.`item_guid` " .
      "LEFT JOIN " .
        "`manufacturer` " .
      "ON " .
        "`manufacturer`.`manufacturer_id`=`product`.`manufacturer_id` " .
      "WHERE " .
//        "`cart_products`.`session_id`='" . $this->session->getId() . "' AND ";
        "`cart_products`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $products = $this->db->query( $sql );

    // Return
    return( $products->rows );


  }

  //----------------------------------------------------------------------------
  // Get line totals
  //----------------------------------------------------------------------------

  public function Get_Line_Totals( $item_guid )
  {

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`cart_products`.`quantity` AS quantity, " .
        "`cart_products`.`price` AS price, " .
        "`cart_products`.`net` AS net, " .
        "`cart_products`.`vat_rate` AS vat_rate, " .
        "`cart_products`.`vat` AS vat, " .
        "`cart_products`.`total` AS total " .
      "FROM " .
        "`cart_products` " .
      "WHERE " .
        "`cart_products`.`item_guid`='" . $item_guid . "' AND " .
//        "`cart_products`.`session_id`='" . $this->session->getId() . "' AND ";
        "`cart_products`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows !== 1 )
    {
      
      //------------------------------------------------------------------------
      // Not found
      //------------------------------------------------------------------------
      
      // Set default values
      $data[ 'valid' ] = false;
      $data[ 'quantity' ] = 0;
      $data[ 'price' ] = 0;
      $data[ 'net' ] = 0;
      $data[ 'vat_rate' ] = 0;
      $data[ 'vat' ] = 0;
      $data[ 'total' ] = 0;
      $data[ 'currency' ] = '';
      
    }
    else
    {

      //------------------------------------------------------------------------
      // Found
      //------------------------------------------------------------------------
      
      // Extract product data
      $data[ 'valid' ] = true;
      $data[ 'quantity' ] = (int)$result->row[ 'quantity' ];
      $data[ 'price' ] = $result->row[ 'price' ];
      $data[ 'net' ] = $result->row[ 'net' ];
      $data[ 'vat_rate' ] = $result->row[ 'vat_rate' ];
      $data[ 'vat' ] = $result->row[ 'vat' ];
      $data[ 'total' ] = $result->row[ 'total' ];
      $data[ 'currency' ] = 'EUR';

    }

    // Return product data
    return( $data );

  }
  
  //----------------------------------------------------------------------------
  // Update product quantity
  //----------------------------------------------------------------------------

  public function Update_Line( $item_guid = '', $quantity = 0, $unit_price = 0, $vat_rate = 0 )
  {

    //--------------------------------------------------------------------------
    // Update cart line
    //--------------------------------------------------------------------------

    // Compose SQL query
    $sql = 
      "INSERT INTO " .
        "`cart_products` " .
      "SET " .
        "`session_id`='" . $this->session->getId() . "', " .
        "`customer_guid`='" . $this->customer->Get_GUID() . "', " .
        "`item_guid`='" . $item_guid . "', " .
        "`quantity`='" . $quantity . "', " .
        "`price`='" . $unit_price . "', " .
        "`vat_rate`='" . $vat_rate . "', " .
        "`net`=`quantity`*`price`, " .
        "`vat`=`vat_rate`*`net`, " .
        "`total`=`net`+`vat` " .
      "ON DUPLICATE KEY UPDATE " .
        "`quantity`='" . $quantity . "', " .
        "`price`='" . $unit_price . "', " .
        "`vat_rate`='" . $vat_rate . "', " .
        "`net`=`quantity`*`price`, " .
        "`vat`=`vat_rate`*`net`, " .
        "`total`=`net`+`vat`";

    // Execute SQL query
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Remove item from the cart
  //----------------------------------------------------------------------------

  public function Remove_Line( $item_guid )
  {

    // Compose SQL query
    $sql = 
      "DELETE FROM " .
        "`cart_products` " .
      "WHERE " .
        "`cart_products`.`item_guid`='" . $item_guid . "' AND " .
//        "`cart_products`.`session_id`='" . $this->session->getId() . "' AND ";
        "`cart_products`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Set payment address
  //----------------------------------------------------------------------------
  
  public function Set_Payment_Address( $customer_guid = '00000000000000000000000000000000', $payment_address_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql = 
      "UPDATE " .
        "`cart` " .
      "SET " .
        "`cart`.`payment_address_guid`='" . $payment_address_guid . "' " .
      "WHERE " .
//        "`cart`.`session_id`='" . $this->session->getId() . "' AND " .
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Set delivery address
  //----------------------------------------------------------------------------
  
  public function Set_Delivery_Address( $customer_guid = '00000000000000000000000000000000', $delivery_address_guid  = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql = 
      "UPDATE " .
        "`cart` " .
      "SET " .
        "`cart`.`delivery_address_guid`='" . $delivery_address_guid . "' " .
      "WHERE " .
//        "`cart`.`session_id`='" . $this->session->getId() . "' AND " .
        "`cart`.`customer_guid`='" . $customer_guid . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Set payment method
  //----------------------------------------------------------------------------

  public function Set_Payment_Method( $payment_method_id = 0 )
  {

    // Compose SQL query
    $sql = 
      "UPDATE " .
        "`cart` " .
      "SET " .
        "`cart`.`payment_method_id`='" . (int)$payment_method_id . "' " .
      "WHERE " .
//        "`cart`.`session_id`='" . $this->session->getId() . "' AND " .
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Set delivery method
  //----------------------------------------------------------------------------
  
  public function Set_Delivery_Method( $delivery_method_id = 0 )
  {

    // Compose SQL query
    $sql = 
      "UPDATE " .
        "`cart` " .
      "SET " .
        "`cart`.`delivery_method_id`='" . (int)$delivery_method_id . "' " .
      "WHERE " .
//        "`cart`.`session_id`='" . $this->session->getId() . "' AND " .
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Set comment
  //----------------------------------------------------------------------------

  public function Set_Comment( $comment )
  {

    // Compose SQL query
    $sql = 
      "UPDATE " .
        "`cart` " .
      "SET " .
        "`cart`.`comment`='" . $comment . "' " .
      "WHERE " .
//        "`cart`.`session_id`='" . $this->session->getId() . "' AND " .
        "`cart`.`customer_guid`='" . $this->customer->Get_GUID() . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }
  
//******************************************************************************
    
  //----------------------------------------------------------------------------
  // Update cart summary
  //----------------------------------------------------------------------------
/*
  public function UpdateSummary()
  {

    // Compose SQL query
    $sql = "UPDATE cart c SET ";
    $sql .= "c.subtotal=( SELECT SUM( cp.subtotal ) FROM cart_products cp WHERE cp.session_id='". $this->session->getId() . "' ), ";
    $sql .= "c.vat=( SELECT SUM( cp.vat ) FROM cart_products cp WHERE cp.session_id='". $this->session->getId() . "' ) ";
    $sql .= "WHERE ";
    $sql .= "c.session_id='" . $this->session->getId() . "'";

    // Execute SQL query
    $this->db->query( $sql );

    // Update total
//    $this->UpdateTotal();

  }
*/
  //----------------------------------------------------------------------------
  // Update total
  //----------------------------------------------------------------------------
/*
  public function UpdateTotal()
  {

    // Compose SQL query
    $sql = "UPDATE cart c SET ";
    $sql .= "c.total=c.subtotal+c.payment_fee+c.packing_fee+c.shipping_fee+c.vat ";
    $sql .= "WHERE ";
    $sql .= "c.session_id='" . $this->session->getId() . "'";

    // Execute SQL query
    $this->db->query( $sql );

  }
*/
  //----------------------------------------------------------------------------
  // Get total weight of the cart
  //----------------------------------------------------------------------------

  public function getWeight()
  {

    $weight = 0;
/*
    foreach ($this->getProducts() as $product)
    {

      if ($product['shipping'])
      {
            $weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
      }

    }
*/
    return $weight;

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
