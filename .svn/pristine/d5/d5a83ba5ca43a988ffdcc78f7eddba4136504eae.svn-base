<?php
class ModelSalesSales extends Model
{

  //----------------------------------------------------------------------------
  // Create sales order from cart
  //----------------------------------------------------------------------------

  public function Add_Sales_Order( $cart_id, $source_id=0 )
  {

    // Compose SQL query
    $sql = "INSERT INTO orders (";
    $sql .= "date, ";
    $sql .= "source_id, ";
    $sql .= "language_id, ";
    $sql .= "status, ";
    $sql .= "extern_order_number, ";
    $sql .= "comment, ";
    $sql .= "payment_method_id, ";
    $sql .= "packing_method_id, ";
    $sql .= "shipping_method_id, ";
    $sql .= "subtotal, ";
    $sql .= "payment_fee, ";
    $sql .= "packing_fee, ";
    $sql .= "shipping_fee, ";
    $sql .= "vat_fee, ";
    $sql .= "total, ";
    $sql .= "currency_id, ";
    $sql .= "currency_code, ";
    $sql .= "currency_value, ";
    $sql .= "payment_company_vat, ";
    $sql .= "shipping_company_vat, ";
    $sql .= "customer_id, ";
    $sql .= "customer_gender_id, ";
    $sql .= "customer_firstname, ";
    $sql .= "customer_lastname, ";
    $sql .= "customer_email, ";
    $sql .= "customer_phone, ";
    $sql .= "customer_fax, ";
    $sql .= "payment_address_id, ";
    $sql .= "payment_address_company, ";
    $sql .= "payment_address_address_1, ";
    $sql .= "payment_address_address_2, ";
    $sql .= "payment_address_postcode, ";
    $sql .= "payment_address_city, ";
    $sql .= "payment_address_zone_id, ";
    $sql .= "payment_address_zone, ";
    $sql .= "payment_address_country_id, ";
    $sql .= "payment_address_country, ";
    $sql .= "payment_contact_id, ";
    $sql .= "payment_contact_gender_id, ";
    $sql .= "payment_contact_firstname, ";
    $sql .= "payment_contact_lastname, ";
    $sql .= "payment_contact_email, ";
    $sql .= "payment_contact_phone, ";
    $sql .= "payment_contact_fax, ";
    $sql .= "shipping_address_id, ";
    $sql .= "shipping_address_company, ";
    $sql .= "shipping_address_address_1, ";
    $sql .= "shipping_address_address_2, ";
    $sql .= "shipping_address_postcode, ";
    $sql .= "shipping_address_city, ";
    $sql .= "shipping_address_zone_id, ";
    $sql .= "shipping_address_zone, ";
    $sql .= "shipping_address_country_id, ";
    $sql .= "shipping_address_country, ";
    $sql .= "shipping_contact_id, ";
    $sql .= "shipping_contact_gender_id, ";
    $sql .= "shipping_contact_firstname, ";
    $sql .= "shipping_contact_lastname, ";
    $sql .= "shipping_contact_email, ";
    $sql .= "shipping_contact_phone, ";
    $sql .= "shipping_contact_fax, ";
    $sql .= "remote_ip, ";
    $sql .= "forwarded_ip, ";
    $sql .= "user_agent, ";
    $sql .= "accept_language";
    $sql .= ") ";
    $sql .= "SELECT ";
    $sql .= "NOW(), ";
    $sql .= (int)$source_id . ", ";
    $sql .= "language_id, ";
    $sql .= "'0', "; // Created
    $sql .= "cart.extern_order_number, ";
    $sql .= "cart.comment, ";
    $sql .= "cart.payment_method_id, ";
    $sql .= "cart.packing_method_id, ";
    $sql .= "cart.shipping_method_id, ";
    $sql .= "cart.subtotal, ";
    $sql .= "cart.payment_fee, ";
    $sql .= "cart.packing_fee, ";
    $sql .= "cart.shipping_fee, ";
    $sql .= "cart.vat_fee, ";
    $sql .= "cart.total, ";
    $sql .= "cart.currency_id, ";
    $sql .= "cart.currency_code, ";
    $sql .= "cart.currency_value, ";
    $sql .= "cart.payment_company_vat, ";
    $sql .= "cart.shipping_company_vat, ";
    $sql .= "cart.customer_id, ";
    $sql .= "cart.customer_gender_id, ";
    $sql .= "cart.customer_firstname, ";
    $sql .= "cart.customer_lastname, ";
    $sql .= "cart.customer_email, ";
    $sql .= "cart.customer_phone, ";
    $sql .= "cart.customer_fax, ";
    $sql .= "cart.payment_address_id, ";
    $sql .= "cart.payment_address_company, ";
    $sql .= "cart.payment_address_address_1, ";
    $sql .= "cart.payment_address_address_2, ";
    $sql .= "cart.payment_address_postcode, ";
    $sql .= "cart.payment_address_city, ";
    $sql .= "cart.payment_address_zone_id, ";
    $sql .= "cart.payment_address_zone, ";
    $sql .= "cart.payment_address_country_id, ";
    $sql .= "cart.payment_address_country, ";
    $sql .= "cart.payment_contact_id, ";
    $sql .= "cart.payment_contact_gender_id, ";
    $sql .= "cart.payment_contact_firstname, ";
    $sql .= "cart.payment_contact_lastname, ";
    $sql .= "cart.payment_contact_email, ";
    $sql .= "cart.payment_contact_phone, ";
    $sql .= "cart.payment_contact_fax, ";
    $sql .= "cart.shipping_address_id, ";
    $sql .= "cart.shipping_address_company, ";
    $sql .= "cart.shipping_address_address_1, ";
    $sql .= "cart.shipping_address_address_2, ";
    $sql .= "cart.shipping_address_postcode, ";
    $sql .= "cart.shipping_address_city, ";
    $sql .= "cart.shipping_address_zone_id, ";
    $sql .= "cart.shipping_address_zone, ";
    $sql .= "cart.shipping_address_country_id, ";
    $sql .= "cart.shipping_address_country, ";
    $sql .= "cart.shipping_contact_id, ";
    $sql .= "cart.shipping_contact_gender_id, ";
    $sql .= "cart.shipping_contact_firstname, ";
    $sql .= "cart.shipping_contact_lastname, ";
    $sql .= "cart.shipping_contact_email, ";
    $sql .= "cart.shipping_contact_phone, ";
    $sql .= "cart.shipping_contact_fax, ";
    $sql .= "cart.remote_ip, ";
    $sql .= "cart.forwarded_ip, ";
    $sql .= "cart.user_agent, ";
    $sql .= "cart.accept_language ";
    $sql .= "FROM cart ";
    $sql .= "WHERE cart.id=" . (int)$cart_id;

    // Query database
    $this->db->query( $sql );

    // Get order ID
    $order_id = $this->db->getLastId();

    //--------------------------------------------------------------------------
    // Insert ordered products
    //--------------------------------------------------------------------------

    // Compose SQL query
    $sql = "INSERT INTO order_product (";
    $sql .= "order_id, ";
    $sql .= "product_id, ";
    $sql .= "quantity, ";
    $sql .= "price, ";
    $sql .= "subtotal, ";
    $sql .= "vat_rate, ";
    $sql .= "vat_fee, ";
    $sql .= "total";
    $sql .= ") ";
    $sql .= "SELECT ";
    $sql .= (int)$order_id . ", ";
    $sql .= "cart_products.product_id, ";
    $sql .= "cart_products.quantity, ";
    $sql .= "cart_products.price, ";
    $sql .= "cart_products.subtotal, ";
    $sql .= "cart_products.vat_rate, ";
    $sql .= "cart_products.vat_fee, ";
    $sql .= "cart_products.total ";
    $sql .= "FROM cart_products ";
    $sql .= "WHERE cart_products.cart_id=" . (int)$cart_id;

    // Query database
    $this->db->query( $sql );

    //--------------------------------------------------------------------------
    // Log order history
    //--------------------------------------------------------------------------

    // Add order history
    $this->Log_Sales_Order_Create( $order_id );

    // Return order ID
    return( $order_id );

  }

