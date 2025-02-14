<?php
class ModelOrdersOrders extends Model
{
 
  //----------------------------------------------------------------------------
  // Get order lists by customer GUID
  //----------------------------------------------------------------------------

	public function Get_Orders( $customer_guid = '', $language_code = 'XX' ) 
	{

		// Compose SQL query
		$sql = 
      "SELECT " . 
        "`orders`.`order_id` AS id, " .
        "`orders`.`date`, " .
        "`orders`.`status_id`, " .
        "`orders`.`extern_number`, " .
        "`orders`.`comment`, " .
        "`orders`.`language_code`, " .
        "`orders`.`payment_method_id`, " .
        "`orders`.`delivery_method_id`, " .
        "`orders`.`lines_count`, " .
        "`orders`.`net`, " .
        "`orders`.`vat`, " .
        "`orders`.`total`, " .
        "`orders`.`currency_code`, " .
        "`orders`.`type`, " .

        "`orders`.`payment_address_id`, " .
        "`orders`.`payment_address_country_name`, " .
        "`orders`.`payment_address_country_id`, " .
        "`orders`.`payment_address_zone_id`, " .        
        "`orders`.`payment_address_zone_name`, " .
        "`orders`.`payment_address_postcode`, " .
        "`orders`.`payment_address_city`, " .        
        "`orders`.`payment_address_street`, " .
        "`orders`.`payment_address_house`, " .
        "`orders`.`payment_address_building`, " .        
        "`orders`.`payment_address_room`, " .

//        "`orders`.`payment_contact_id`, " .        
        "`orders`.`payment_company_name`, " .
        "`orders`.`payment_company_vat_number`, " .        
        "`orders`.`payment_contact_firstname`, " .
        "`orders`.`payment_contact_lastname`, " .        
        "`orders`.`payment_contact_middlename`, " .
        "`orders`.`payment_contact_email`, " .        
        "`orders`.`payment_contact_phone`, " .

        "`orders`.`delivery_address_id`, " .
        "`orders`.`delivery_address_country_name`, " .
        "`orders`.`delivery_address_country_id`, " .
        "`orders`.`delivery_address_zone_id`, " .        
        "`orders`.`delivery_address_zone_name`, " .
        "`orders`.`delivery_address_postcode`, " .
        "`orders`.`delivery_address_city`, " .        
        "`orders`.`delivery_address_street`, " .
        "`orders`.`delivery_address_house`, " .
        "`orders`.`delivery_address_building`, " .        
        "`orders`.`delivery_address_room`, " .
        
//        "`orders`.`delivery_contact_id`, " .        
        "`orders`.`delivery_company_name`, " .
        "`orders`.`delivery_company_vat_number`, " .        
        "`orders`.`delivery_contact_firstname`, " .
        "`orders`.`delivery_contact_lastname`, " .        
        "`orders`.`delivery_contact_middlename`, " .
        "`orders`.`delivery_contact_email`, " .        
        "`orders`.`delivery_contact_phone` " .

        // "`order_status`.`name` AS status " .   
      "FROM " .
        "`orders` " .
      // "LEFT JOIN " .
      //   "`order_status` " .
      // "ON " .
      //   "`orders`.`status_id`=`order_status`.`order_status_id` " .
      "WHERE " .
        "`orders`.`customer_guid`='" . $this->db->escape($customer_guid) . "' " .
        // " AND " .
        // "`order_status`.`language_code`='" . $language_code . "' " .
      "ORDER BY " .
        "`orders`.`date` ASC";

    // Query database
    $orders = $this->db->query( $sql );

    // Check record validity
    if ( $orders->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // No orders found
      //------------------------------------------------------------------------

      // Set default data
      $orders_data = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Orders found
      //------------------------------------------------------------------------

      // Assign orders data
      $orders_data = $orders->rows;

    }

    // Return order list
		return( $orders_data );
  }

