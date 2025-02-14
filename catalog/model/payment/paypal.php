<?php 
class ModelPaymentPayPal extends Model 
{
  
  public function getMethod($address, $total) 
  {
		
		$sql_query = "SELECT * FROM payment_method_to_country ";
		$sql_query .= "LEFT JOIN payment_method ON payment_method.id=payment_method_to_country.payment_method_id ";
		$sql_query .= "WHERE payment_method.id='1' AND payment_method_to_country.country_id='" . (int)$address['country_id'] . "' AND (payment_method_to_country.country_zone_id='" . (int)$address['country_zone_id'] . "' OR payment_method_to_country.country_zone_id='0')";

		$query = $this->db->query($sql_query);
 
		$method_data = array();

		if ($query->num_rows != 1)
		{

			// Not found

		}
		else
		{

			// ToDo: Check total

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

			// Check for currency supported
			if (!in_array(strtoupper($this->currency->getCode()), $currencies)) 
			{
				
				// Currency not supported
				
			}	
			else
			{
				
				// Iterate all shipping methods
				foreach ($query->rows as $result) 
				{
      				$method_data = array( 
      					'id'            => $result['id'],
        				'code'       	=> 'paypal',
        				'logo'          => $result['logo'],
        				'title'      	=> 'PayPal',
						'fixed_fee'		=> $result['fixed_fee'],
						'variable_fee'	=> $result['variable_fee'],
						'sort_order' 	=> 0
      				);
				
				}
			}		

		}
				
    	return $method_data;
  	}
  	
   	public function getFee($payment_method_id)
  	{
  		
  		$fee['fix'] = 0.35;
  		$fee['variable'] = 0.0249;
  		
  		return $fee;
	}
 	
}
?>