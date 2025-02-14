<?php 
class ModelPaymentCOD extends Model {
  	public function getMethod($address, $total) 
  	{
		
		$sql_query = "SELECT * FROM payment_method_to_country ";
		$sql_query .= "LEFT JOIN payment_method ON payment_method.id=payment_method_to_country.payment_method_id ";
		$sql_query .= "WHERE payment_method.id='5' AND payment_method_to_country.country_id='" . (int)$address['country_id'] . "' AND (payment_method_to_country.country_zone_id='" . (int)$address['country_zone_id'] . "' OR payment_method_to_country.country_zone_id='0')";

		$query = $this->db->query($sql_query);
	
		if ($this->config->get('cod_total') > 0 && $this->config->get('cod_total') > $total) {
			$status = false;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
				'id'           => $result['id'],
				'logo'         => $result['logo'],
        		'code'         => 'cod',
        		'title'        => '',
				'fixed_fee'	   => $result['fixed_fee'],
				'variable_fee' => $result['variable_fee'],
				'sort_order'   => 0
      		);
    	}
   
    	return $method_data;
  	}
 
   	public function getFee($payment_method_id)
  	{
  		
  		$fee['fix'] = 6.00;
  		$fee['variable'] = 0.00;
  		
  		return $fee;
	}

}
?>