  //----------------------------------------------------------------------------
  // Get order lists by supplier GUID
  //----------------------------------------------------------------------------

	public function Get_Supplier_Orders( $supplier_guid = '' ) 
	{

		// Compose SQL query
		$sql = 
      "SELECT " . 
        "`orders`.`order_id` AS id, " .
        "`orders`.`date`, " .
        "`orders`.`status_id`, " .
        "`orders`.`extern_number`, " .
        "`orders`.`comment`, " .
        "`orders`.`language_code`, " .
        "`orders`.`payment_method_id`, " .
        "`orders`.`delivery_method_id`, " .
        "`orders`.`lines_count`, " .
        "`orders`.`net`, " .
        "`orders`.`vat`, " .
        "`orders`.`total`, " .
        "`orders`.`currency_code`, " .
        "`orders`.`type`, " .

        "`orders`.`payment_address_id`, " .
        "`orders`.`payment_address_country_name`, " .
        "`orders`.`payment_address_country_id`, " .
        "`orders`.`payment_address_zone_id`, " .        
        "`orders`.`payment_address_zone_name`, " .
        "`orders`.`payment_address_postcode`, " .
        "`orders`.`payment_address_city`, " .        
        "`orders`.`payment_address_street`, " .
        "`orders`.`payment_address_house`, " .
        "`orders`.`payment_address_building`, " .        
        "`orders`.`payment_address_room`, " .

//        "`orders`.`payment_contact_id`, " .        
        "`orders`.`payment_company_name`, " .
        "`orders`.`payment_company_vat_number`, " .        
        "`orders`.`payment_contact_firstname`, " .
        "`orders`.`payment_contact_lastname`, " .        
        "`orders`.`payment_contact_middlename`, " .
        "`orders`.`payment_contact_email`, " .        
        "`orders`.`payment_contact_phone`, " .

        "`orders`.`delivery_address_id`, " .
        "`orders`.`delivery_address_country_name`, " .
        "`orders`.`delivery_address_country_id`, " .
        "`orders`.`delivery_address_zone_id`, " .        
        "`orders`.`delivery_address_zone_name`, " .
        "`orders`.`delivery_address_postcode`, " .
        "`orders`.`delivery_address_city`, " .        
        "`orders`.`delivery_address_street`, " .
        "`orders`.`delivery_address_house`, " .
        "`orders`.`delivery_address_building`, " .        
        "`orders`.`delivery_address_room`, " .
        
//        "`orders`.`delivery_contact_id`, " .        
        "`orders`.`delivery_company_name`, " .
        "`orders`.`delivery_company_vat_number`, " .        
        "`orders`.`delivery_contact_firstname`, " .
        "`orders`.`delivery_contact_lastname`, " .        
        "`orders`.`delivery_contact_middlename`, " .
        "`orders`.`delivery_contact_email`, " .        
        "`orders`.`delivery_contact_phone` " .

        // "`order_status`.`name` AS status " .   
      "FROM " .
        "`orders` " .
      // "LEFT JOIN " .
      //   "`order_status` " .
      // "ON " .
      //   "`orders`.`status_id`=`order_status`.`order_status_id` " .
      "WHERE " .
        "`orders`.`supplier_guid`='" . $this->db->escape($supplier_guid) . "' " .
      "ORDER BY " .
        "`orders`.`date` ASC";

    // Query database
    $orders = $this->db->query( $sql );

    // Check record validity
    if ( $orders->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // No orders found
      //------------------------------------------------------------------------

      // Set default data
      $orders_data = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Orders found
      //------------------------------------------------------------------------

      // Assign orders data
      $orders_data = $orders->rows;

    }

    // Return order list
		return( $orders_data );

	}

  //----------------------------------------------------------------------------
  // Get order by order ID
  //----------------------------------------------------------------------------

