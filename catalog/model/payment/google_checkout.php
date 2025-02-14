<?php 
class ModelPaymentGoogleCheckout extends Model {
  	public function getMethod($address, $total) {
		
		$sql_query = "SELECT * FROM payment_method_to_country ";
		$sql_query .= "LEFT JOIN payment_method ON payment_method.id=payment_method_to_country.payment_method_id ";
		$sql_query .= "WHERE payment_method.id='4' AND payment_method_to_country.country_id='" . (int)$address['country_id'] . "' AND (payment_method_to_country.country_zone_id='" . (int)$address['country_zone_id'] . "' OR payment_method_to_country.country_zone_id='0')";

		$query = $this->db->query($sql_query);
		
		if ($this->config->get('google_checkout_total') > 0 && $this->config->get('google_checkout_total') > $total) {
			$status = false;
		} elseif ($query->num_rows) {	
			$status = true;
		} else {
			$status = false;
		}	
		
		$currencies = array(
			'AUD',
			'CAD',
			'EUR',
			'GBP',
			'JPY',
			'USD',
			'NZD',
			'CHF',
			'HKD',
			'SGD',
			'SEK',
			'DKK',
			'PLN',
			'NOK',
			'HUF',
			'CZK',
			'ILS',
			'MXN',
			'MYR',
			'BRL',
			'PHP',
			'TWD',
			'THB',
			'TRY'
		);
		
		if (!in_array(strtoupper($this->currency->getCode()), $currencies)) {
			$status = false;
		}	
				
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'       => 'google_checkout',
        		'title'      => '',
				'sort_order' => 0
      		);
    	}
   
    	return $method_data;
  	}
}
?>