  //----------------------------------------------------------------------------
  // Get sales order by order id
  //----------------------------------------------------------------------------

  public function Get_Sales_Order( $order_id )
  {

    // Test order code
    if ( $order_id == 0 )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalid order ID
      //------------------------------------------------------------------------

      // Log error
      $this->log->Log_Error( 'Detected invalid order ID: ' . $order_id );

      // Set empty payment method code
      $order_data[ 'valid' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Order ID valid, continue processing
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "SELECT *, (SELECT os.name FROM order_status os WHERE os.order_status_id=o.order_status_id AND os.language_id=o.language_id) AS order_status FROM `orders` o WHERE o.order_id=" . (int)$order_id;

      // Query database
      $result = $this->db->query( $sql );

      // Rest query result
      if ( $result->num_rows != 1 )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid record count detected
        //----------------------------------------------------------------------

        // Log error
        $this->log->Log_Error( 'Order record not found, ID: ' . $order_id . ", rows: " . $result->num_rows );

        // Set empty payment method code
        $order_data[ 'valid' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Order data queried, continue processing
        //----------------------------------------------------------------------

        // Try to get payment country
        $country_query = $this->db->query( "SELECT * FROM country WHERE country_id = '" . (int)$result->row[ 'payment_address_country_id' ] . "'" );

        if ( $country_query->num_rows )
        {
          $payment_country = $country_query->row['name'];
          $payment_iso_code_2 = $country_query->row['iso_code_2'];
          $payment_iso_code_3 = $country_query->row['iso_code_3'];
        }
        else
        {
          $payment_country = '';
          $payment_iso_code_2 = '';
          $payment_iso_code_3 = '';
        }

        $zone_query = $this->db->query( "SELECT code FROM zone WHERE zone_id = '" . (int)$result->row[ 'payment_address_zone_id' ] . "'" );
        $payment_zone_code = ($zone_query->num_rows) ? $zone_query->row['code'] : '';

        // Try to get shipping
        $country_query = $this->db->query( "SELECT * FROM country WHERE country_id = '" . (int)$result->row[ 'shipping_address_country_id' ] . "'" );

        if ( $country_query->num_rows )
        {
          $shipping_country = $country_query->row['name'];
          $shipping_iso_code_2 = $country_query->row['iso_code_2'];
          $shipping_iso_code_3 = $country_query->row['iso_code_3'];
        }
        else
        {
          $shipping_country = '';
          $shipping_iso_code_2 = '';
          $shipping_iso_code_3 = '';
        }

        $zone_query = $this->db->query("SELECT code FROM zone WHERE zone_id = '" . (int)$result->row['shipping_address_zone_id'] . "'");
        $shipping_zone_code = ($zone_query->num_rows) ? $zone_query->row['code'] : '';

        //----------------------------------------------------------------------

        $language_info = $this->language->Get_Language( $result->row[ 'language_code' ] );

        if ($language_info)
        {
          $language_code = $language_info['code'];
          $language_filename = $language_info['filename'];
          $language_directory = $language_info['directory'];
        }
        else
        {
          $language_code = 'en';
          $language_filename = 'english';
          $language_directory = 'english';
        }

        //----------------------------------------------------------------------

        // Set order data
        $order_data[ 'valid' ] = true;

        // General order data
        $order_data[ 'order_id' ] = $result->row[ 'order_id' ];
        $order_data[ 'date' ] = $result->row[ 'date' ];
        $order_data[ 'source_id' ] = $result->row[ 'source_id' ];
        $order_data[ 'language_id' ] = $result->row[ 'language_id' ];
        $order_data[ 'language_code' ] = $language_code;
        $order_data[ 'language_filename' ] = $language_filename;
        $order_data[ 'language_directory' ] = $language_directory;
        $order_data[ 'status' ] = $result->row[ 'status' ];
        $order_data[ 'extern_order_number' ] = $result->row[ 'extern_order_number' ];
        $order_data[ 'comment' ] = $result->row[ 'comment' ];
        $order_data[ 'shipping_method_id' ] = $result->row[ 'shipping_method_id' ];
        $order_data[ 'packing_method_id' ] = $result->row[ 'packing_method_id' ];
        $order_data[ 'payment_method_id' ] = $result->row[ 'payment_method_id' ];
        $order_data[ 'subtotal' ] = $result->row[ 'subtotal' ];
        $order_data[ 'handling_fee' ] = $result->row[ 'handling_fee' ];
        $order_data[ 'payment_fee' ] = $result->row[ 'payment_fee' ];
        $order_data[ 'packing_fee' ] = $result->row[ 'packing_fee' ];
        $order_data[ 'shipping_fee' ] = $result->row[ 'shipping_fee' ];
        $order_data[ 'vat_fee' ] = $result->row[ 'vat_fee' ];
        $order_data[ 'total' ] = $result->row[ 'total' ];
        $order_data[ 'currency_id' ] = $result->row[ 'currency_id' ];
        $order_data[ 'currency_code' ] = $result->row[ 'currency_code' ];
        $order_data[ 'currency_value' ] = $result->row[ 'currency_value' ];
        $order_data[ 'payment_company_vat' ] = $result->row[ 'payment_company_vat' ];
        $order_data[ 'shipping_company_vat' ] = $result->row[ 'shipping_company_vat' ];

        // Customer data (location+contact)
        $order_data[ 'customer_id' ] = $result->row[ 'customer_id' ];
        $order_data[ 'customer_gender_id' ] = $result->row[ 'customer_gender_id' ];
        $order_data[ 'customer_firstname' ] = $result->row[ 'customer_firstname' ];
        $order_data[ 'customer_lastname' ] = $result->row[ 'customer_lastname' ];
        $order_data[ 'customer_email' ] = $result->row[ 'customer_email' ];
        $order_data[ 'customer_phone' ] = $result->row[ 'customer_phone' ];
        $order_data[ 'customer_fax' ] = $result->row[ 'customer_fax' ];

        // Payment address
        $order_data[ 'payment_address_id' ] = $result->row[ 'payment_address_id' ];
        $order_data[ 'payment_address_company' ] = $result->row[ 'payment_address_company' ];
        $order_data[ 'payment_address_address_1' ] = $result->row[ 'payment_address_address_1' ];
        $order_data[ 'payment_address_address_2' ] = $result->row[ 'payment_address_address_2' ];
        $order_data[ 'payment_address_postcode' ] = $result->row[ 'payment_address_postcode' ];
        $order_data[ 'payment_address_city' ] = $result->row[ 'payment_address_city' ];
        $order_data[ 'payment_address_zone_id' ] = $result->row[ 'payment_address_zone_id' ];
        $order_data[ 'payment_address_zone' ] = $result->row[ 'payment_address_zone' ];
        $order_data[ 'payment_address_zone_code' ] = $payment_zone_code;
        $order_data[ 'payment_address_country_id' ] = $result->row[ 'payment_address_country_id' ];
        $order_data[ 'payment_address_country' ] = $payment_country;
        $order_data[ 'payment_address_country_iso_code_2' ] = $payment_iso_code_2;
//        $order_data[ 'payment_iso_code_3' ] = $payment_iso_code_3;

        // Payment contact
        $order_data[ 'payment_contact_id' ] = $result->row[ 'payment_contact_id' ];
        $order_data[ 'payment_contact_gender_id' ] = $result->row[ 'payment_contact_gender_id' ];
        $order_data[ 'payment_contact_firstname' ] = $result->row[ 'payment_contact_firstname' ];
        $order_data[ 'payment_contact_lastname' ] = $result->row[ 'payment_contact_lastname' ];
        $order_data[ 'payment_contact_email' ] = $result->row[ 'payment_contact_email' ];
        $order_data[ 'payment_contact_phone' ] = $result->row[ 'payment_contact_phone' ];
        $order_data[ 'payment_contact_fax' ] = $result->row[ 'payment_contact_fax' ];

        // Shipping address
        $order_data[ 'shipping_address_id' ] = $result->row[ 'shipping_address_id' ];
        $order_data[ 'shipping_address_company' ] = $result->row[ 'shipping_address_company' ];
        $order_data[ 'shipping_address_address_1' ] = $result->row[ 'shipping_address_address_1' ];
        $order_data[ 'shipping_address_address_2' ] = $result->row[ 'shipping_address_address_2' ];
        $order_data[ 'shipping_address_postcode' ] = $result->row[ 'shipping_address_postcode' ];
        $order_data[ 'shipping_address_city' ] = $result->row[ 'shipping_address_city' ];
        $order_data[ 'shipping_address_zone_id' ] = $result->row[ 'shipping_address_zone_id' ];
        $order_data[ 'shipping_address_zone' ] = $result->row[ 'shipping_address_zone' ];
        $order_data[ 'shipping_address_zone_code' ] = $shipping_zone_code;
        $order_data[ 'shipping_address_country_id' ] = $result->row[ 'shipping_address_country_id' ];
        $order_data[ 'shipping_address_country' ] = $shipping_country;
//        $order_data[ 'shipping_iso_code_2' ] = $shipping_iso_code_2;
//        $order_data[ 'shipping_iso_code_3' ] = $shipping_iso_code_3;

        // Shipping contact
        $order_data[ 'shipping_contact_id' ] = $result->row[ 'shipping_contact_id' ];
        $order_data[ 'shipping_contact_gender_id' ] = $result->row[ 'shipping_contact_gender_id' ];
        $order_data[ 'shipping_contact_firstname' ] = $result->row[ 'shipping_contact_firstname' ];
        $order_data[ 'shipping_contact_lastname' ] = $result->row[ 'shipping_contact_lastname' ];
        $order_data[ 'shipping_contact_email' ] = $result->row[ 'shipping_contact_email' ];
        $order_data[ 'shipping_contact_phone' ] = $result->row[ 'shipping_contact_phone' ];
        $order_data[ 'shipping_contact_fax' ] = $result->row[ 'shipping_contact_fax' ];

        // Telemetry data
        $order_data[ 'remote_ip' ] = $result->row[ 'remote_ip' ];
        $order_data[ 'forwarded_ip' ] = $result->row[ 'forwarded_ip' ];
        $order_data[ 'user_agent' ] = $result->row[ 'user_agent' ];
        $order_data[ 'accept_language' ] = $result->row[ 'accept_language' ];

      }

    }

    // Return order data
    return( $order_data );

  }