	public function Get_Order( $order_id ) 
  {

		// Compose SQL query
		$sql = 
      "SELECT " . 
        "`orders`.`order_id` AS id, " .
        "`orders`.`date`, " .
        "`orders`.`status_id`, " .
        "`orders`.`extern_number`, " .
        "`orders`.`comment`, " .
        "`orders`.`language_code`, " .
        "`orders`.`payment_method_id`, " .
        "`orders`.`delivery_method_id`, " .
        "`orders`.`lines_count`, " .
        "`orders`.`net`, " .
        "`orders`.`vat`, " .
        "`orders`.`total`, " .
        "`orders`.`currency_code`, " .
        "`orders`.`customer_guid`, " .
        "`orders`.`type`, " .
        
        "`orders`.`supplier_guid`, " .
        "`orders`.`supplier_company_name`, " .
        "`orders`.`supplier_company_vat_number`, " .        
        "`orders`.`supplier_address_country_id`, " .
        "`orders`.`supplier_address_country_name`, " .
        "`orders`.`supplier_address_zone_id`, " .        
        "`orders`.`supplier_address_zone_name`, " .
        "`orders`.`supplier_address_postcode`, " .
        "`orders`.`supplier_address_city`, " .        
        "`orders`.`supplier_address_street`, " .
        "`orders`.`supplier_address_house`, " .
        "`orders`.`supplier_address_building`, " .        
        "`orders`.`supplier_address_room`, " .

        "`orders`.`payment_address_id`, " .
        "`orders`.`payment_address_country_id`, " .
        "`orders`.`payment_address_country_name`, " .
        "`orders`.`payment_address_zone_id`, " .        
        "`orders`.`payment_address_zone_name`, " .
        "`orders`.`payment_address_postcode`, " .
        "`orders`.`payment_address_city`, " .        
        "`orders`.`payment_address_street`, " .
        "`orders`.`payment_address_house`, " .
        "`orders`.`payment_address_building`, " .        
        "`orders`.`payment_address_room`, " .

//        "`orders`.`payment_contact_id`, " .        
        "`orders`.`payment_company_name`, " .
        "`orders`.`payment_company_vat_number`, " .        
        "`orders`.`payment_contact_firstname`, " .
        "`orders`.`payment_contact_lastname`, " .        
        "`orders`.`payment_contact_middlename`, " .
        "`orders`.`payment_contact_email`, " .        
        "`orders`.`payment_contact_phone`, " .

        "`orders`.`delivery_address_id`, " .
        "`orders`.`delivery_address_country_id`, " .
        "`orders`.`delivery_address_country_name`, " .
        "`orders`.`delivery_address_zone_id`, " .        
        "`orders`.`delivery_address_zone_name`, " .
        "`orders`.`delivery_address_postcode`, " .
        "`orders`.`delivery_address_city`, " .        
        "`orders`.`delivery_address_street`, " .
        "`orders`.`delivery_address_house`, " .
        "`orders`.`delivery_address_building`, " .        
        "`orders`.`delivery_address_room`, " .
        
//        "`orders`.`delivery_contact_id`, " .        
        "`orders`.`delivery_company_name`, " .
        "`orders`.`delivery_company_vat_number`, " .        
        "`orders`.`delivery_contact_firstname`, " .
        "`orders`.`delivery_contact_lastname`, " .        
        "`orders`.`delivery_contact_middlename`, " .
        "`orders`.`delivery_contact_email`, " .        
        "`orders`.`delivery_contact_phone` " .

      "FROM " .
        "`orders` " .
      "WHERE " .
        "`orders`.`order_id` = " . (int)$order_id;

    // Query database
    $order = $this->db->query( $sql );

    // Check record validity
    if ( $order->num_rows !== 1 )
    {

      //------------------------------------------------------------------------
      // No orders found
      //------------------------------------------------------------------------

      // Set default data
      $order_data = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Orders found
      //------------------------------------------------------------------------

      // Assign orders data
      $order_data = $order->row;

    }

    // Return order data
    return( $order_data );

  }

