<?php
class ControllerWorkplaceCustomersInteractionsInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for Order ID present and valid
    if( $this->request->Is_GET_Parameter_ID( 'id' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Invalud Order ID
      //----------------------------------------------------------------------

      // Redirect to error page
      $this->response->Redirect( $this->url->link( 'workplace/customers/error', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Order ID present
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'customers_interactions_info', 'index', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'orders/orders' );

      // Get ID
      $order_id = $this->request->Get_GET_Parameter_As_ID( 'id' );

      // Get order information
      $this->data[ 'order' ] = $this->model_orders_orders->Get_Order($order_id);

      $this->data[ 'order' ][ 'date' ] = date( 'd.m.Y', strtotime( substr( $this->data[ 'order' ][ 'date' ], 0, 10 ) ) );

      $this->data[ 'order' ][ 'customer' ] = $this->customer->Get_Contact_Information( $this->data[ 'order' ][ 'customer_guid' ] );

      // Get order lines information
      $order_lines = $this->model_orders_orders->Get_Lines( $order_id );

      // Iterate over all order lines
      foreach ( $order_lines as $order_line )
      {

        // Append order line
        $this->data[ 'lines' ][] = array(
            'element_href'=> 'line'.$order_line[ 'id' ],
            'id' => $order_line[ 'id' ],
            'item_guid' => $order_line[ 'item_guid' ],
            'mpn' => $order_line[ 'mpn' ],
            'description' => $order_line[ 'description' ],
            'quantity' => $order_line[ 'quantity' ],
            'price' => $order_line[ 'price' ],
            'net' => $order_line[ 'net' ],
            'vat_rate' => $order_line[ 'vat_rate' ],
            'vat' => $order_line[ 'vat' ],
            'total' => $order_line[ 'total' ],
            'remove_button_href' => $this->url->link( 'workplace/customers/interactions/items/remove/Remove', 'line_id=' . $order_line[ 'id' ], 'SSL' ),
            'change_button_href' => $this->url->link( 'workplace/customers/interactions/items/edit', 'line_id=' . $order_line[ 'id' ], 'SSL' ),
        );

      }
      // Orders data
      // $orders = $this->model_customers_orders->Get_Customer_Orders($customer_guid);
      // foreach ( $orders as $order ) 
      // {
      //   $this->data[ 'orders' ][] = array(
      //     'order_id' => $order[ 'order_id' ],
      //     'status' => $order[ 'status' ],
      //     'extern_number' => $order[ 'extern_number' ],
      //     'date' => $order[ 'date' ],
      //     'status_id' => $order[ 'status_id' ],
      //     'href' => $this->url->link( 'workplace/customers/сommercial_relationships/info', 'id=' . $order[ 'order_id' ], 'SSL' ),
      //   );
      // }

      // Set links
      $this->data[ 'edit_delivery_address_button_href' ] = $this->url->link( 'workplace/customers/interactions/address/delivery/edit', 'id=' .  $this->data[ 'order' ]['id'], 'SSL' );
      $this->data[ 'edit_payment_address_button_href' ] = $this->url->link( 'workplace/customers/interactions/address/payment/edit', 'id=' .  $this->data[ 'order' ]['id'], 'SSL' );
      $this->data[ 'add_order_line_button_href' ] = $this->url->link( 'workplace/customers/interactions/items/add', 'id=' .  $this->data[ 'order' ]['id'], 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription($this->messages->Get_Message( 'document_description_text' ) );
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