  //----------------------------------------------------------------------------
  // Create new sales invoice
  //----------------------------------------------------------------------------

  public function Create_Sales_Invoice( $order_id )
  {

    // Compose SQL statement
    $sql = "SELECT language_id, total FROM orders WHERE order_id=" . (int)$order_id;

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // ERROR: Order not found
      //------------------------------------------------------------------------

      // Log error
      $this->log->Log_Error( 'Order not found. order_id: ' . $order_id, true );

      // Set default data
      $data[ 'valid' ] = false;
      $data[ 'invoice_id' ] = 0;

    }
    else
    {

      //------------------------------------------------------------------------
      // Order found, continue processing
      //------------------------------------------------------------------------

      // Compose SQL statement
      $sql = "INSERT INTO sales_invoices SET ";
      $sql .= "order_id=" . (int)$order_id . ", ";
      $sql .= "date=NOW(), ";
      $sql .= "language_id=" . (int)$result->row[ 'language_id' ] . ", ";
      $sql .= "status='issued'";

      // Query database
      $this->db->query( $sql );

      // Get last invoice id
      // ANVILEX: Use more safe hash value
      $invoice_id = $this->db->getLastId();

      // Compose SQL statement
      $sql = "INSERT INTO sales_invoice_transactions SET ";
      $sql .= "date=NOW(), ";
      $sql .= "invoice_id=" . (int)$invoice_id . ", ";
      $sql .= "transaction='invoice', ";
      $sql .= "amount='-" . $result->row[ 'total' ] . "' ";

      // Query database
      $this->db->query( $sql );

      // Set default data
      $data[ 'valid' ] = true;
      $data[ 'invoice_id' ] = $invoice_id;

    }