  //----------------------------------------------------------------------------
  // Get order lines
  //----------------------------------------------------------------------------

	public function Get_Lines( $order_id = 0 ) 
  {

		// Compose SQL query
		$sql = 
      "SELECT " . 
        "`order_lines`.`id`, " .
        "`order_lines`.`order_id`, " .
        "`order_lines`.`item_guid`, " .
        "`order_lines`.`mpn`, " .
        "`order_lines`.`description`, " .
        "`order_lines`.`quantity`, " .
        "`order_lines`.`price`, " .
        "`order_lines`.`net`, " .
        "`order_lines`.`vat_rate`, " .
        "`order_lines`.`vat`, " .
        "`order_lines`.`total` " .
      "FROM " .
        "`order_lines` " .
      "WHERE " .
        "`order_lines`.`order_id`=" . (int)$order_id;

    // Query database
    $lines = $this->db->query( $sql );

    // Check record validity
    if ( $lines->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // No orders found
      //------------------------------------------------------------------------

      // Set default data
      $lines_data = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Orders found
      //------------------------------------------------------------------------

      // Assign order lines data
      $lines_data = $lines->rows;

    }

    // Return order lines list
		return( $lines_data );

  }



  //----------------------------------------------------------------------------
  // Create new order
  //----------------------------------------------------------------------------

  public function Create_Order( $guid='', $data=[], $language_code )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`orders` " .
      "SET " .
        // "`orders`.`order_id`='" . $this->db->escape( $guid ) . "', " .
        "`orders`.`comment`='" . $this->db->escape( $data[ 'comment' ] ) . "', " .
        "`orders`.`language_code`='" . $this->db->escape( $language_code ) . "', " .
        "`orders`.`customer_guid`='" . $this->db->escape($data[ 'customer' ]['guid'] ) . "', " .
        "`orders`.`extern_number`='" . $this->db->escape( $data[ 'extern_number' ] ) . "', " .
        "`orders`.`type`='" . $this->db->escape( $data['type'] ) . "', " .
        "`orders`.`status_id`=0, " .
        "`orders`.`date`=NOW(), " .
        
        
        "`orders`.`supplier_guid`='" . $this->db->escape( $data[ 'supplier' ]['guid'] ) . "', "   .
        "`orders`.`supplier_company_name`='" . $this->db->escape( $data[ 'supplier' ]['company_name'] ) . "', "   .
        // "`orders`.`supplier_company_vat_number`='" . $this->db->escape( $data[ 'supplier' ]['guid'] ) . "', "   .        
        "`orders`.`supplier_address_country_id`=" . $this->db->escape( $data[ 'delivery_address' ]['country_id'] ) . ", "   .
        "`orders`.`supplier_address_country_name`='" . $this->db->escape( $data[ 'delivery_address' ]['country'] ) . "', "   .
        "`orders`.`supplier_address_zone_id`=" . $this->db->escape( $data[ 'delivery_address' ]['zone_id'] ) . ", "   .        
        "`orders`.`supplier_address_zone_name`='" . $this->db->escape( $data[ 'delivery_address' ]['zone'] ) . "', "   .
        "`orders`.`supplier_address_postcode`='" . $this->db->escape( $$data[ 'delivery_address' ]['postcode'] ) . "', "   .
        "`orders`.`supplier_address_city`='" . $this->db->escape( $data[ 'delivery_address' ]['city'] ) . "', "   .        
        "`orders`.`supplier_address_street`='" . $this->db->escape( $data[ 'delivery_address' ]['street'] ) . "', "   .
        "`orders`.`supplier_address_house`='" . $this->db->escape( $data[ 'delivery_address' ]['house'] ) . "', "   .
        "`orders`.`supplier_address_building`='" . $this->db->escape( $data[ 'delivery_address' ]['building'] ) . "', "   .        
        "`orders`.`supplier_address_room`='" . $this->db->escape( $data[ 'delivery_address' ]['apartment']) . "', "   .

