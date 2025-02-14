<?php
class ControllerPaymentPayPal extends Controller
{

  //----------------------------------------------------------------------------

  public function index()
  {

    if ( isset( $this->session->data[ 'checkout' ][ 'order_id' ] ) == false )
    {

      //------------------------------------------------------------------------
      // ERROR: No order ID not set in session
      //------------------------------------------------------------------------

      // Log error
      $this->log->Log_ERROR( 'Session do not have an order ID.' );

      // Redirect to checkout error page
//      $this->response->Redirect( $this->url->link( 'payment/error' ) );
      $this->response->Redirect( $this->url->link( 'checkout/error' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Order ID found, continue processing
      //------------------------------------------------------------------------

      // Load data module
      $this->load->model( 'sales/sales' );

      // Try to get order ID
      $order_id = $this->session->data[ 'checkout' ][ 'order_id' ];
    
      // Unset order ID from the section
		  unset( $this->session->data[ 'checkout' ][ 'order_id' ] );

      // Clear cart
//      $this->cart->clear();

      // Get current order
      $order_info = $this->model_sales_sales->getOrder( $order_id );

      // Test order validity
      if ( $order_info[ 'valid' ] == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Can not get order information
        //----------------------------------------------------------------------
        
        // Set order status to error
        // ANVILEX KM: Implement

        // Log error
        $this->log->Log_ERROR( 'Order can not be retrived by given ID: ' . $order_id );

        // Redirect to checkout error page
        $this->response->Redirect( $this->url->link( 'checkout/error' ) );

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Order information getted, continue processing
        //----------------------------------------------------------------------

        // Set order status to waiting for prepayment
//        $this->model_checkout_order->updateStatus( $order_info[ 'order_id' ], 2 );


        // Set seller paypal account
        $this->data[ 'business' ] = $this->config->get( 'shop_paypal_email' );

        // Set invoice number
        // ANVILEX KM: Invoice ID must be retrived first
//        $this->data[ 'invoice' ] = 'OC' . $order_info[ 'order_id' ] . ' - ' . html_entity_decode( $order_info['payment_firstname'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode( $order_info[ 'payment_lastname' ], ENT_QUOTES, 'UTF-8');
        $this->data[ 'invoice' ] = $order_info[ 'order_id' ];

        $this->data[ 'item_name' ] = html_entity_decode( $this->language->get( 'text_order_number' ) . $order_info[ 'order_id' ], ENT_QUOTES, 'UTF-8' );
        $this->data[ 'item_number' ] = $order_info[ 'order_id' ];

        $this->data[ 'total' ] = $this->currency->format( $order_info[ 'total' ], $order_info[ 'currency_code' ], false, false );
//        $this->data[ 'shipping_fee' ] = $this->currency->format( $order_info['shipping_fee'], $order_info['currency_code'], false, false );
//        $this->data[ 'payment_fee' ] = $this->currency->format( $order_info['payment_fee'], $order_info['currency_code'], false, false );
//        $this->data[ 'vat' ] = $this->currency->format( $order_info[ 'vat_fee' ], $order_info[ 'currency_code' ], false, false );
        $this->data[ 'currency_code' ] = $order_info[ 'currency_code' ];
        
        // Set payment address data
        $this->data[ 'first_name' ] = html_entity_decode( $order_info[ 'payment_contact_firstname' ], ENT_QUOTES, 'UTF-8' );
        $this->data[ 'last_name' ] = html_entity_decode( $order_info[ 'payment_contact_lastname' ], ENT_QUOTES, 'UTF-8' );
        $this->data[ 'address1' ] = html_entity_decode( $order_info[ 'payment_address_1' ], ENT_QUOTES, 'UTF-8' );
        $this->data[ 'address2' ] = html_entity_decode( $order_info[ 'payment_address_2' ], ENT_QUOTES, 'UTF-8' );
        $this->data[ 'city' ] = html_entity_decode( $order_info[ 'payment_address_city'], ENT_QUOTES, 'UTF-8');
        $this->data[ 'zip' ] = html_entity_decode( $order_info[ 'payment_address_postcode'], ENT_QUOTES, 'UTF-8');
        $this->data[ 'country' ] = $order_info[ 'payment_address_country_iso_code_2' ];
        $this->data[ 'email' ] = $order_info[ 'payment_contact_email' ];

        // Set language settings
        $this->data[ 'lc' ] = $this->session->data[ 'language_code' ];
                
        // Payment success forwarding link
        $this->data[ 'return' ] = $this->url->link( 'payment/paypal/success' );
        
        // Payment notification callback link
        $this->data[ 'notify_url' ] = $this->url->link( 'payment/paypal/callback', '', 'SSL' );

        // Payment canceling forwarding link
        $this->data[ 'cancel_return' ] = $this->url->link( 'payment/paypal/cancel', '', 'SSL' );

        // Payment action
//        $this->data[ 'paymentaction' ] = ( !$this->config->get( 'paypal_transaction' ) ) ? 'authorization' : 'sale';
        $this->data[ 'paymentaction' ] = 'sale';
        
        // Set custom value. This value passed thought.
        $this->data[ 'custom' ] = $order_info[ 'order_id' ];
        
        // Paypal API link
        $this->data[ 'action' ] = 'https://www.paypal.com/cgi-bin/webscr';

        // Render page
//        $this->response->Set_HTTP_Output( 'payment/paypal.tpl' );

/*
  <input type="hidden" name="shipping" value="<?php echo $shipping_fee; ?>" />
  <input type="hidden" name="handling" value="<?php echo $payment_fee; ?>" />
  <input type="hidden" name="tax" value="<?php echo $vat; ?>" />
*/
      }
      
    }
    
/*

      // Set prepayment received
      $this->model_checkout_order->updateStatus( $order_info['order_id'], 14 );

      $this->session->data['order']['order_id'] = '';

      // Render page
//      $this->response->Set_HTTP_Output( 'payment/paypal_error.tpl' );

*/
  }

  //----------------------------------------------------------------------------
  // Payment successfull
  //----------------------------------------------------------------------------
  
  public function success()
  {
/*
    if ( isset( $this->session->data['order']['order_id'] ) )
    {

      // Set waiting for prepayment
      $this->load->model('checkout/order');
      $this->model_checkout_order->updateStatus( (int)$this->session->data['order']['order_id'], 3 );

    }
*/

    // Set order status to paid

    $this->data['text_heading_title'] = $this->language->get('text_success_heading_title');

    $this->data['text_body'] = $this->language->get('text_success');
    $this->data['text_order_number'] = $this->language->get('text_success_order_number') . $this->session->data['order']['order_id'];

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

    // Render page
//    $this->response->Set_HTTP_Output( $this->Render( 'payment/paypal_success.tpl' ) );

  }

  //----------------------------------------------------------------------------
  // Payment canceled
  //----------------------------------------------------------------------------
  
  public function cancel()
  {

/*
    if ( isset($this->session->data['order']['order_id']) )
    {

      // Set waiting for prepayment
      $this->load->model('checkout/order');

      $this->model_checkout_order->updateStatus( (int)$this->session->data['order']['order_id'], 2 );

    }
*/

    // Set order status to waiting for payment

    $this->data['text_heading_title'] = $this->language->get( 'text_cancel_heading_title' );
    $this->data['text_body'] = $this->language->get( 'text_cancel' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

    // Render page
//    $this->response->Set_HTTP_Output( $this->Render( 'payment/paypal_cancel.tpl' ) );

  }

  //----------------------------------------------------------------------------
  // PayPal callback
  //----------------------------------------------------------------------------

  public function callback()
  {

    if ( isset( $this->request->post[ 'custom' ] ) )
    {

      // Log PayPal errer
      $this->log->write( 'PAYPAL :: IPN REQUEST Bad order ID: ' . $this->request->post[ 'custom' ] );

    }
    else
    {

      $order_id = (int)$this->request->post[ 'custom' ];

      $this->load->model('checkout/order');

      $order_info = $this->model_checkout_order->getOrder($order_id);

      if ( $order_info )
      {

        // post back to PayPal system to validate
        $header  = 'POST /cgi-bin/webscr HTTP/1.1' . "\r\n";
        $header .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
        $header .= 'Host: www.paypal.com' . "\r\n";
        $header .= 'Connection: close' . "\r\n\r\n";

        $request = 'cmd=_notify-validate';

        foreach ( $this->request->post as $key => $value )
        {
          
          $request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
        
        }

        $curl = curl_init( 'https://www.paypal.com/cgi-bin/webscr' );

//        if (!$this->config->get('paypal_test')) {
//          $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
//        } else {
//          $curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
//        }

        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $request );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HEADER, $header );
        curl_setopt( $curl, CURLOPT_TIMEOUT, 30 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

        $response = curl_exec($curl);

        if ( !$response )
        {
          
          $this->log->write('PAYPAL :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
        
        }

        if ($this->config->get('paypal_debug'))
        {
          $this->log->write('PAYPAL :: IPN REQUEST: ' . $request);
          $this->log->write('PAYPAL :: IPN RESPONSE: ' . $response);
        }

        if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status']))
        {
          
          $order_status_id = $this->config->get('config_order_status_id');

          switch($this->request->post['payment_status'])
          {
            
            case 'Canceled_Reversal':
              $this->log->write('PAYPAL :: IPN REQUEST Canceled_Reversal: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
            
            case 'Completed':
              if ((strtolower($this->request->post['receiver_email']) == strtolower($this->config->get('paypal_email'))) && ((float)$this->request->post['mc_gross'] == $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false)))
              {
                // Set prepayment received
                $this->model_checkout_order->updateStatus($order_id,4);
              }
              else
              {
                $this->log->write('PAYPAL :: RECEIVER EMAIL MISMATCH! ' . strtolower($this->request->post['receiver_email']));
              }
              break;
            
            case 'Denied':
              $this->log->write('PAYPAL :: IPN REQUEST Denied: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
            
            case 'Expired':
              $this->log->write('PAYPAL :: IPN REQUEST Expired: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
            
            case 'Failed':
              $this->log->write('PAYPAL :: IPN REQUEST Failed: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
            
            case 'Pending':
              $this->log->write('PAYPAL :: IPN REQUEST Pending: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
            
            case 'Processed':
              $this->log->write('PAYPAL :: IPN REQUEST Processed: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
            
            case 'Refunded':
              $this->log->write('PAYPAL :: IPN REQUEST Refunded: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
            
            case 'Reversed':
              $this->log->write('PAYPAL :: IPN REQUEST Reversed: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
              
            case 'Voided':
              $this->log->write('PAYPAL :: IPN REQUEST Voided: ' . $order_id);
              $this->model_checkout_order->updateStatus($order_id,14);
              break;
          
          }

        }
        else
        {

          // Thomething going wrong
          $this->log->write( 'PAYPAL :: IPN REQUEST Bad order ID: ' . $order_id );
          $this->model_checkout_order->updateStatus( $order_id, 14 );

        }

        curl_close($curl);

      }

    }

  }

  //----------------------------------------------------------------------------

}
?>