    // Return invoice data
    return( $data );

  }

  //----------------------------------------------------------------------------
  // Get sales invoice information
  //----------------------------------------------------------------------------

  public function Get_Sales_Invoice_Info( $invoice_id )
  {

    // Compose SQL statement
    $sql = "SELECT * FROM sales_invoices WHERE invoice_id=" . (int)$invoice_id;

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // ERROR: Invoice not found
      //------------------------------------------------------------------------

      // Log error
      $this->log->Log_Error( 'Invoice not found. order_id: ' . $invoice_id, true );

      // Set default data
      $data[ 'valid' ] = false;
      $data[ 'invoice_id' ] = 0;
      $data[ 'order_id' ] = 0;
      $data[ 'date' ] = '';
      $data[ 'language_id' ] = 0;
      $data[ 'status' ] = '';

    }
    else
    {

      //------------------------------------------------------------------------
      // Invoice found, continue processing
      //------------------------------------------------------------------------

      // Set default data
      $data[ 'valid' ] = true;
      $data[ 'invoice_id' ] = $result->row[ 'invoice_id' ];
      $data[ 'order_id' ] = $result->row[ 'order_id' ];
      $data[ 'date' ] = $result->row[ 'date' ];
      $data[ 'language_id' ] = $result->row[ 'language_id' ];
      $data[ 'status' ] = $result->row[ 'status' ];

    }

    // Return invoice data
    return( $data );

  }

  //----------------------------------------------------------------------------
  // Send sales invoice
  //----------------------------------------------------------------------------

  public function Send_Sales_Invoice( $invoice_id )
  {

    // Get invoice information
    $invoice_info = $this->Get_Sales_Invoice_Info( $invoice_id );

    // Test invoice information validity
    if ( $invoice_info[ 'valid' ] == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Invoice not found
      //------------------------------------------------------------------------

      // Log error
      $this->log->Log_Error( 'Invoice not found. order_id: ' . $invoice_id, true );

    }
    else
    {

      //------------------------------------------------------------------------
      // Invoice found, continue processing
      //------------------------------------------------------------------------

      // Get order information
      $order_info = $this->Get_Sales_Order( $invoice_info[ 'order_id' ] );

      // Test order information validity
      if ( $order_info[ 'valid' ] == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Order not found
        //----------------------------------------------------------------------

        // Log error
        $this->log->Log_Error( 'Order not found. order_id: ' . $invoice_info[ 'order_id' ], true );

      }
      else
      {

        //----------------------------------------------------------------------
        // Order found, continue processing
        //----------------------------------------------------------------------

        // Load data model
        $this->load->model( 'account/communication' );

        // Try to get communication channel
        $communication_channel = $this->model_account_communication->Get_Channel_By_Email( $order_info[ 'customer_email' ] );

        // Test communication channel info
        if ( $communication_channel[ 'valid' ] == false )
        {

          //--------------------------------------------------------------------
          // ERROR: Communication channel not found
          //--------------------------------------------------------------------

          // Log error
          $this->log->Log_Error( 'Communication channel not found. order_id: ' . $invoice_info[ 'order_id' ] . ', email: ' . $order_info[ 'customer_email' ], true );

        }
        else
        {

          //--------------------------------------------------------------------
          // Communication channel found, continue processing
          //--------------------------------------------------------------------

          $message[ 'channel_id' ] = $communication_channel[ 'id' ];
          $message[ 'headline' ] = 'Invoice';
          $message[ 'body' ] = 'Invoice body';

          // Add message
          $message_info = $this->model_account_communication->addMessage( $message );

          // Test message information validity
          if ( $message_info[ 'valid' ] == false )
          {

            //------------------------------------------------------------------
            // ERROR: Message not added
            //------------------------------------------------------------------

          }
          else
          {

            //------------------------------------------------------------------
            // Message added, continue processing
            //------------------------------------------------------------------

            // Send message
            $this->model_account_communication->actionSendMessage( $message_info[ 'message_id' ] );

          }

        }

      }

    }

  }


  //----------------------------------------------------------------------------
  // Get payment method code
  //----------------------------------------------------------------------------

  public function Get_Payment_Method_Code( $order_id = 0 )
  {

    // Test order code
    if ( $order_id == 0 )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalid order ID
      //------------------------------------------------------------------------

      // Set empty payment method code
      $payment_method_code = '';

    }
    else
    {

      //------------------------------------------------------------------------
      // Order ID valid, continue processing
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "SELECT payment_method.code FROM payment_method LEFT JOIN orders ON payment_method.id=orders.payment_method_id WHERE orders.order_id=" . (int)$order_id;

      // Query database
      $result = $this->db->query( $sql );

      if ( $result->num_rows != 1 )
      {

        // Set empty payment method code
        $payment_method_code = '';

      }
      else
      {

        // Set payment method code
        $payment_method_code = $result->row[ 'code' ];

      }

    }

    // Return payment method code
    return( $payment_method_code );

  }

  //----------------------------------------------------------------------------
  // Get ordered products
  //----------------------------------------------------------------------------

  public function getProducts( $order_id )
  {

    // Compose SQL query
    $sql = "SELECT p.product_id, p.mpn, op.item_id, op.quantity, op.price, op.tax AS vat, op.total, m.name AS manufacturer, pd.description FROM order_product op LEFT JOIN product p ON (p.product_id = op.product_id) LEFT JOIN product_description pd ON (p.product_id = pd.product_id) LEFT JOIN manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE op.order_id = '" . (int)$order_id . "' AND pd.language_id = '0' ORDER BY order_product_id";

    // Query database
    $query = $this->db->query( $sql );

    $products = array();
    $position = 1;
    foreach ( $query->rows as $result )
    {

      $products[] = array(
        'position' => $position,
        'item_id' => $result['item_id'],
        'product_id' => $result['product_id'],
        'quantity' => $result['quantity'],
        'price' => $result['price'],
        'vat' => $result['vat'],
//        'vat_rate' => $result['vat_rate'],
        'vat_rate' => 0,
        'total' => $result['total'],
        'mpn' => $result['mpn'],
        'manufacturer' => $result['manufacturer'],
        'description' => $result['description'],
        'taric' => '',
        'eccn' => '',
        'coo' => ''
      );

      // Increment position index
      $position++;

    }

    return $products;
  }

  //----------------------------------------------------------------------------

  public function Processing( $order_id )
  {

  }

  //----------------------------------------------------------------------------
  // Confirm sales order receipt
  //----------------------------------------------------------------------------

  public function Confirm_Sales_Order_Receipt( $order_id )
  {

    // Get order information
    $order_info = $this->Get_Sales_Order( $order_id );

    // Test order information validity
    if ( $order_info[ 'valid' ] == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Order not found
      //------------------------------------------------------------------------

      // Log error
      $this->log->Log_Error( 'Order not found. order_id: ' . $order_id, true );

    }
    else
    {

      //------------------------------------------------------------------------
      // Order found
      //------------------------------------------------------------------------

      // Load data model
      $this->load->model( 'account/communication' );

      // Try to get communication channel
      $communication_channel = $this->model_account_communication->Get_Channel_By_Email( $order_info[ 'customer_email' ] );

      // Test communication channel info
      if ( $communication_channel[ 'valid' ] == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Communication channel not found
        //----------------------------------------------------------------------

        // Log error
        $this->log->Log_Error( 'Communication channel not found. order_id: ' . $order_id . ', email: ' . $order_info[ 'customer_email' ], true );

      }
      else
      {

        //----------------------------------------------------------------------
        // Communication channel found, continue processing
        //----------------------------------------------------------------------

        // Create new HTML mail template
//        $template = new Template();

        // Set template data
//        $template->data[ 'text_title' ] = 'Headline';

        // Compose HTML
//        $html = $template->fetch( 'mail/order.tpl' );

        // Set message data
        $message[ 'channel_id' ] = $communication_channel[ 'id' ];
        $message[ 'headline' ] = 'Order reciept confirmation';
        $message[ 'body' ] = 'Order reciept confirmation body.';

        // Add message
        $message_info = $this->model_account_communication->addMessage( $message );

        // Test message information validity
        if ( $message_info[ 'valid' ] == false )
        {

          //--------------------------------------------------------------------
          // ERROR: Message not added
          //--------------------------------------------------------------------

          // Log error
          $this->log->Log_Error( 'Message not added. communication_channel_id: ' . $communication_channel[ 'id' ], false );

        }
        else
        {

          //--------------------------------------------------------------------
          // Message added, continue processing
          //--------------------------------------------------------------------

          // Send message
          // ANVILEX KM: Define second parameter
          $this->model_account_communication->actionSendMessage( $message_info[ 'message_id' ], NULL );

        }

      }

    }

  }

  //----------------------------------------------------------------------------
  // Confirm order payment
  //----------------------------------------------------------------------------

  public function ConfirmOrderPayment( $order_id )
  {

  }

  //--------------------------------------------------------------------------

  public function updateStatus($order_id,$status_id,$notify=true,$comment='')
  {

    $order_info = $this->getOrder($order_id);

    if ($order_info)
    {

      $this->db->query("UPDATE 'order' SET order_status_id = '" . (int)$status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
      $this->db->query("INSERT INTO order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$status_id . "', notify = '" . (($notify) ? "1" : "0") . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

      if ($notify==true)
      {

        // Load payment method
        $this->load->model('payment/methods');
        $payment_method = $this->model_payment_methods->getMethod($order_info['payment_method_id'],$order_info['language_id']);

        // Load shipping method
        $this->load->model('shipping/methods');
        $shipping_method = $this->model_shipping_methods->getMethod($order_info['shipping_method_id'],$order_info['language_id']);

        // Send out order confirmation mail
//        $language = new Language($order_info['language_directory'],$this->log);
//        $language->load($order_info['language_filename']);
//        $language->load('mail/order');

        // HTML Mail
        $template = new Template();

        $template->data['text_title'] = $language->get('text_title_status_change');

        $template->data['store_url'] = $order_info['store_url'];
        $template->data['store_name'] = $order_info['store_name'];

        $template->data['text_payment_address'] = $language->get('text_payment_address');
        $template->data['text_shipping_address'] = $language->get('text_shipping_address');


        $template->data['payment_company'] = $order_info['payment_company'];
        $template->data['payment_contact'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
        $template->data['payment_address_line_1'] = $order_info['payment_address_1'];
        $template->data['payment_address_line_2'] = $order_info['payment_address_2'];
        $template->data['payment_postcode'] = $order_info['payment_postcode'];
        $template->data['payment_city'] = $order_info['payment_city'];
//        $template->data['payment_zone'] = $order_info['payment_zone'];
        $template->data['payment_country'] = $order_info['payment_country'];

        $template->data['shipping_company'] = $order_info['shipping_company'];
        $template->data['shipping_contact'] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'];
        $template->data['shipping_address_line_1'] = $order_info['shipping_address_1'];
        $template->data['shipping_address_line_2'] = $order_info['shipping_address_2'];
        $template->data['shipping_postcode'] = $order_info['shipping_postcode'];
        $template->data['shipping_city'] = $order_info['shipping_city'];
//        $template->data['shipping_zone'] = $order_info['shipping_zone'];
        $template->data['shipping_country'] = $order_info['shipping_country'];

        $template->data['text_customer_id'] = $language->get('text_customer_id');
        $template->data['text_date_order'] = $language->get('text_date_order');
        $template->data['text_date_invoice'] = $language->get('text_date_invoice');
        $template->data['text_date_shipping'] = $language->get('text_date_shipping');

        $template->data['customer_id'] = ($order_info['customer_id'] == '0') ? '' : $order_info['customer_id'];
        $template->data['date_order'] = ($order_info['date_order']=='0000-00-00 00:00:00') ? '' : date($language->get('date_format_short'), strtotime($order_info['date_order']));
        $template->data['date_invoice'] = ($order_info['date_invoice']=='0000-00-00 00:00:00') ? '' : date($language->get('date_format_short'), strtotime($order_info['date_invoice']));
        $template->data['date_shipping'] = ($order_info['date_shipping']=='0000-00-00 00:00:00') ? '' : date($language->get('date_format_short'), strtotime($order_info['date_shipping']));

        $template->data['text_payment_company_vat'] = $language->get('text_payment_company_vat');
        $template->data['text_order_id'] = $language->get('text_order_id');
        $template->data['text_invoice_id'] = $language->get('text_invoice_id');
        $template->data['text_packing_list_id'] = $language->get('text_packing_list_id');

        $template->data['payment_company_vat'] = $order_info['payment_company_vat'];
        $template->data['order_id'] = $order_info['order_id'];
        $template->data['invoice_id'] = ($order_info['invoice_id'] == '0') ? '' : $order_info['invoice_id'];
        $template->data['packing_list_id'] = ($order_info['packing_list_id'] == '0') ? '' : $order_info['packing_list_id'];

        $template->data['text_customer_supplier_id'] = $language->get('text_customer_supplier_id');
        $template->data['text_customer_order_id'] = $language->get('text_customer_order_id');
        $template->data['text_payment_method'] = $language->get('text_payment_method');
        $template->data['text_shipping_method'] = $language->get('text_shipping_method');

        $template->data['customer_supplier_id'] = '';
        $template->data['customer_order_id'] = $order_info['customer_order_id'];
        $template->data['payment_method'] = $payment_method['name'];
        $template->data['shipping_method'] = $shipping_method['name'];

        $template->data['text_order_status'] = $language->get('text_order_status');
        $template->data['text_date_payment'] = $language->get('text_date_payment');
        $template->data['text_shipping_trace_id'] = $language->get('text_shipping_trace_id');

        $template->data['order_status'] = $order_info['order_status'];
        $template->data['date_payment'] = ($order_info['date_payment']=='0000.00.00 00:00:00') ? '' : date($language->get('date_format_short'), strtotime($order_info['date_payment']));
        $template->data['shipping_trace_id'] = $order_info['shipping_trace_id'];


        $template->data['text_anvilex_headquarter'] = $language->get('text_anvilex_headquarter');
        $template->data['text_anvilex_address'] = $language->get('text_anvilex_address');
        $template->data['text_anvilex_contact'] = $language->get('text_anvilex_contact');
        $template->data['text_anvilex_charman'] = $language->get('text_anvilex_charman');
        $template->data['text_anvilex_register'] = $language->get('text_anvilex_register');
        $template->data['text_anvilex_tax_id'] = $language->get('text_anvilex_tax_id');
        $template->data['text_anvilex_vat_id'] = $language->get('text_anvilex_vat_id');

        $template->data['anvilex_headquarter'] = $this->config->get('shop_headquarter_company_name') . ', ' . $this->config->get('shop_headquarter_address') . ', ' . $this->config->get('shop_headquarter_city') . ', ' . $this->config->get('shop_headquarter_postcode') . ', ' . $this->config->get('shop_headquarter_country');
        $template->data['anvilex_address'] = $this->config->get('shop_post_address_company_name') . ', ' . $this->config->get('shop_post_address_address') . ', ' . $this->config->get('shop_post_address_city') . ', ' . $this->config->get('shop_post_address_postcode') . ', ' . $this->config->get('shop_post_address_country');
        $template->data['anvilex_contact'] = 'Phone: ' . $this->config->get('shop_contact_phone') . ', ' . 'Fax: ' . $this->config->get('shop_contact_fax') . ', ' . 'eMail: ' . $this->config->get('shop_contact_email') . ', ' . 'Web: ' . $this->config->get('shop_contact_internet');
        $template->data['anvilex_charman'] = $this->config->get('shop_charman');
        $template->data['anvilex_register'] = $this->config->get('shop_register_court');
        $template->data['anvilex_tax_id'] = $this->config->get('shop_tax_id');
        $template->data['anvilex_vat_id'] = $this->config->get('shop_vat_id');


        $html = $template->fetch('mail/status.tpl');

        $text = 'eMail body.';
        $subject = $order_info['store_name'] . ' : ' . $language->get('text_title_order_confirmation') . ' ' . $order_info['order_id'];

        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');
        $mail->setTo($order_info['email']);
        $mail->setFrom($this->config->get('shop_email'));
        $mail->setSender($order_info['store_name']);
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml($html);
        $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
        $mail->send();
      }

    }

  }

  //--------------------------------------------------------------------------
/*
  public function update($order_id, $order_status_id, $comment = '', $notify = false) {

    $order_info = $this->getOrder($order_id);

    if ($order_info && $order_info['order_status_id'])
    {

      // Fraud Detection
      if ($this->config->get('config_fraud_detection')) {
        $this->load->model('checkout/fraud');

        $risk_score = $this->model_checkout_fraud->getFraudScore($order_info);

        if ($risk_score > $this->config->get('config_fraud_score')) {
          $order_status_id = $this->config->get('config_fraud_status_id');
        }
      }

      // Ban IP
      $status = false;

      if ($order_info['customer_id'])
      {

        $results = $this->customer->getIps($order_info['customer_id']);

        foreach ($results as $result) {
          if ($this->customer->isBanIp($result['ip'])) {
            $status = true;

            break;
          }
        }
      }
      else
      {
        $status = $this->customer->isBanIp($order_info['ip']);
      }

      if ($status)
      {
        $order_status_id = $this->config->get('config_order_status_id');
      }

      $this->db->query("UPDATE `order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

      $this->db->query("INSERT INTO order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

      if ($notify)
      {

        $subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

        $message  = $language->get('text_update_order') . ' ' . $order_id . "\n";
        $message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

        $order_status_query = $this->db->query("SELECT * FROM order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

        if ($order_status_query->num_rows)
        {
          $message .= $language->get('text_update_order_status') . "\n\n";
          $message .= $order_status_query->row['name'] . "\n\n";
        }

        if ($order_info['customer_id']) {
          $message .= $language->get('text_update_link') . "\n";
          $message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
        }

        if ($comment) {
          $message .= $language->get('text_update_comment') . "\n\n";
          $message .= $comment . "\n\n";
        }
// ANVILEX
//        $message .= $language->get('text_update_footer');

        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');
        $mail->setTo($order_info['email']);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($order_info['store_name']);
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();
      }
    }
  }
*/

  //----------------------------------------------------------------------------
  // Log sales order create
  //----------------------------------------------------------------------------

  private function Log_Sales_Order_Create( $order_id )
  {

    // Compose SQL query
    $sql = "INSERT INTO order_history SET order_id=" . (int)$order_id . ", status='create', date_added=NOW()";

    // Query database
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Log sales order paid
  //----------------------------------------------------------------------------

  private function Log_Sales_Order_Paid( $order_id )
  {

    // Compose SQL query
    $sql = "INSERT INTO order_history SET order_id=" . (int)$order_id . ", status='paid', date_added=NOW()";

    // Query database
    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------

}
?>