        // "`orders`.`payment_company_vat_number`='" . $this->db->escape( $data[ 'customer_guid' ] ) . "', " .        
        "`orders`.`customer_firstname`='" . $this->db->escape( $data[ 'customer' ]['firstname'] ) . "', " .
        "`orders`.`customer_lastname`='" . $this->db->escape(  $data[ 'customer' ]['lastname']  ) . "', "  .        
        "`orders`.`customer_email`='" . $this->db->escape(  $data[ 'customer' ]['email'] ) . "', "  .        
        "`orders`.`customer_phone`='" . $this->db->escape( $data[ 'customer' ]['phone'] ) . "', " .

        "`orders`.`payment_company_name`='" . $this->db->escape( $data[ 'customer' ]['company_name']) . "', "  .
        // "`orders`.`payment_company_vat_number`='" . $this->db->escape( $data[ 'customer_guid' ] ) . "', " .        
        "`orders`.`payment_contact_firstname`='" . $this->db->escape( $data[ 'customer' ]['firstname'] ) . "', " .
        "`orders`.`payment_contact_lastname`='" . $this->db->escape(  $data[ 'customer' ]['lastname']  ) . "', "  .        
        "`orders`.`payment_contact_middlename`='" . $this->db->escape( $data[ 'customer' ]['middlename'] ) . "', " .
        "`orders`.`payment_contact_email`='" . $this->db->escape(  $data[ 'customer' ]['email'] ) . "', "  .        
        "`orders`.`payment_contact_phone`='" . $this->db->escape( $data[ 'customer' ]['phone'] ) . "', " .

        "`orders`.`payment_address_id`='" . $this->db->escape( $data[ 'payment_address' ]['guid'] ) . "', " .
        "`orders`.`payment_address_country_id`=" . $this->db->escape( $data[ 'payment_address' ]['country_id'] ) . ", " .
        "`orders`.`payment_address_country_name`='" . $this->db->escape( $data[ 'payment_address' ]['country'] ) . "', "  .
        "`orders`.`payment_address_zone_id`=" . $this->db->escape( $data[ 'payment_address' ]['zone_id'] ) . ", "  .        
        "`orders`.`payment_address_zone_name`='" . $this->db->escape( $data[ 'payment_address' ]['zone'] ) . "', "  .
        "`orders`.`payment_address_postcode`='" . $this->db->escape( $data[ 'payment_address' ]['postcode'] ) . "', "  .
        "`orders`.`payment_address_city`='" . $this->db->escape( $data[ 'payment_address' ]['city'] ) . "', "  .        
        "`orders`.`payment_address_street`='" . $this->db->escape( $data[ 'payment_address' ]['street'] ) . "', "  .
        "`orders`.`payment_address_house`='" . $this->db->escape( $data[ 'payment_address' ]['house'] ) . "', "  .
        "`orders`.`payment_address_building`='" . $this->db->escape( $data[ 'payment_address' ]['building'] ) . "', "  .        
        "`orders`.`payment_address_room`='" . $this->db->escape( $data[ 'payment_address' ]['apartment'] ) . "', "  .
        
        "`orders`.`delivery_company_name`='" . $this->db->escape( $data[ 'supplier' ]['company_name']  ) . "', " .
        // "`orders`.`delivery_company_vat_number`='" . $this->db->escape(  $data[ 'supplier' ]['company_name']  ) . "', " .        
        "`orders`.`delivery_contact_firstname`='" . $this->db->escape(  $data[ 'supplier' ]['firstname'] ) . "', " .
        "`orders`.`delivery_contact_lastname`='" . $this->db->escape(  $data[ 'supplier' ]['lastname']  ) . "', " .        
        "`orders`.`delivery_contact_middlename`='" . $this->db->escape( $data[ 'supplier' ]['middlename']  ) . "', " .
        "`orders`.`delivery_contact_email`='" . $this->db->escape(  $data[ 'supplier' ]['email']  ) . "', " .        
        "`orders`.`delivery_contact_phone` ='" . $this->db->escape(  $data[ 'supplier' ]['phone']  ) . "', " .

