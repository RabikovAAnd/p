<?php
class ControllerPaymentPrepayment extends Controller 
{
	
	//----------------------------------------------------------------------------

	public function index() 
	{

    // Load language

//		$comment  = $this->language->get('text_instruction') . "\n\n";
//		$comment .= $this->config->get('prepayment_bank_' . $this->language->Get_Language_Code()) . "\n\n";
//		$comment .= $this->language->get('text_payment');
//		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('prepayment_order_status_id'), $comment, true);

    if ( isset( $this->session->data[ 'checkout' ][ 'order_id' ] ) == false )
    {

      //------------------------------------------------------------------------
      // ERROR: No order ID not set in session
      //------------------------------------------------------------------------
      
      // Redirect to checkout error page
//      $this->response->Redirect( $this->url->link( 'payment/error' ) );
      $this->response->Redirect( $this->url->link( 'checkout/error' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Order ID found, continue processing
      //------------------------------------------------------------------------
      
      // Loda data model
		  $this->load->model( 'sales/sales' );

      // Try to get order ID
      $order_id = $this->session->data[ 'checkout' ][ 'order_id' ];
    
      // Unset order ID from the section
		  unset( $this->session->data[ 'checkout' ][ 'order_id' ] );

      // Clear cart
//      $this->cart->clear();

      // Get current order
      $order_info = $this->model_sales_sales->Get_Sales_Order( $order_id );

      // Test order validity
      if ( $order_info[ 'valid' ] == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Can not get order information
        //----------------------------------------------------------------------
        
        // Redirect to checkout error page
        $this->response->Redirect( $this->url->link( 'checkout/error' ) );

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Order information getted, continue processing
        //----------------------------------------------------------------------

      }
      
      // Change order status
//      $this->model_checkout_order->ChangeStatusToWaiting( $order_id );

      // Redirect
      $this->response->Redirect( $this->url->link( 'checkout/success' ) );

    }
		
	}

  //----------------------------------------------------------------------------
/*
	public function success()
	{
	
		$this->data[ 'text_heading_title' ] = $this->language->get( 'text_success_heading_title' );

//		$this->data['text_body'] = $this->language->get('text_success');
//		$this->data['text_order_number'] = $this->language->get('text_success_order_number') . $this->session->data['order']['order_id'];

//		$this->data['bank'] = nl2br($this->config->get('prepayment_bank_' . $this->language->Get_Language_Code()));

//		unset( $this->session->data['order']['order_id'] );
		
		$this->children = array(
			'common/footer',
			'common/header'	
		);

//		$this->response->Set_HTTP_Output($this->Render( 'payment/success.tpl' ));

	}
*/
  //----------------------------------------------------------------------------
}
?>