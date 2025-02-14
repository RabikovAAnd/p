<?php
class ModelAccountOrders extends Model 
{

    public function Add_Order($account_data, $cart_data, $payment_address_data, $delivery_address_data)
  {
$customer_data=$this->customer->Get_Customer_By_GUID($this->customer->Get_GUID());
    // Compose SQL query
    $date_arr = new DateTime();
    $date = $date_arr->format('Y-m-d H:i:s');
    $sql =
      "INSERT INTO " .
      "`orders` " .
      "SET " .
      "`customer_guid`= '" . $this->customer->Get_GUID() . "', " .
      "`date`= '" . $date . "', " .
      "`comment`= '" . $cart_data['comment'] . "', " .
      "`language_code`= '" . $this->language->Get_Language_Code() . "', " .
      "`payment_method_id`= " . $cart_data['payment_method_id'] . ", " .
      "`delivery_method_id`= " . $cart_data['delivery_method_id'] . ", " .
      "`net`= " .  $cart_data['net'] . ", " .
      "`vat`= " .  $cart_data['vat'] . ", " .
      "`total`= " .  $cart_data['total'] . ", " .
      "`currency_code`= '" .  $cart_data['currency_code'] . "', " .

      "`payment_address_id`= '" .  $cart_data['payment_address_guid'] . "', " .
      "`payment_address_country_name` = '" . $payment_address_data['country'] . "', " .
      "`payment_address_country_id` = " .  $payment_address_data['country_id'] . ", " .
      "`payment_address_zone_id` = " .  $payment_address_data['zone_id'] . ", " .
      '`payment_address_zone_name` = "' .  $payment_address_data['zone'] . '", ' .
      "`payment_address_postcode` = '" .  $payment_address_data['postcode'] . "', " .
      "`payment_address_city` = '" .  $payment_address_data['city'] . "', " .
      "`payment_address_street` = '" .  $payment_address_data['street'] . "', " .
      "`payment_address_house` = '" .  $payment_address_data['house'] . "', " .
      "`payment_address_building` = '" .  $payment_address_data['building'] . "', " .
      "`payment_address_room` = '" .  $payment_address_data['apartment'] . "', " .

//        "`orders`.`payment_contact_id`, " .
//      "`payment_company_name` = " . "NULL" . ", " .
//      "`payment_company_vat_number` = ". "NULL" . ", " .
      "`payment_contact_firstname` = '". $account_data['customer_firstname'] . "', " .
      "`payment_contact_lastname` = '". $account_data['customer_lastname'] . "', " .
      "`payment_contact_middlename`= '". $account_data['customer_middlename'] . "', " .
      "`payment_contact_email`= '". $account_data['customer_email'] . "', " .
      "`payment_contact_phone`= '". $account_data['customer_telephone'] . "', " .

      "`delivery_address_id`= '" .  $cart_data['delivery_address_guid'] . "', " .
      "`delivery_address_country_name`= '" . $delivery_address_data['country'] . "', " .
      "`delivery_address_country_id`= " . $delivery_address_data['country_id'] . ", " .
      "`delivery_address_zone_id`= " . $delivery_address_data['zone_id'] . ", " .
      "`delivery_address_zone_name`= '" . $delivery_address_data['zone'] . "', " .
      "`delivery_address_postcode`= '" . $delivery_address_data['postcode'] . "', " .
      "`delivery_address_city`= '" . $delivery_address_data['city'] . "', " .
      "`delivery_address_street`= '" . $delivery_address_data['street'] . "', " .
      "`delivery_address_house`= '" . $delivery_address_data['house'] . "', " .
      "`delivery_address_building`= '" . $delivery_address_data['building'] . "', " .
      "`delivery_address_room`= '" . $delivery_address_data['apartment'] . "', " .

//        "`orders`.`delivery_contact_id`, " .
//      "`delivery_company_name`= '". "NULL" . "', " .
//      "`delivery_company_vat_number`= ". "NULL" . ", " .
      "`delivery_contact_firstname`= '". $account_data['recipient_firstname'] . "', " .
      "`delivery_contact_lastname`= '". $account_data['recipient_lastname'] . "', " .
      "`delivery_contact_middlename`= '". $account_data['recipient_middlename'] . "', " .
      "`delivery_contact_email`='". $account_data['recipient_email'] . "', " .
      "`delivery_contact_phone` = '" . $account_data['recipient_telephone'] . "' ";


    // Query database
    $this->db->query( $sql );
    $select_sql =
      "SELECT " .
      "`order_id` " .
      "FROM " .
      "`orders` " .
      "WHERE " .
      "`orders`.`date`='" . $date . "' AND " .
      "`orders`.`customer_guid`='" . $this->customer->Get_GUID() . "'";
    $order_id = $this->db->query( $select_sql );
    // Return order data
    return $order_id->row['order_id'];

  }
  public function Add_Order_Line($data){
    $sql =
      "INSERT INTO " .
      "`order_lines` " .
      "SET " .
      "`order_id`= " . $data['order_id'] . ", " .
      "`item_guid`= '" . $data['guid'] . "', " .
      "`mpn`= '" . $data['mpn'] . "', " .
      "`description`= '" . $data['description'] . "', " .
      "`quantity`= '" . $data['quantity'] . "', " .
      "`price`= '" . $data['price'] . "', " .
      "`net`= '" . $data['net'] . "', " .
      "`vat_rate`= '" . $data['vat_rate'] . "', " .
      "`vat`= '" . $data['vat'] . "', " .
      "`total`= '" . $data['total'] . "' ";
    // Query database
    $this->db->query( $sql );
  }
  //----------------------------------------------------------------------------
  // Get item count
  //----------------------------------------------------------------------------
/*
	public function Get_Order_Item_Count( $order_id ) 
  {

    // ANVILEX KM: Test order_id validity

		// Compose SQL query
		$sql = "SELECT COUNT(*) AS count FROM order_product WHERE order_id=" . (int)$order_id;

    // Query database
    $result = $this->db->query( $sql );

    // Return item count
    return( $result->row[ 'count' ] );

  }
*/
  //----------------------------------------------------------------------------
/*		
	public function getOrderHistories($order_id) 
	{
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment, oh.notify FROM order_history oh LEFT JOIN order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND oh.notify = '1' AND os.language_id = '0' ORDER BY oh.date_added");
	
		return $query->rows;
	}	
*/
  //----------------------------------------------------------------------------
/*
	public function getTotalOrders() 
	{

    $query = $this->db->query("SELECT COUNT(*) AS total FROM `order` WHERE customer_id = '" . (int)$this->customer->Get_ID() . "' AND order_status_id > '0'");
		
		return $query->row['total'];

	}
*/
	//----------------------------------------------------------------------------	
/*
	public function getTotalOrderProductsByOrderId($order_id) 
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM order_product WHERE order_id = '" . (int)$order_id . "'");
		
		return $query->row['total'];
	}
*/
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>