        "`orders`.`delivery_address_id`='" . $this->db->escape( $data[ 'delivery_address' ]['guid'] ) . "', " .
        "`orders`.`delivery_address_country_id`=" . $this->db->escape( $data[ 'delivery_address' ]['country_id'] ) . ", " .
        "`orders`.`delivery_address_country_name`='" . $this->db->escape( $data[ 'delivery_address' ]['country'] ) . "', " .
        "`orders`.`delivery_address_zone_id`=" . $this->db->escape( $data[ 'delivery_address' ]['zone_id'] ) . ", " .        
        "`orders`.`delivery_address_zone_name`='" . $this->db->escape( $data[ 'delivery_address' ]['zone'] ) . "', " .
        "`orders`.`delivery_address_postcode`='" . $this->db->escape( $data[ 'delivery_address' ]['postcode'] ) . "', " .
        "`orders`.`delivery_address_city`='" . $this->db->escape( $data[ 'delivery_address' ]['city'] ) . "', " .        
        "`orders`.`delivery_address_street`='" . $this->db->escape( $data[ 'delivery_address' ]['street'] ) . "', " .
        "`orders`.`delivery_address_house`='" . $this->db->escape( $data[ 'delivery_address' ]['house'] ) . "', " .
        "`orders`.`delivery_address_building`='" . $this->db->escape( $data[ 'delivery_address' ]['building'] ) . "', " .        
        "`orders`.`delivery_address_room`='" . $this->db->escape( $data[ 'delivery_address' ]['apartment'] ) . "' " ;

        $this->log->Log_Debug( 'sql ' .  $sql);
    // Query database
    $this->db->query( $sql );

