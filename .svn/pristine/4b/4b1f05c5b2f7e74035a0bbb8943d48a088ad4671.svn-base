<?php
class ControllerAccountOrder extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------
  
  public function index()
  {
  
    // Test for customer logged in
    if ( $this->customer->Is_Logged() == false ) 
    {
      
      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameter set
      if ( $this->request->Is_GET_Parameter_Exists( 'id' ) === false )
      {
        
        //----------------------------------------------------------------------
        // Parameter not set
        //----------------------------------------------------------------------

        // Redirect to error page
        $this->response->Redirect( $this->url->link( 'order/not_found', '', 'SSL' ) );

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter set
        //----------------------------------------------------------------------

        // Load messages
        $this->messages->Load( $this->data, 'account', 'order', 'index', $this->language->Get_Language_Code() );
        
        //----------------------------------------------------------------------
        // Set page data
        //----------------------------------------------------------------------
        
        // Get order identifier
        $order_id = $this->request->Get_GET_Parameter_As_Integer( 'id' );


        $this->load->model( 'orders/orders' );

        // Get order information
        $this->data['order']= $this->model_orders_orders->Get_Order( $order_id );
        
        
        $this->data['order'][ 'date' ] = date( 'd.m.Y', strtotime( substr( $this->data['order'][ 'date' ], 0, 10 ) ) );

        // Get order lines information
        $order_lines = $this->model_orders_orders->Get_Lines( $order_id );
        
        // Iterate over all order lines
        foreach ( $order_lines as $order_line )
        {
          
          // Append order line
          $this->data[ 'lines' ][] = array(
              'id' => $order_line[ 'id' ],
              'item_guid' => $order_line[ 'item_guid' ],
              'mpn' => $order_line[ 'mpn' ],
              'description' => $order_line[ 'description' ],
              'quantity' => $order_line[ 'quantity' ],
              'price' => $order_line[ 'price' ],
              'net' => $order_line[ 'net' ],
              'vat_rate' => $order_line[ 'vat_rate' ],
              'vat' => $order_line[ 'vat' ],
              'total' => $order_line[ 'total' ]
          );
        
        }

        //----------------------------------------------------------------------
        // Render page
        //----------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle($this->messages->Get_Message('document_title_text') . ' №' . $order_id);
        $this->response->setDescription($this->messages->Get_Message('document_description_text'));
        $this->response->setKeywords('');
        $this->response->setRobots('index, follow');

        // Add styles
        $this->response->addStyle( 'catalog/view/stylesheet/account/order.css' );

        // Set page template
        $this->children = array(
          'common/footer',
          'common/header'
        );

      }

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>