<?php

class ControllerCartShow extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------
  // Show cart
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect($this->url->link('account/login', '', 'SSL'));

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load language
      $this->messages->Load($this->data, 'cart', 'show', 'index', $this->language->Get_Language_Code());

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle('catalog/view/stylesheet/cart.css');

      //  Set page sections
      $this->children = array(
        'common/footer',
        'common/header'
      );

      // Test for cart is empty
      if ($this->cart->Is_Empty() === true)
      {

        //------------------------------------------------------------------------
        // Shopping cart is empty
        //------------------------------------------------------------------------

        // Render page
//        $this->response->Set_HTTP_Output($this->Render('cart/empty.tpl'));

      }
      else
      {

        //------------------------------------------------------------------------
        // Shopping cart is not empty
        //------------------------------------------------------------------------

        // Get cart information
        $this->data['cart'] = $this->cart->Get_Cart_Information();

        //------------------------------------------------------------------------
        // Items
        //------------------------------------------------------------------------

        // Load data models
        $this->load->model('items/items');

        // Clear product list
        $this->data['products'] = array();

        // Get cart products
        $products = $this->cart->Get_Lines();

        // Iterate products in cart
        foreach ($products as $product) 
        {

          //----------------------------------------------------------------------
          // Item general information
          //----------------------------------------------------------------------

          // Set product information
          $product_data['product_guid'] = $product['guid'];
          $product_data['product_href'] = $this->url->link('items/info', 'guid=' . $product['guid']);
          $product_data['product_mpn'] = $product['mpn'];
          $product_data['product_description'] = 'Product description';

          //----------------------------------------------------------------------
          // Item manufactirer information
          //----------------------------------------------------------------------

          $product_data['product_manufacturer_href'] = $this->url->link('manufacturers/info', 'manufacturer_id=' . (int)$product['manufacturer_id']);
          $product_data['product_manufacturer_name'] = $product['manufacturer_name'];

          //----------------------------------------------------------------------
          // Item image
          //----------------------------------------------------------------------

          // Get item images
          $item_images = $this->model_items_images->Get_Item_Images( $product[ 'guid' ] );
          
          // Create main image object
          $main_image = new Image();
          $main_image->Create_From_String( $item_images[ 0 ][ 'data' ] );

          // Resize main image
          $main_image->resize( 300, 300, 'w' );

          // Get main image information
          $main_image_info = $main_image->Get_Info();
/*
          // Set main image data
          $this->data[ 'item' ][ 'main_image' ] = array(

            'image_type' => $main_image_info[ 'mime' ],
            'image_data' => $main_image->Get_Encoded()
          );
*/

          // Set image data
          $product_data[ 'product_image_name' ] = $product[ 'mpn' ];
//          $product_data[ 'product_image_link' ] = ( $prodict_image[ 'valid' ] === false) ? '' : 'data:' . $prodict_image['type'] . ';base64, ' . base64_encode($prodict_image['data']);
          $product_data[ 'product_image_link' ] = ( $prodict_image[ 'valid' ] === false) ? '' : 'data:' . $main_image_info[ 'mime' ] . ';base64, ' . $main_image->Get_Encoded() );

          // Destroy main image object
          unset( $main_image );
 
          //----------------------------------------------------------------------
          // Item price information
          //----------------------------------------------------------------------

          // Get actual price information
//        $product_price = $this->model_items_items->getProductPrice( $product[ 'product_id' ], 1 );

          $product_data['product_cart_quantity'] = number_format($product['quantity'], 0);
          $product_data['product_cart_price'] = number_format($product['price'], 4);
          $product_data['product_cart_net'] = number_format($product['net'], 2);
          $product_data['product_cart_vat_rate'] = number_format($product['vat_rate'], 2) . '%';
          $product_data['product_cart_vat'] = number_format($product['vat'], 2);
          $product_data['product_cart_total'] = number_format($product['total'], 2);
          $product_data['product_cart_currency'] = ' EUR';
          $product_data[ 'product_stock_quantity' ] = $this->warehouse->Get_Item_Stocked_Quantity( $product[ 'item_guid' ] )['quantity'];
          //----------------------------------------------------------------------
          // Item stock information
          //----------------------------------------------------------------------
          /*
                  // Get actual stock information
                  $product_stock_information = $this->warehouse->Get_Item_Stocked_Quantity( $product[ 'item_guid' ] );


                  $product_data[ 'product_stock_quantity' ] = $product_stock_information[ 'quantity' ];
                  $product_data[ 'product_availability' ] = $product_stock_information[ 'available' ] . ' - ' . $product_stock_information[ 'quantity' ];
          */
          //----------------------------------------------------------------------
          // Buttons
          //----------------------------------------------------------------------

          $product_data['button_remove_product_href'] = $this->url->link('cart/show/remove', 'guid=' . $product['guid'], 'SSL');

          // Add procuct data
          $this->data['products'][] = $product_data;

        }

        //------------------------------------------------------------------------

        $this->data['countries'] = $this->location->Get_Countries($this->language->Get_Language_Code());
        $this->data['zones'] = $this->location->Get_Zones($this->language->Get_Language_Code());

