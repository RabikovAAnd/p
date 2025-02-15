<?php
class ControllerWorkplaceCustomersInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer GUID present and valid
    if( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Invalud customer GUID
      //----------------------------------------------------------------------

      // Redirect to error page
      $this->response->Redirect( $this->url->link( 'workplace/customers/error', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer GUID present
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'customer_info', 'index', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'endpoints/endpoints' );
      $this->load->model( 'orders/orders' );
      $this->load->model( 'address/address' );
      $this->load->model( 'customers/customers' );

      // Get customer GUID
      $customer_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Try to get customer information
      $customer = $this->customer->Get_Contact_Information( $customer_guid );

      //! @todo ANVILEX KM: Check return code

      // Assign customer data
      $this->data[ 'customer' ] = $customer;

      // Set registration country
      $this->data[ 'registration_country' ] = $this->location->Get_Country_By_ISO2( $this->data[ 'customer' ][ 'registration_country' ], $this->language->Get_Language_Code() );

      // Test for corporate customer
      if ( $customer[ 'legal_entity' ] === '1' )
      {
        $this->data[ 'customer_info_edit_button_href' ] = $this->url->link( 'workplace/customers/corporate/edit', 'guid=' . $customer_guid, 'SSL' );
      }
      else
      {
        $this->data[ 'customer_info_edit_button_href' ] = $this->url->link( 'workplace/customers/individual/edit', 'guid=' . $customer_guid, 'SSL' );
      }

      //------------------------------------------------------------------------
      // Endpoints
      //------------------------------------------------------------------------

      // Endpoints data
      $endpoints = $this->model_endpoints_endpoints->Get_Endpoints();

      // Process endpoints
      foreach ( $endpoints as $endpoint )
      {

        // Set endpoint data
        $this->data[ 'endpoints' ][] = array(
          'element_href' => 'endpoint' . $endpoint[ 'guid' ],
          'guid' => $endpoint[ 'guid' ],
          'name' => $endpoint[ 'name' ],
          'access' => $this->model_endpoints_endpoints->Is_Exist_Customer_Endpoint( $customer_guid, $endpoint[ 'guid' ]),
          'allow_button_href' => $this->url->link( 'workplace/customers/endpoints/allow/Allow', 'customer_guid=' .  $customer_guid.'&endpoint_guid=' . $endpoint[ 'guid' ], 'SSL' ),              
          'remove_button_href' => $this->url->link( 'workplace/customers/endpoints/prohibit/Prohibit', 'customer_guid=' .  $customer_guid.'&endpoint_guid=' . $endpoint[ 'guid' ], 'SSL' )              
        );

      }

      //------------------------------------------------------------------------
      // Attributes
      //------------------------------------------------------------------------

      // Init attributes array
      $this->data[ 'attributes' ] = array();

      // Attributes data
      $attributes = $this->model_customers_customers->Get_Customer_Attributes( $customer_guid, $this->language->Get_Language_Code() );

      // Process attributes
      foreach ( $attributes as $attribute )
      {

        // Set endpoint data
        $this->data[ 'attributes' ][] = array(
          'element_href' => 'attribute' . $attribute[ 'index_guid' ],
          'index_guid' => $attribute[ 'index_guid' ],
          'attribute_guid' => $attribute[ 'guid' ],
          'name' => $attribute[ 'name' ],
          'value' => $attribute[ 'value' ],
          'edit_button_href' => $this->url->link( 'workplace/customers/attributes/edit', 'index_guid=' . $attribute[ 'index_guid' ], 'SSL' ),              
          'remove_button_href' => $this->url->link( 'workplace/customers/attributes/remove/Remove', 'customer_guid=' .  $customer_guid.'&index_guid=' . $attribute[ 'index_guid' ], 'SSL' )              
        );

      }

      //------------------------------------------------------------------------

      // Orders data
      $orders = $this->model_orders_orders->Get_Orders( $customer_guid );

      foreach ( $orders as $order )
      {

        $supplier_type = '';

        if ( $order[ 'type' ] === 'selling' )
        {
          $supplier_type = $this->data[ 'workplace_customer_info_selling_label' ];
        }

        if ( $order[ 'type' ] === 'purchase' )
        {
          $supplier_type = $this->data[ 'workplace_customer_info_purchase_label' ];
        }

        $this->data[ 'orders' ][] = array(
          'order_id' => $order[ 'id' ],
          'status' => $order[ 'status' ],
          'extern_number' => $order[ 'extern_number' ],
          'type' => $supplier_type,
          'date' => $order[ 'date' ],
          'href' => $this->url->link( 'workplace/customers/interactions/info', 'id=' . $order[ 'id' ], 'SSL' )
        );

      }

      $this->data[ 'create_request_button_href' ] = $this->url->link( 'workplace/customers/interactions/request/create', 'guid=' . $customer_guid, 'SSL' );

      //------------------------------------------------------------------------

      // Orders data
      $supplier_orders = $this->model_orders_orders->Get_Supplier_Orders($customer_guid);

      foreach ( $supplier_orders as $supplier_order )
      {

        $supplier_type = '';

        if ( $supplier_order[ 'type' ] === 'selling' )
        {
          $supplier_type = $this->data[ 'workplace_customer_info_selling_label' ];
        }

        if ( $supplier_order[ 'type' ] === 'purchase' )
        {
          $supplier_type = $this->data[ 'workplace_customer_info_purchase_label' ];
        }

        $this->data['orders'][] = array(
          'order_id' => $supplier_order[ 'id' ],
          'status' => $supplier_order[ 'status' ],
          'extern_number' => $supplier_order[ 'extern_number' ],
          'type' => $supplier_type,
          'date' => $supplier_order[ 'date' ],
          'href' => $this->url->link( 'workplace/customers/interactions/info', 'id=' . $supplier_order[ 'id' ], 'SSL' )
        );

      }

      $this->data[ 'create_offer_button_href' ] = $this->url->link( 'workplace/customers/interactions/offer/create', 'guid=' . $customer_guid, 'SSL' );

      //------------------------------------------------------------------------
      // Addresses
      //------------------------------------------------------------------------

      // Initialise addresses
      $this->data[ 'addresses' ] = array();

      // Get customer addresses
      $adresses = $this->model_address_address->Get_Addresses( $customer_guid );

      // Iterate over all customer adresses
      foreach ( $adresses as $address )
      {

        $country_name = $this->location->Get_Country_Info( $address['country_id'], $this->language->Get_Language_Code() )['description'];
        
        $zone_name = $this->location->Get_Country_Zone_Info( $address['zone_id'] )['name'];

        $address_text = $address['street'] . ' ' . $address['house'];
        if ($address['building'] != '') 
        {
          $address_text = $address_text . ', ' . $address['building'];
        }
        if ($address['apartment'] != '') 
        {
          $address_text = $address_text . ', ' . $address['apartment'];
        }
        if ($address['postcode'] != '') 
        {
          $address_text = $address_text . ', ' . $address['postcode'];
        }
        if ($address['district'] != '') 
        {
          $address_text = $address_text . ', ' . $address['district'];
        }
        if ($address['city'] != '') 
        {
          $address_text = $address_text . ' ' . $address['city'];
        }
        if ($country_name != '') 
        {
          $address_text = $address_text . ', ' . $country_name;
        }

        // Add dustomer address
        $this->data[ 'addresses' ][] = array(
          'guid' => $address[ 'guid' ],
          'add_warehouse_href' => $this->url->link( 'workplace/customers/address/warehouse/add', 'address_guid=' . $address[ 'guid' ], 'SSL' ),
          'edit_href' => $this->url->link( 'workplace/customers/address/edit', 'guid=' . $address[ 'guid' ] . '&customer_guid=' . $customer_guid, 'SSL' ),
          'href' => $this->url->link( 'workplace/customers/address/info', 'guid=' . $address[ 'guid' ], 'SSL'),
          'country_name' => $country_name,
          'zone_name' => $zone_name,
          'postcode' => $address[ 'postcode' ],
          'district' => $address[ 'district' ],
          'city' => $address[ 'city' ],
          'street' => $address[ 'street' ],
          'house' => $address[ 'house' ],
          'building' => $address[ 'building' ],
          'apartment' => $address[ 'apartment' ],
          'active' => $address[ 'active' ],
          'address_text' => $address_text
        );

      }

      //------------------------------------------------------------------------
      // Linked customers
      //------------------------------------------------------------------------

      // Initialise related contacts
      $this->data[ 'legal_entities' ] = array();
      $this->data[ 'individuals' ] = array();

      // Test for corporate customer
      if ( $customer[ 'legal_entity' ] == 1 )
      {

        // Customers data
        $related_customers = $this->model_customers_customers->Get_Customer_Customers( $customer_guid );

        foreach ( $related_customers as $related_customer )
        {

          $related_customer_data = $this->customer->Get_Contact_Information($related_customer['customer_guid']);

          if ($related_customer_data['legal_entity'] == 1) 
          {

            $this->data[ 'legal_entities' ][] = array(
              'element_href' => 'customer' . $related_customer_data[ 'guid' ],
              'guid' => $related_customer_data['guid'],
              'company_name' => $related_customer_data['company_name'],
              'href' => $this->url->link('workplace/customers/info', 'guid=' . $related_customer_data['guid'], 'SSL'),
              'remove_href' => $this->url->link('workplace/customers/relationships/remove/Remove',  'guid=' . $customer_guid .'&customer_guid=' . $related_customer_data['guid'], 'SSL'),
            );

          }
          else
          {

            $this->data[ 'individuals' ][] = array(
              'element_href' => 'customer' . $related_customer_data[ 'guid' ],
              'guid' => $related_customer_data['guid'],
              'legal_entity' => $related_customer_data['legal_entity'],
              'firstname' => $related_customer_data['firstname'],
              'lastname' => $related_customer_data['lastname'],
              'middlename' => $related_customer_data['middlename'],
              'href' => $this->url->link('workplace/customers/info', 'guid=' . $related_customer_data['guid'], 'SSL'),
              'remove_href' => $this->url->link('workplace/customers/relationships/remove/Remove',  'guid=' . $customer_guid .'&customer_guid=' . $related_customer_data['guid'], 'SSL'),
            );

          }

        }

      }

      $this->data[ 'contact' ][ 'favorite' ] = $this->customer->Is_In_Favorites( $this->customer->Get_GUID(), $customer_guid );

      // Set links
      $this->data[ 'add_favorites_href' ] = $this->url->link( 'workplace/favorites/contacts/add/Add_To_Favorites', 'guid=' . $customer_guid, 'SSL' );
      $this->data[ 'remove_favorites_href' ] = $this->url->link( 'workplace/favorites/contacts/remove/remove_from_favorites',  'guid=' . $customer_guid . '&remove=false' , 'SSL' );
      $this->data[ 'add_related_legal_entities_href' ] = $this->url->link( 'workplace/customers/relationships/corporate/add', 'guid=' . $customer_guid, 'SSL' );
      $this->data[ 'add_related_individuals_href' ] = $this->url->link( 'workplace/customers/relationships/individual/add', 'guid=' . $customer_guid, 'SSL' );
      $this->data[ 'create_address_button_href' ] = $this->url->link( 'workplace/customers/address/create', 'guid=' . $customer_guid, 'SSL' );
      $this->data[ 'add_extra_info_button_href' ] = $this->url->link( 'workplace/customers/attributes/add', 'guid=' . $customer_guid, 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setRobots( 'index, follow' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'workplace/menu',
        'common/header'
      );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>