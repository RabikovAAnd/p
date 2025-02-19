<?php

class ControllerWorkplaceCustomersInteractionsRequestCreate extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------
  // Caller: HTTP
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load language
    $this->messages->Load( $this->data, 'workplace', 'customers_interactions_request_add', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'address/address' );

    // Test for supplier GUID present and valid
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalud customer GUID
      //------------------------------------------------------------------------

      // Redirect to error page
      $this->response->Redirect( $this->url->link( 'workplace/customers/error', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer GUID valid
      //------------------------------------------------------------------------

      // Get supplier GUID, request will be send to this customer.
      $supplier_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Test for supplier and purchaser is the same
      if ( $supplier_guid == '787BC0170B204EC485BD5B3491AB43AE' )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Supplier and purchaser is the same
        //----------------------------------------------------------------------

        // Redirect to error page
        $this->response->Redirect( $this->url->link( 'workplace/customers/error', '', 'SSL' ) );
      
      }
      else
      {
        
        // Get payment addresses linked to customer
        $addresses = $this->model_address_address->Get_Addresses( '787BC0170B204EC485BD5B3491AB43AE' );

        // Iterate over all adresses
        foreach ( $addresses as $result )
        {

          // Compose address
          $payment_address = array(
            'guid' => $result[ 'guid' ],
            'address_href' => $this->url->link( 'account/address_form', 'guid=' . $result[ 'guid' ] ),
            'country_id' => $this->location->Get_Country_Info( $result[ 'country_id' ] )[ 'name' ],
            'zone_id' => $this->location->Get_Country_Zone_Info( $result[ 'zone_id' ] )[ 'name' ],
            'postcode' => $result[ 'postcode' ],
            'city' => $result[ 'city' ],
            'street' => $result[ 'street' ],
            'house' => $result[ 'house' ],
            'building' => $result[ 'building' ],
            'apartment' => $result[ 'apartment' ],
            'address_name' => $result[ 'street' ] . ' ' . $result[ 'house' ] . ' ' . $result[ 'building' ] . ', ' . $result[ 'apartment' ] . ', ' . $result[ 'postcode' ] . ' ' . $result[ 'city' ]
          );

          // Add payment address
          $this->data[ 'payment_addresses' ][] = $payment_address;

        }

        // Get delivery addresses linked to customer
        $addresses = $this->model_address_address->Get_Addresses( '787BC0170B204EC485BD5B3491AB43AE' );

        // Iterate over all adresses
        foreach ( $addresses as $result )
        {

          // Compose delivery address
          $delivery_address = array(
            'guid' => $result[ 'guid' ],
            'address_href' => $this->url->link( 'account/address_form', 'guid=' . $result[ 'guid' ] ),
            'country_id' => $this->location->Get_Country_Info( $result[ 'country_id' ] )[ 'name' ],
            'zone_id' => $this->location->Get_Country_Zone_Info( $result[ 'zone_id' ] )[ 'name' ],
            'postcode' => $result[ 'postcode' ],
            'city' => $result[ 'city' ],
            'street' => $result[ 'street' ],
            'house' => $result[ 'house' ],
            'building' => $result[ 'building' ],
            'apartment' => $result[ 'apartment' ],
            'address_name' => $result[ 'street' ] . ' ' . $result[ 'house' ] . ' ' . $result[ 'building' ] . ', ' . $result[ 'apartment' ] . ', ' . $result[ 'postcode' ] . ' ' . $result[ 'city' ]
          );

          // Add delivery address
          $this->data[ 'delivery_addresses' ][] = $delivery_address;

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
// ANVILEX KM: Remove after the test
//        $this->data[ 'create_button_href' ] = $this->url->link( 'workplace/customers/interactions/request/create/Create', 'supplier_guid=' . '787BC0170B204EC485BD5B3491AB43AE', 'SSL' );
        $this->data[ 'create_button_href' ] = $this->url->link( 'workplace/customers/interactions/request/create/Create', 'supplier_guid=' . $supplier_guid, 'SSL' );

        //----------------------------------------------------------------------
        // Set page data
        //----------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
        $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
        $this->response->setRobots( 'index, follow' );

        // Set page sections
        $this->children = array(
          'common/footer',
          'workplace/menu',
          'common/header'
        );
      
      }

    }

  }

  //----------------------------------------------------------------------------
  // Create new request
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Create()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_interactions_request_add', 'Create', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'orders/orders' );
    $this->load->model( 'address/address' );

    // Init json data
    $json = array();

    // Init customer data
    $data = array();

    // Clear request data valid status
    $request_data_valid = true;

    //--------------------------------------------------------------------------
    // Supplier GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'supplier_guid' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Supplier GUID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'supplier_guid' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'supplier_guid' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Supplier GUID parameter found
      //------------------------------------------------------------------------

      // Get supplier GUID
      $supplier_guid = $this->request->Get_GET_Parameter_As_GUID( 'supplier_guid' );

      // Test for supplier and purchasser the same
      if ( $supplier_guid == '787BC0170B204EC485BD5B3491AB43AE' )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Request error, supplier and purchasser the same
        //----------------------------------------------------------------------

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Supplier and purchasser is different
        //----------------------------------------------------------------------
        
        // Get supplier information
        $supplier = $this->customer->Get_Contact_Information( $supplier_guid );

        // Test for parameter valid
        if ( $supplier[ 'valid' ] === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Supplier not valid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'supplier_guid' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'supplier_guid' . '_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Supplier parameter found and valid
          //--------------------------------------------------------------------

          // Set supplier
          $data[ 'supplier' ] = $supplier;
        
        }
      
      }

    }

    //--------------------------------------------------------------------------
    // External PO number
    //--------------------------------------------------------------------------

    // Test for parameter exists
    //! @todo ANVILEX KM: Check string size of the extern PO number
    if ( $this->request->Is_POST_Parameter_Exists( 'extern_number' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Number not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'extern_number' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'extern_number' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {
      if($this->request->Is_POST_Parameter_Certain_Size_String( 'extern_number', 0, $this->model_orders_orders->Get_Order_Extern_Number_Maximum_String_Size() ) === false )
      {
      
        //------------------------------------------------------------------------
        // ERROR: Number not valid
        //------------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'extern_number' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'extern_number' . '_error' ];
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
      $json['error']['currency'] =$this->data['workplace_customers_interactions_request_add_' . 'currency' . '_error'];

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
        $json['error']['currency'] = $this->data['workplace_customers_interactions_request_add_' . 'currency' . '_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Currency code parameter found and valid
        //----------------------------------------------------------------------
        $data[ 'supplier_currency'] = trim($this->request->Get_POST_Parameter_As_String('currency'));
      }
    }

    //--------------------------------------------------------------------------
    // Payment address GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_GUID( 'payment_address' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Payment address GUID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'payment_address' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'payment_address' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Payment address GUID present
      //------------------------------------------------------------------------

      // Get payment address
      $data[ 'payment_address' ] = $this->model_address_address->Get_Address( $this->request->Get_POST_Parameter_As_GUID( 'payment_address' ) );

      //! @todo ANVILEX KM: Check for payment address linked to customer

      // Test for parameter valid
      if ( $data[ 'payment_address' ][ 'valid' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Payment address GUID not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'payment_address' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'payment_address' . '_error' ];

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

    //--------------------------------------------------------------------------
    // Delivery address GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_GUID( 'delivery_address' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Delivery address GUID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'delivery_address' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'delivery_address' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Delivery address GUID present
      //------------------------------------------------------------------------

      // Get delivery address
      $data[ 'delivery_address' ] = $this->model_address_address->Get_Address( $this->request->Get_POST_Parameter_As_GUID( 'delivery_address' ) );

      //! @todo ANVILEX KM: Check for delivery address linked to customer

      // Test for parameter valid
      if ( $data[ 'delivery_address' ][ 'valid' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Delivery address GUID not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'delivery_address' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'delivery_address' . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Delivery address GUID parameter found and valid
        //----------------------------------------------------------------------

      }

    }

    //--------------------------------------------------------------------------
    // Comment to the request
    //--------------------------------------------------------------------------

    // Test for parameter exists
    //! @todo ANVILEX KM: Check comment size 
    if ( $this->request->Is_POST_Parameter_Exists( 'comment' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Comment not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'comment' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'comment' . '_error' ];

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
        $json[ 'error' ][ 'comment' ] = $this->data[ 'workplace_customers_interactions_request_add_' . 'comment' . '_error' ];
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

    //--------------------------------------------------------------------------
    // Process data
    //--------------------------------------------------------------------------

    // Is request data valid
    if ( $request_data_valid === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameters present and valid
      //------------------------------------------------------------------------

      // Generate order GUID
      $guid = UUID_V4_T1();

      // Get customer (requestor)
      $data[ 'customer' ] = $this->customer->Get_Contact_Information( '787BC0170B204EC485BD5B3491AB43AE' );

      // Set order type to purchase
      $data[ 'type' ] = 'purchase';

      // Create new order
      //! @todo ANVILEX KM: Check return code
      $this->model_orders_orders->Create_Order( $guid, $data, $this->language->Get_Language_Code() );

      // Set redirect URL
      $json[ 'redirect_url' ] = $this->url->link( 'workplace/customers/info', 'guid=' . $data[ 'supplier' ][ 'guid' ], 'SSL' );

      // Set success code
      $json[ 'return_code' ] = true;

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>