//! @todo ANVILEX KM: That is this
//        $this->data['entry_country'] = $this->language->get('entry_country');
//        $this->data['entry_zone'] = $this->language->get('entry_zone');

        //------------------------------------------------------------------------
        // Payment and delivery addresses
        //------------------------------------------------------------------------

        if ($this->customer->Is_Logged() === true)
        {

          //------------------------------------------------------------------------
          // Customer logged
          //------------------------------------------------------------------------

          // Load data model
          $this->load->model('address/address');

          $this->data['customer_logged'] = true;

          //! @todo ANVILEX KM: ???
          $this->data['country_id'] = 0;
          $this->data['zone_id'] = 0;

          // Get addresses linked to customer
          $addresses = $this->model_address_address->Get_Addresses($this->customer->Get_GUID());
          
          // Iterate over all adresses
          foreach ($addresses as $result)
          {

            // Compose address
            $generic_address = array(
              'guid' => $result['guid'],
              'address_href' => $this->url->link('account/address_form', 'guid=' . (int)$result['guid']),
              'country_id' => $this->location->Get_Country_Info($result['country_id'])['name'],
              'zone_id' => $this->location->Get_Country_Zone_Info($result['zone_id'])['name'],
              'postcode' => $result['postcode'],
              'city' => $result['city'],
              'street' => $result['street'],
              'house' => $result['house'],
              'building' => $result['building'],
              'apartment' => $result['apartment'],
              'address_name' => $result['street'] . ' ' . $result['house'] . ' ' . $result['building'] . ' ' . $result['apartment'] . ', ' . $result['postcode'],
            );

            // Add payment address
            $this->data['payment_addresses'][] = $generic_address;

            // Add delivery address
            $this->data['delivery_addresses'][] = $generic_address;

          }

        }
        else
        {

          //------------------------------------------------------------------------
          // Customer not logged
          //------------------------------------------------------------------------

          $this->data['customer_logged'] = false;

        }

        //------------------------------------------------------------------------
        // Payment methods
        //------------------------------------------------------------------------

        // Get payments methods
        $this->data['payment_methods'] = $this->payment->Get_Methods($this->language->Get_Language_Code(), 1);

        //------------------------------------------------------------------------
        // Delivery methods
        //------------------------------------------------------------------------

        // Get delivery methods
        $this->data['delivery_methods'] = $this->delivery->Get_Sutable_Methods($this->language->Get_Language_Code(), $this->location->Get_Country_Code(), '', 0);

        //------------------------------------------------------------------------
        // Set order totals
        //------------------------------------------------------------------------

        $cart_totals = $this->cart->Get_Totals();

        $this->data['cart_net'] = number_format($cart_totals['net'], 2);
        $this->data['cart_vat'] = number_format($cart_totals['vat'], 2);
        $this->data['cart_total'] = number_format($cart_totals['total'], 2);

        //------------------------------------------------------------------------

        // Set checkout button link
