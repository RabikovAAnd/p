<?php
class ControllerWorkplaceCustomersInteractionsAddressPaymentEdit extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------

  public function index()
  {

    if ($this->request->Is_GET_Parameter_ID('id') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not set
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'customers_interactions_address_payment_edit', 'index', $this->language->Get_Language_Code());

      // Load data models
      $this->load->model('address/address');
      $this->load->model('orders/orders');

      $order_id = $this->request->Get_GET_Parameter_As_ID('id');
      $order = $this->model_orders_orders->Get_Order($order_id);

      // Get addresses linked to customer
      $addresses = $this->model_address_address->Get_Addresses($order['customer_guid']);

      // Iterate over all adresses
      foreach ($addresses as $address)
      {

        $country_name = $this->location->Get_Country_Info($address['country_id'])['name'];
        $zone_name = $this->location->Get_Country_Zone_Info($address['zone_id'])['name'];

        $address_text = $address['street'] . ' ' . $address['house'];
        if ($address['building'] != '') {
          $address_text = $address_text . ', ' . $address['building'];
        }
        if ($address['apartment'] != '') {
          $address_text = $address_text . ', ' . $address['apartment'];
        }
        if ($address['postcode'] != '') {
          $address_text = $address_text . ', ' . $address['postcode'];
        }
        if ($address['city'] != '') {
          $address_text = $address_text . ' ' . $address['city'];
        }
        if ($country_name != '') {
          $address_text = $address_text . ', ' . $country_name;
        }
        $generic_address = array(
          'guid' => $address['guid'],
          'country_name' => $country_name,
          'zone_name' => $zone_name,
          'postcode' => $address['postcode'],
          'city' => $address['city'],
          'street' => $address['street'],
          'house' => $address['house'],
          'building' => $address['building'],
          'apartment' => $address['apartment'],
          'active' => $address['active'],

          'address_text' => $address_text,
        );

        // Add address
        $this->data['addresses'][] = $generic_address;

      }

      // Set links
      $this->data['cancel_button_href'] = $this->url->link('workplace/customers/interactions/info', 'id=' . $order_id, 'SSL');
      $this->data['edit_button_href'] = $this->url->link('workplace/customers/interactions/address/payment/edit/Edit', 'id=' . $order_id, 'SSL');

      //-----------------------------------------------------------------------
      // Render page
      //-----------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords('');
      $this->response->setRobots('index, follow');

      // Set page configuration
      $this->children = array(
        'common/footer',
        'workplace/menu',
        'common/header'
      );

    }

  }

  //----------------------------------------------------------------------------
  // Update address
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'customers_interactions_address_payment_edit', 'Edit', $this->language->Get_Language_Code());

    // Load data models
    $this->load->model('address/address');
    $this->load->model('orders/orders');

    // Init customer data
    $data = array();

    // Clear request data valid sataus
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Order ID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_GET_Parameter_ID('id') === false)
    {

      //----------------------------------------------------------------------
      // ERROR: Order ID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['id'] = $this->data['workplace_customers_interactions_address_payment_edit_' . 'id' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Order ID parameter found
      //----------------------------------------------------------------------

      $data['order_id'] = trim($this->request->Get_GET_Parameter_As_GUID('id'));

    }

    //------------------------------------------------------------------------
    // Address GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_GUID('address_guid') === false)
    {

      //----------------------------------------------------------------------
      // ERROR: Address GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json['error']['address_guid'] = $this->data['workplace_customers_interactions_address_payment_edit_' . 'address_guid' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Address GUID parameter found
      //----------------------------------------------------------------------

      $data['address_guid'] = trim($this->request->Get_POST_Parameter_As_GUID('address_guid'));

    }



    //------------------------------------------------------------------------
    // Process request data
    //------------------------------------------------------------------------

    // Is request data valid
    if ($request_data_valid === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    }
    else
    {

      //--------------------------------------------------------------------
      // Parameters present and valid
      //--------------------------------------------------------------------

      $data['address'] =  $this->model_address_address->Get_Address($data['address_guid']);

      // Set success code
      $this->model_orders_orders->Update_Payment_Address($data);

      $json['return_code'] = true;

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/customers/interactions/info', 'id=' . $data['order_id'], 'SSL');

    }

    // Send json data
    $this->response->Set_Json_Output($json);

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>