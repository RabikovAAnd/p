<?php
class ControllerWorkplaceCustomersInteractionsItemsEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {



    if(($this->request->Is_GET_Parameter_ID('line_id') === false))
    {
      //----------------------------------------------------------------------
      // ERROR: Parameter not found
      //----------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else
    {

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'customers_interactions_items_edit', 'index', $this->language->Get_Language_Code());

      // Load data model
      $this->load->model('orders/orders');

      $line_id = $this->request->Get_GET_Parameter_As_ID('line_id');
      $this->data['line'] =$this->model_orders_orders->Get_Line( $line_id);

     
      // Compose links
      $this->data['edit_button_href'] = $this->url->link('workplace/customers/interactions/items/edit/Edit', 'line_id=' . $line_id, 'SSL');
      $this->data['cancel_button_href'] = $this->url->link('workplace/customers/interactions/info', 'id=' . $this->data['line']['order_id'], 'SSL');

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
  // Edit order item
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Init json data
    $json = array();

    // Load data model
    $this->load->model('items/items');
    $this->load->model('orders/orders');

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'customers_interactions_items_edit', 'Edit', $this->language->Get_Language_Code());

    // Init unit data
    $data = array();

    // Set request data valid status
    $request_data_valid = true;

    //--------------------------------------------------------------------------
    // Line ID
    //--------------------------------------------------------------------------

    // Test for parameter exists
    if ($this->request->Is_GET_Parameter_ID('line_id') === false)
    {

      //------------------------------------------------------------------------
      // ERROR: Line ID not found
      //------------------------------------------------------------------------

      // Set error message text
      $json['error']['line_id'] = $this->data['workplace_customers_interactions_items_edit_' . 'line_id' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Line ID parameter found
      //------------------------------------------------------------------------

      $line_id = trim($this->request->Get_GET_Parameter_As_GUID('line_id'));

      $line = $this->model_orders_orders->Get_Line( $line_id);

      // Test for item exists
      if ( $line[ 'valid' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Item not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'line_id' ] = $this->data[ 'workplace_customers_interactions_items_edit_line_id_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item found
        //----------------------------------------------------------------------

        // Store item data
        $data['line_id'] = $line['id'];

      }

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
      $json['error']['quantity'] = $this->data['workplace_customers_interactions_items_edit_quantity_error'];

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
        $this->error['quantity'] = $this->data['workplace_customers_interactions_items_edit_quantity_error'];

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
    // Try to edit line
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
     $this->model_orders_orders->Edit_Line($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/customers/interactions/info', 'id=' .  $line['order_id'] , 'SSL');

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