//      $this->data[ 'cart_show_checkout_button_caption' ] = $this->language->get( 'cart_show_checkout_button_caption' );
//      $this->data[ 'cart_show_checkout_button_href' ] = $this->url->link( 'checkout/payment_address' );

      }
    }

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------

  private function dataVerification()
  {

    // Load language
    $this->messages->Load($this->data, 'cart', 'show', 'dataVerification', $this->language->Get_Language_Code());

    $cart = $this->cart->Get_Cart_Information();

    // Get parameters
    $req_cus = $this->request->Post_Parameter_Is_Mail('customer_email');

    // Get parameters
    $req_rec = $this->request->Post_Parameter_Is_Mail('recipient_email');

    // Set error code
    if (!$req_cus['check'] && $req_cus['response'] != 'empty_email_error') {
      $this->error['customer_email'] = $this->data['cart_show_' . $req_cus['response']];
    }

    // Set error code
    if (!$req_rec['check'] && $req_rec['response'] != 'empty_email_error') {
      $this->error['recipient_email'] = $this->data['cart_show_' . $req_rec['response']];
    }

/*
    if ($this->customer->Is_Logged() !== true)
    {
      if ($this->request->post['customer_country'] == '0') {
        $this->error['customer_country'] = $this->data['cart_show_empty_customer_country_error'];
      }
      if ($this->request->post['customer_zone'] == '0') {
        $this->error['customer_zone'] = $this->data['cart_show_empty_customer_zone_error'];
      }
      if ($this->request->post['customer_postcode'] === '') {
        $this->error['customer_postcode'] = $this->data['cart_show_empty_customer_postcode_error'];
      }
      if ($this->request->post['customer_city'] === '') {
        $this->error['customer_city'] = $this->data['cart_show_empty_customer_city_error'];
      }
      if ($this->request->post['customer_street'] === '') {
        $this->error['customer_street'] = $this->data['cart_show_empty_customer_street_error'];
      }
      if ($this->request->post['customer_house_number'] === '') {
        $this->error['customer_house_number'] = $this->data['cart_show_empty_customer_house_number_error'];
      }

      if ($this->request->post['recipient_country'] == '0') {
        $this->error['recipient_country'] = $this->data['cart_show_empty_recipient_country_error'];
      }
      if ($this->request->post['recipient_zone'] == '0') {
        $this->error['recipient_zone'] = $this->data['cart_show_empty_recipient_zone_error'];
      }
      if ($this->request->post['recipient_postcode'] === '') {
        $this->error['recipient_postcode'] = $this->data['cart_show_empty_recipient_postcode_error'];
      }
      if ($this->request->post['recipient_city'] === '') {
        $this->error['recipient_city'] = $this->data['cart_show_empty_recipient_city_error'];
      }
      if ($this->request->post['recipient_street'] === '') {
        $this->error['recipient_street'] = $this->data['cart_show_empty_recipient_street_error'];
      }
      if ($this->request->post['recipient_house_number'] === '') {
        $this->error['recipient_house_number'] = $this->data['cart_show_empty_recipient_house_number_error'];
      }
    }
    else
    {
*/

//    }

    return $this->error;

  }

  //----------------------------------------------------------------------------
  // Cart checkout
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add_Order()
  {

    // Init json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json['error'] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load language
      $this->messages->Load($this->data, 'cart', 'show', 'dataVerification', $this->language->Get_Language_Code());

      $data_valid = true;

      $error = array();

      // Get cart data
      $cart_data = $this->cart->Get_Cart_Information();

      //------------------------------------------------------------------------

      //------------------------------------------------------------------------
      //
      //------------------------------------------------------------------------

      if ($this->request->post['customer_lastname'] === '')
      {

        $data_valid = false;

        // Set error code
        $error['customer_lastname'] = $this->data['cart_show_empty_customer_lastname_error'];
      }

      //------------------------------------------------------------------------
      //
      //------------------------------------------------------------------------

      if ($this->request->post['customer_firstname'] === '')
      {

        $data_valid = false;

        // Set error code
        $error['customer_firstname'] = $this->data['cart_show_empty_customer_firstname_error'];
      }

      //------------------------------------------------------------------------
      //
      //------------------------------------------------------------------------

      if ($this->request->post['recipient_lastname'] === '')
      {

        $data_valid = false;

        // Set error code
        $error['recipient_lastname'] = $this->data['cart_show_empty_recipient_lastname_error'];
      }

      //------------------------------------------------------------------------
      //
      //------------------------------------------------------------------------

      if ($this->request->post['recipient_firstname'] === '')
      {

        $data_valid = false;

        // Set error code
        $error['recipient_firstname'] = $this->data['cart_show_empty_recipient_firstname_error'];
      }

      //------------------------------------------------------------------------
      // Payment address
      //------------------------------------------------------------------------

      if ($cart_data['payment_address_guid'] == '00000000000000000000000000000000')
      {

        $data_valid = false;

        // Set error code
        $error['payment_address_guid'] = $this->data['cart_show_payment_address_guid_error'];

      }

      //------------------------------------------------------------------------
      // Delivery address
      //------------------------------------------------------------------------

      if ($cart_data['delivery_address_guid'] == '00000000000000000000000000000000')
      {

        $data_valid = false;

        // Set error code
        $error['delivery_address_guid'] = $this->data['cart_show_delivery_address_guid_error'];

      }

      //------------------------------------------------------------------------
      // Delivery method
      //------------------------------------------------------------------------

      if ($cart_data['delivery_method_id'] == '0')
      {

        $data_valid = false;

        // Set error code
        $error['delivery_method_id'] = $this->data['cart_show_delivery_method_id_error'];

      }

      //------------------------------------------------------------------------
      // Payment method
      //------------------------------------------------------------------------

      if ($cart_data['payment_method_id'] == '0')
      {

        $data_valid = false;

        // Set error code
        $error['payment_method_id'] = $this->data['cart_show_payment_method_id_error'];

      }

      //------------------------------------------------------------------------
      // Terms aggrement
      //------------------------------------------------------------------------

      // Set error code
      if ($this->request->post['agreement_information_data'] === 'false')
      {

        $data_valid = false;

        // Set error code
        $error['agreement_information_data'] = $this->data['cart_show_not_agree_information_data_error'];

      }

      //------------------------------------------------------------------------
      // Personal data aggrement
      //------------------------------------------------------------------------

      // Set error code
      if ($this->request->post['agreement_personal_data'] === 'false')
      {

        $data_valid = false;

        // Set error code
        $error['agreement_personal_data'] = $this->data['cart_show_not_agree_personal_data_error'];

      }

      //------------------------------------------------------------------------

      // Test for data invalid
      if ( $data_valid === false )
      {

        //----------------------------------------------------------------------
        // Data invalid
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;
        $json[ 'redirect_url' ] = '';
        $json[ 'error' ] = $error;

      }
      else
      {

        //----------------------------------------------------------------------
        // Data valid, create order
        //----------------------------------------------------------------------

        // Load data model
        $this->load->model('address/address');

        // Get payment address
        $payment_address_data = $this->model_address_address->Get_Address($cart_data['payment_address_guid']);

        // Get delivery address
        $delivery_address_data = $this->model_address_address->Get_Address($cart_data['delivery_address_guid']);


        // Load data model
        $this->load->model('account/orders');

        // Create new order
        $order_id = $this->model_account_orders->Add_Order( $this->request->post, $cart_data,$payment_address_data, $delivery_address_data );

        // Get cart lines
        $lines = $this->cart->Get_Lines();

        foreach ( $lines as $line )
        {

          // Load data model
          $this->load->model('items/items');

          $item_description = $this->model_items_items->Get_Description( $line[ 'guid' ], $this->language->Get_Language_Code() );
          
          $line_data = array(
            'order_id' => $order_id,
            'guid' => $line[ 'guid' ],
            'mpn' => $line['mpn'],
            'description'    => $item_description[ 'description' ],
            'quantity'    => $line['quantity'],
            'price'    => $line['price'],
            'net'    => $line['net'],
            'vat_rate'     => $line['vat_rate'],
            'vat'     => $line['vat'],
            'total'     => $line['total'],
          );

          $this->model_account_orders->Add_Order_Line($line_data);

        }
        $this->session->data['order_success'] = 'success';
        // Clear cart
        $this->cart->Clear();

        // Set success code
        $json[ 'return_code' ] = true;
        $json[ 'redirect_url' ] = $this->url->link('order/order_success', '', 'SSL');
        $json[ 'error' ] = array();

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Set item quantity
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_item_quantity()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json['error'] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameter present
      if (
        ($this->request->Is_POST_Parameter_Exists('guid') === false) ||
        ($this->request->Is_POST_Parameter_Exists('quantity') === false)
      ) {

        //------------------------------------------------------------------------
        // ERROR: Parameter not present
        //------------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;

      } else {

        //------------------------------------------------------------------------
        // Parameter present
        //------------------------------------------------------------------------

        // Get parameters
        $item_guid = $this->request->Get_POST_Parameter_As_String('guid');
        $item_quantity = $this->request->Get_POST_Parameter_As_Integer('quantity');
        // Test for quantity is set to 0
        if ($item_quantity <= 0) {

          //----------------------------------------------------------------------
          // Item quantity is zero, remove cart line
          //----------------------------------------------------------------------

          // Remove cart line
          $this->cart->Remove_Line($item_guid);

        } else {

          //----------------------------------------------------------------------
          // Item quantity is not zero, update cart line
          //----------------------------------------------------------------------

          $unit_price = 10.0;
          $vat_rate = 0.19;
          $warehouse_quantity = $this->warehouse->Get_Item_Stocked_Quantity($item_guid)[ 'quantity' ] ;
          if($item_quantity > $warehouse_quantity){
            $item_quantity = $warehouse_quantity;
          }
          // Update cart line
          $this->cart->Update_Line($item_guid, $item_quantity, $unit_price, $vat_rate);
        }

        // Get cart line information
        $json['line'] = $this->cart->Get_Line_Totals($item_guid);

        // Get cart totals
        $json['cart'] = $this->cart->Get_Totals();
        $json['line_quantity'] = $this->cart->Get_Lines_Count();
        // Set success code
        $json['return_code'] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Remove product from the cart
  //----------------------------------------------------------------------------
  // Caller: AJAX ???
  //----------------------------------------------------------------------------
  //! @todo ANVILEX KM: Rework this method using AJAX Call

  public function remove()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json[ 'error' ] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test parameter
      if ($this->request->Is_POST_Parameter_Exists('guid') === false) {

        //------------------------------------------------------------------------
        // Item GUID not set, nothing to do
        //------------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;
        $json[ 'redirect_url' ] = '';
        $json[ 'error' ] = array();

      } else {

        //------------------------------------------------------------------------
        // Item GUID parameter set
        //------------------------------------------------------------------------

        // ANVILEX KM: Test for GUID valid

        // Get product guid
        $item_guid = $this->request->Get_POST_Parameter_As_String('guid');

        // Remove item from cart
        $this->cart->Remove($item_guid);

        // Set success code
        $json[ 'return_code' ] = true;
        $json[ 'redirect_url' ] = '';
        $json[ 'error' ] = array();

        // Redirect
//        $this->response->Redirect($this->url->link('cart/show'));

      }

    }

    // Render page
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Set payment address
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_payment_address()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json['error'] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('guid') === false) {

        //------------------------------------------------------------------------
        // ERROR: Payment address identifier not found
        //------------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;
        $json[ 'redirect_url' ] = '';
        $json['error'] = array();

      } else {

        //------------------------------------------------------------------------
        // Payment address identifier found
        //------------------------------------------------------------------------

        // Test for parameter numeric
        if ($this->request->Is_POST_Parameter_GUID('guid') === false) {

          //----------------------------------------------------------------------
          // ERROR: Parameter not numeric
          //----------------------------------------------------------------------

          // Set error code
          $json['return_code'] = false;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        } else {

          //----------------------------------------------------------------------
          // Parameter exists and numeric
          //----------------------------------------------------------------------

          // Get payment address identifier
          $payment_address_guid = $this->request->Get_POST_Parameter_As_String('guid');

          // Set payment address identifier
          $this->cart->Set_Payment_Address( $this->customer->Get_GUID(), $payment_address_guid );

          // Set success code
          $json['return_code'] = true;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        }

      }

    }

    // Encode response
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Set delivery address
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_delivery_address()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json['error'] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('guid') === false) {

        //------------------------------------------------------------------------
        // ERROR: Delivery address identifier not found
        //------------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;
        $json[ 'redirect_url' ] = '';
        $json['error'] = array();

      } else {

        //------------------------------------------------------------------------
        // Delivery address identifier found
        //------------------------------------------------------------------------

        // Test for parameter numeric
        if ($this->request->Is_POST_Parameter_GUID('guid') === false) {

          //----------------------------------------------------------------------
          // ERROR: Parameter not numeric
          //----------------------------------------------------------------------

          // Set error code
          $json['return_code'] = false;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        } else {

          //----------------------------------------------------------------------
          // Parameter exists and numeric
          //----------------------------------------------------------------------

          // Get delivery address identifier
          $delivery_address_guid = $this->request->Get_POST_Parameter_As_String('guid');

          // Set delivery address identifier
          $this->cart->Set_Delivery_Address( $this->customer->Get_GUID(), $delivery_address_guid );

          // Set success code
          $json['return_code'] = true;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        }

      }

    }

    // Encode response
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Set delivery method
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_delivery_method()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json['error'] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('id') === false) {

        //------------------------------------------------------------------------
        // ERROR: Delivery method identifier not found
        //------------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;
        $json[ 'redirect_url' ] = '';
        $json['error'] = array();

      } else {

        //------------------------------------------------------------------------
        // Delivery method identifier found
        //------------------------------------------------------------------------

        // Test for parameter numeric
        if ($this->request->Is_POST_Parameter_Positive_Integer('id') === false) {

          //----------------------------------------------------------------------
          // ERROR: Parameter not numeric
          //----------------------------------------------------------------------

          // Set error code
          $json['return_code'] = false;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        } else {

          //----------------------------------------------------------------------
          // Parameter exists and numeric
          //----------------------------------------------------------------------

          // Get delivery method identifier
          $delivery_method_id = $this->request->Get_POST_Parameter_As_Integer('id');

          // Set delivery method
          $this->cart->Set_Delivery_Method($delivery_method_id);

          // Set success code
          $json['return_code'] = true;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        }

      }

    }

    // Encode response
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Set payment method
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_payment_method()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json['error'] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('id') === false) {

        //------------------------------------------------------------------------
        // ERROR: Payment method identifier not found
        //------------------------------------------------------------------------

        // Set error code
        $json['error'] = true;
        $json[ 'redirect_url' ] = '';
        $json['error'] = array();

      } else {

        //------------------------------------------------------------------------
        // Payment method identifier found
        //------------------------------------------------------------------------

        // Test for parameter numeric
        if ($this->request->Is_POST_Parameter_Positive_Integer('id') === false) {

          //----------------------------------------------------------------------
          // ERROR: Parameter not numeric
          //----------------------------------------------------------------------

          // Set error code
          $json['error'] = true;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        } else {

          //----------------------------------------------------------------------
          // Parameter exists and numeric
          //----------------------------------------------------------------------

          // Get payment method identifier
          $payment_method_id = $this->request->Get_POST_Parameter_As_Integer('id');

          // Set payment method
          $this->cart->Set_Payment_Method($payment_method_id);

          // Clear error code
          $json['error'] = false;
          $json[ 'redirect_url' ] = '';
          $json['error'] = array();

        }

      }

    }

    // Set response
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Set comment
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_comment()
  {

    // Init json data
    $json = array();

    // Test for customer logged
    if ($this->customer->Is_Logged() === false)
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $json[ 'return_code' ] = false;
      $json[ 'redirect_url' ] = $this->url->link('account/login', '', 'SSL');
      $json['error'] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameter present
      if ($this->request->Is_POST_Parameter_Exists('comment') === false) {

        //------------------------------------------------------------------------
        // ERROR: Parameter not set
        //------------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;
        $json[ 'redirect_url' ] = '';
        $json['error'] = array();

      } else {

        //------------------------------------------------------------------------
        // Parameter set
        //------------------------------------------------------------------------

        // Get comment
        $comment = $this->request->Get_POST_Parameter_As_String('comment');

        // Set comment
        $this->cart->set_comment($comment);

        // Set success code
        $json['return_code'] = true;
        $json[ 'redirect_url' ] = '';
        $json['error'] = array();

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function country()
  {

    $json = array();

    $country_info = $this->location->Get_Country_Info($this->request->get['country_id']);

    if ($country_info) {

      // ANVILEX KM: Load this model not needed
      $this->load->model('localisation/zone');

      $json = array(
        'country_id' => $country_info['country_id'],
        'name' => $country_info['name'],
        'iso_code_2' => $country_info['iso_code_2'],
        'iso_code_3' => $country_info['iso_code_3'],
        'address_format' => $country_info['address_format'],
        'postcode_required' => $country_info['postcode_required'],
        'zone' => $this->location->Get_Country_Zones($this->request->get['country_id']),
        'status' => $country_info['status']
      );

    }

    $json['html_id'] = $this->request->get['html_id'];

    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_zones()
  {

    $json = array();

    $json['zone'] = $this->location->Get_Zones();

    $json['html_id'] = $this->request->get['html_id'];

    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function set_country_by_zone()
  {

    $json = array();

    $zone_info = $this->location->Get_Country_Zone_Info($this->request->get['zone_id']);

    $this->load->model('localisation/zone');

    $json['country_id'] = $zone_info['country_id'];

    $json['html_id'] = $this->request->get['html_id'];

    $this->response->Set_Json_Output($json);

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>