    // Return data
    return( true );

  }

  //----------------------------------------------------------------------------
  // Add new order Line
  //----------------------------------------------------------------------------

  public function Add_Line($data=[] )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`order_lines` " .
      "SET " .
        "`order_lines`.`order_id`='" . $this->db->escape( $data[ 'order_id' ] ) . "', "  .
        "`order_lines`.`item_guid`='" . $this->db->escape( $data[ 'item' ][ 'guid' ] ) . "', "  .
        "`order_lines`.`mpn`='" . $this->db->escape( $data[ 'item' ][ 'mpn' ]  ) . "', " .
        "`order_lines`.`quantity`='" . $this->db->escape( $data[ 'quantity' ] ) . "', "  .
        "`order_lines`.`price`=" . $this->db->escape( $data[ 'item' ][ 'price' ] ) . ", " .
        // "`order_lines`.`vat_rate`='" . $this->db->escape( $data[ 'order_id' ] ) . "', " .
        // "`order_lines`.`vat`='" . $this->db->escape( $data[ 'order_id' ] ) . "', "  .
        // "`order_lines`.`total`='" . $this->db->escape( $data[ 'order_id' ] ) . "', " 
        "`order_lines`.`net`='" . $this->db->escape( $data[ 'item' ][ 'price' ] * $data[ 'quantity' ] ) . "' " ;

        $this->log->Log_Debug( 'sql ' .  $sql);
    // Query database
    $this->db->query( $sql );

    // Return data
    return( true );

  }

  
  //----------------------------------------------------------------------------
  // Update payment address
  //----------------------------------------------------------------------------

  public function Update_Payment_Address($data)
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
      "orders " .
      "SET " .
      "`orders`.`payment_address_id`='" . $this->db->escape($data['address']['guid']) . "', " .
      "`orders`.`payment_address_country_id`=" . $this->db->escape($data['address']['country_id']) . ", " .
      "`orders`.`payment_address_country_name`='" . $this->db->escape($data['address']['country']) . "', " .
      "`orders`.`payment_address_zone_id`=" . $this->db->escape($data['address']['zone_id']) . ", " .
      "`orders`.`payment_address_zone_name`='" . $this->db->escape($data['address']['zone']) . "', " .
      "`orders`.`payment_address_postcode`='" . $this->db->escape($data['address']['postcode']) . "', " .
      "`orders`.`payment_address_city`='" . $this->db->escape($data['address']['city']) . "', " .
      "`orders`.`payment_address_street`='" . $this->db->escape($data['address']['street']) . "', " .
      "`orders`.`payment_address_house`='" . $this->db->escape($data['address']['house']) . "', " .
      "`orders`.`payment_address_building`='" . $this->db->escape($data['address']['building']) . "', " .
      "`orders`.`payment_address_room`='" . $this->db->escape($data['address']['apartment']) . "' " .
      "WHERE " .
      "order_id=" . $this->db->escape($data['order_id']) . " " ;

      $this->log->Log_Debug( 'sql ' .  $sql);

    // Query database
    $this->db->query($sql);

    // Set success code
    $return_code = true;

    // Return success/error code
    return ($return_code);

  }

  //----------------------------------------------------------------------------
  // Update delivery address
  //----------------------------------------------------------------------------

  public function Update_Delivery_Address($data)
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
      "orders " .
      "SET " .
      "`orders`.`delivery_address_id`='" . $this->db->escape($data['address']['guid']) . "', " .
      "`orders`.`delivery_address_country_id`=" . $this->db->escape($data['address']['country_id']) . ", " .
      "`orders`.`delivery_address_country_name`='" . $this->db->escape($data['address']['country']) . "', " .
      "`orders`.`delivery_address_zone_id`=" . $this->db->escape($data['address']['zone_id']) . ", " .
      "`orders`.`delivery_address_zone_name`='" . $this->db->escape($data['address']['zone']) . "', " .
      "`orders`.`delivery_address_postcode`='" . $this->db->escape($data['address']['postcode']) . "', " .
      "`orders`.`delivery_address_city`='" . $this->db->escape($data['address']['city']) . "', " .
      "`orders`.`delivery_address_street`='" . $this->db->escape($data['address']['street']) . "', " .
      "`orders`.`delivery_address_house`='" . $this->db->escape($data['address']['house']) . "', " .
      "`orders`.`delivery_address_building`='" . $this->db->escape($data['address']['building']) . "', " .
      "`orders`.`delivery_address_room`='" . $this->db->escape($data['address']['apartment']) . "' " .
      "WHERE " .
      "order_id=" . $this->db->escape($data['order_id']) . " " ;

      $this->log->Log_Debug( 'sql ' .  $sql);

    // Query database
    $this->db->query($sql);

    // Set success code
    $return_code = true;

    // Return success/error code
    return ($return_code);

  }
  // //----------------------------------------------------------------------------
  // // Get customer orders
  // //----------------------------------------------------------------------------

  // public function Get_Customer_Orders($customer_guid = '')
  // {

  //   // Compose SQL query
  //   $sql =
  //     "SELECT " .
  //       " * " .
  //     "FROM " .
  //       "orders " .
  //     "WHERE " .
  //       "`orders`.`customer_guid`='" . $this->db->escape( $customer_guid). "'  ";

  //   // Perform SQL query
  //   $query = $this->db->query( $sql );

  //   // Return properties description
  //   return( $query->rows );

  // }
 
  // //----------------------------------------------------------------------------
  // // Get customer order
  // //----------------------------------------------------------------------------

  // public function Get_Customer_Order($order_id = '')
  // {

  //   // Compose SQL query
  //   $sql =
  //     "SELECT " .
  //       " * " .

  //     "FROM " .
  //       "orders " .
  //     "WHERE " .
  //       "`orders`.`order_id`=" . $this->db->escape( $order_id). "";

  //   // Perform SQL query
  //   $query = $this->db->query( $sql );

  //   // Return orders description
  //   return( $query->row );

  // }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>