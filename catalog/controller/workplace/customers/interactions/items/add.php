<?php
class ControllerWorkplaceCustomersInteractionsItemsAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {


    // Test for Order ID present and valid
    if ($this->request->Is_GET_Parameter_ID('id') === false) {

      //----------------------------------------------------------------------
      // ERROR: Invalud Order ID
      //----------------------------------------------------------------------

      // Redirect to error page
      $this->response->Redirect($this->url->link('workplace/customers/error', '', 'SSL'));

    } else {


      // Load messages
      $this->messages->Load($this->data, 'workplace', 'customers_interactions_items_add', 'index', $this->language->Get_Language_Code());

      // Load data model
      $this->load->model('items/items');

      $this->data['order_id'] = $this->request->Get_GET_Parameter_As_ID('id');

      // Load item proposal
      $items = $this->model_items_items->Get_List_Of_Items(30, 1, '', false, true, false, '', $this->language->Get_Language_Code());

      // Process all proposed items
      foreach ($items as $item) {

        // Add item to the list
        $this->data['items'][] = array(
          'guid' => $item['guid'],
          'key' => $item['guid'] . '&' . $item['mpn'] . '&' . $item['manufacturer_name'],
          'mpn' => $item['mpn'],
          'name' => $item['name'],
          'manufacturer_name' => $item['manufacturer_name']
        );

      }

      // Compose links
      $this->data['add_button_href'] = $this->url->link('workplace/customers/interactions/items/add/Add', 'id=' . $this->data['order_id'], 'SSL');
      $this->data['cancel_button_href'] = $this->url->link('workplace/customers/interactions/info', 'id=' . $this->data['order_id'], 'SSL');

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

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
  // Search query
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Search()
  {

    // Initialise json data
    $json = array();

    // Test for customer not logged in
    if ($this->customer->Is_Logged() === false) {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link to login page
      $json['redirect_url'] = $this->url->link('account/login', '', 'SSL');

      // Set error code
      $json['return_code'] = false;

    } else {

      //------------------------------------------------------------------------
      // Custommer logged in
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('search') === false) {

        //----------------------------------------------------------------------
        // ERROR: 'search' parameter not found
        //----------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;

      } else {

        //----------------------------------------------------------------------
        // Parameter found, continue processing
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model('items/items');

        // Get proposed items
        $items = $this->model_items_items->Get_List_Of_Items(30, 1, $this->request->Get_POST_Parameter_As_String('search'), false, true, false, '', $this->language->Get_Language_Code());

        // Process all item
        foreach ($items as $item) {

          // Set item data as subitem proposal
          $json['items'][] = array(
            'guid' => $item['guid'],
            'mpn' => $item['mpn'],
            'name' => $item['name'],
            'manufacturer_name' => $item['manufacturer_name']
          );

        }

        // Set success code
        $json['return_code'] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output($json);

  }

  //----------------------------------------------------------------------------
  // Add item to order
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Init json data
    $json = array();

    // Load data model
    $this->load->model('items/items');
    $this->load->model('orders/orders');

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'customers_interactions_items_add', 'Add_Unit', $this->language->Get_Language_Code());

    // Init unit data
    $data = array();

    // Set request data valid status
    $request_data_valid = true;

    //--------------------------------------------------------------------------
    // Order ID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_GET_Parameter_ID('id') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Order ID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json['error']['id'] = $this->data['workplace_customers_interactions_items_add_edit_' . 'id' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Order ID parameter found
      //------------------------------------------------------------------------

      $data['order_id'] = trim($this->request->Get_GET_Parameter_As_GUID('id'));

    }

    //--------------------------------------------------------------------------
    // Check parameter: Quantity
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_Positive_Integer('quantity') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Quantity parameter not found
      //------------------------------------------------------------------------

      // Set error message text
      $json['error']['quantity'] = $this->data['workplace_customers_interactions_items_add_quantity_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Quantity parameter found
      //------------------------------------------------------------------------

      // Get item quantity
      $quantity = $this->request->Get_POST_Parameter_As_Integer('quantity');

      // Test for quantity non zero value
      if ($quantity == 0)
      {

        //----------------------------------------------------------------------
        // ERROR: Quantity parameter not positive integer
        //----------------------------------------------------------------------

        // Set error message text
        $this->error['quantity'] = $this->data['workplace_customers_interactions_items_add_quantity_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Quantity parameter is positive integer
        //----------------------------------------------------------------------

        $data['quantity'] = $quantity;

      }

    }

    //--------------------------------------------------------------------------
    // Check parameter: Item GUID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_POST_Parameter_GUID('item_guid') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Item GUID parameter not found
      //------------------------------------------------------------------------

      // Set error message text
      $json['error']['item_guid'] = $this->data['workplace_customers_interactions_items_add_item_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Item GUID parameter found
      //------------------------------------------------------------------------

      // Store item GUID 
      $item_guid = $this->request->Get_POST_Parameter_As_GUID('item_guid');

      $item = $this->model_items_items->Get_Information( $item_guid );

      // Test for item exists
      if ( $item[ 'valid' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Item not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'item_guid' ] = $this->data[ 'workplace_customers_interactions_items_add_item_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item found
        //----------------------------------------------------------------------

        // Store item data
        $data[ 'item' ] = $item;

      }

    }

    //--------------------------------------------------------------------------
    // Try to add item
    //--------------------------------------------------------------------------

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

      //------------------------------------------------------------------------
      // Parameters present and valid, try to add item
      //------------------------------------------------------------------------

//! @bug ANVILEX KM: Incorrect assignment of return code

      // Set success code
      $json['return_code'] = $this->model_orders_orders->Add_Line($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/customers/interactions/info', 'id=' .  $data['order_id'] , 'SSL');

      // Set success code
      $json['return_code'] = true;

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>