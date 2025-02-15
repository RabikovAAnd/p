<?php

class ControllerWorkplaceCustomersInteractionsOfferCreate extends Controller
{

  private $error = array();

  public function index()
  {
    // Test for customer GUID present and valid
    if ($this->request->Is_GET_Parameter_GUID('guid') === false) {

      //----------------------------------------------------------------------
      // ERROR: Invalud customer GUID
      //----------------------------------------------------------------------

      // Redirect to error page
      $this->response->Redirect($this->url->link('workplace/customers/error', '', 'SSL'));

    } else {
      // Load language
      $this->messages->Load($this->data, 'workplace', 'customers_interactions_offer_add', 'index', $this->language->Get_Language_Code());

      // Load data models
      $this->load->model('address/address');

      $customer_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Get addresses linked to customer
      $addresses = $this->model_address_address->Get_Addresses($customer_guid);

      // Iterate over all adresses
      foreach ($addresses as $result) {

        // Compose address
        $generic_address = array(
          'guid' => $result['guid'],
          'address_href' => $this->url->link('account/address_form', 'guid=' . (int) $result['guid']),
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
      }

      // Get addresses linked to customer
      $addresses = $this->model_address_address->Get_Addresses($customer_guid);

      // Iterate over all adresses
      foreach ($addresses as $result)
      {

        // Compose address
        $generic_address = array(
          'guid' => $result['guid'],
          'address_href' => $this->url->link('account/address_form', 'guid=' . (int) $result['guid']),
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

        // Add delivery address
        $this->data['delivery_addresses'][] = $generic_address;

      }


      // Get currencies linked to customer
      $currencies = $this->currency->Get_Currencies();

      foreach ($currencies as $currency)
      {

        $currency_description = $this->currency->Get_Currency_Description($currency['code'], $this->language->Get_Language_Code());

        if( $currency_description['return_code'] == true)
        {

          // Compose currencies
          $this->data['currencies'][] = array(
            'code' => $currency['code'],
            'name' => $currency_description['name'],

          );

        }

      }

        // Set links
        $this->data['create_button_href'] = $this->url->link('workplace/customers/interactions/offer/create/Create', 'customer_guid=' . $customer_guid, 'SSL');

        //------------------------------------------------------------------------
        // Set page data
        //------------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle($this->messages->Get_Message('document_title_text'));
        $this->response->setDescription($this->messages->Get_Message('document_description_text'));
        $this->response->setKeywords('');
        $this->response->setRobots('index, follow');

        //  Set page sections
        $this->children = array(
          'common/footer',
          'workplace/menu',
          'common/header'
        );
      
    }
  }

  //----------------------------------------------------------------------------
  // Create new offer
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Create()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'customers_interactions_offer_add', 'Create', $this->language->Get_Language_Code());

    // Load data models
    $this->load->model('orders/orders');
    $this->load->model('address/address');

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Number
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_Exists('extern_number') === false) {

      //----------------------------------------------------------------------
      // ERROR: Number not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['extern_number'] = $this->data['workplace_customers_interactions_offer_add_' . 'extern_number' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } else {

      if($this->request->Is_POST_Parameter_Certain_Size_String( 'extern_number', 0, $this->model_orders_orders->Get_Order_Extern_Number_Maximum_String_Size() ) === false )
      {
      
        //------------------------------------------------------------------------
        // ERROR: Number not valid
        //------------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'extern_number' ] = $this->data[ 'workplace_customers_interactions_offer_add_' . 'extern_number' . '_error' ];
      }
      else
      {
        //------------------------------------------------------------------------
        // Number parameter found
        //------------------------------------------------------------------------

        // Set extern PO number
        $data[ 'extern_number' ] = trim( $this->request->Get_POST_Parameter_As_String( 'extern_number' ) );
      }

    }


    //------------------------------------------------------------------------
    // Currency code
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_Exists('currency') === false) {

      //----------------------------------------------------------------------
      // ERROR: Currency code not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['currency'] =$this->data['workplace_customers_interactions_offer_add_' . 'currency' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } else {

      //----------------------------------------------------------------------
      // Currency code parameter found
      //----------------------------------------------------------------------

      $currency_data = $this->currency->Get_Currency(trim($this->request->Get_POST_Parameter_As_String('currency')), $this->language->Get_Language_Code());

      // Test for parameter valid
      if ( $currency_data['valid'] === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Currency code not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['currency'] = $this->data['workplace_customers_interactions_offer_add_' . 'currency' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Currency code parameter found and valid
        //----------------------------------------------------------------------
        $data['customer_currency'] = trim($this->request->Get_POST_Parameter_As_String('currency'));
      }
    }

    //------------------------------------------------------------------------
    // Customer GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_GET_Parameter_GUID('customer_guid') === false) {

      //----------------------------------------------------------------------
      // ERROR: Customer GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['customer_guid'] = $this->data['workplace_customers_interactions_offer_add_' . 'customer_guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } else {

      //----------------------------------------------------------------------
      // Customer parameter found
      //----------------------------------------------------------------------

      $data['customer'] = $this->customer->Get_Contact_Information(trim($this->request->Get_GET_Parameter_As_GUID('customer_guid')));
      
    
      // Test for parameter valid
      if ( $data['customer']['valid'] === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Customer not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['customer_guid'] = $this->data['workplace_customers_interactions_offer_add_' . 'customer_guid' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Customer GUID parameter found and valid
        //----------------------------------------------------------------------

      }
    }

    //------------------------------------------------------------------------
    // Payment address GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_GUID('payment_address') === false) 
    {

      //----------------------------------------------------------------------
      // ERROR: Payment address GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['payment_address'] = $this->data['workplace_customers_interactions_offer_add_' . 'payment_address' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      $data['payment_address'] = $this->model_address_address->Get_Address(trim($this->request->Get_POST_Parameter_As_GUID('payment_address')));

      // Test for parameter valid
      if ( $data['payment_address']['valid'] === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Payment address GUID not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['payment_address'] = $this->data['workplace_customers_interactions_offer_add_' . 'payment_address' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Payment address GUID parameter found and valid
        //----------------------------------------------------------------------

      }

    }

    //------------------------------------------------------------------------
    // Delivery address GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_GUID('delivery_address') === false) {

      //----------------------------------------------------------------------
      // ERROR: Delivery address GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['delivery_address'] = $this->data['workplace_customers_interactions_offer_add_' . 'delivery_address' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    } else {

      $data['delivery_address'] = $this->model_address_address->Get_Address(trim($this->request->Get_POST_Parameter_As_GUID('delivery_address')));
      
      // Test for parameter valid
      if ($data['delivery_address']['valid'] === false) {
        //----------------------------------------------------------------------
        // ERROR: Delivery address GUID not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['delivery_address'] = $this->data['workplace_customers_interactions_offer_add_' . 'delivery_address' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      } else {
        //----------------------------------------------------------------------
        // Delivery address GUID parameter found and valid
        //----------------------------------------------------------------------

      }

    }

    //------------------------------------------------------------------------
    // Comment
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_Exists('comment') === false) {

      //----------------------------------------------------------------------
      // ERROR: Comment not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['comment'] = $this->data['workplace_customers_interactions_offer_add_' . 'comment' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {
      if($this->request->Is_POST_Parameter_Certain_Size_String( 'comment', 0, $this->model_orders_orders->Get_Order_Comment_Maximum_String_Size() ) === false )
      {
      
        //------------------------------------------------------------------------
        // ERROR: Comment not valid
        //------------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'comment' ] = $this->data[ 'workplace_customers_interactions_offer_add_' . 'comment' . '_error' ];
      }
      else
      {
        //------------------------------------------------------------------------
        // Comment parameter found
        //------------------------------------------------------------------------

        // Store order comment
        $data[ 'comment' ] = trim( $this->request->Get_POST_Parameter_As_String( 'comment' ) );
      }
      
    }



    //------------------------------------------------------------------------
    // Process data
    //------------------------------------------------------------------------

    // Is request data valid
    if ($request_data_valid === false) {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else {

      //--------------------------------------------------------------------
      // Parameters present and valid
      //--------------------------------------------------------------------

      // Generate order GUID
      $guid = UUID_V4_T1();
      

      $data['supplier'] = $this->customer->Get_Contact_Information(trim('787BC0170B204EC485BD5B3491AB43AE'));

      $data['type'] = 'sell';

      // Create new order
      $this->model_orders_orders->Create_Order($guid, $data, $this->language->Get_Language_Code());

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/customers/info', 'guid=' . $data['customer']['guid'], 'SSL');

      // Set success code
      $json['return_code'] = true;

    }

    //    }

    // Encode and send json data
    $this->response->Set_Json_Output($json);

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>