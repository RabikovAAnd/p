<?php
class ModelShippingPickup extends Model {
	function getQuote($address) {
		
		$quote_data = array();
	
		$sql_query = "SELECT * FROM shipping_method_to_country ";
		$sql_query .= "LEFT JOIN shipping_method ON shipping_method.id=shipping_method_to_country.shipping_method_id ";
		$sql_query .= "WHERE shipping_method.company_id='pickup' AND shipping_method_to_country.country_id='" . (int)$address['country_id'] . "' AND (shipping_method_to_country.country_zone_id='" . (int)$address['country_zone_id'] . "' OR shipping_method_to_country.country_zone_id='0')";

		$query = $this->db->query($sql_query);
	
		if ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
		
		$method_data = array();
	
		if ($status) {
			$quote_data = array();
			
      		$quote_data['pickup'] = array(
        		'code'         => 'pickup.pickup',
        		'title'        => 'Pickup',
        		'cost'         => 0.00,
        		'tax_class_id' => 0,
				'text'         => $this->currency->format(0.00)
      		);

      		$method_data = array(
        		'code'       => 'pickup',
        		'title'      => 'Pickup',
        		'quote'      => $quote_data,
				'sort_order' => 0,
        		'error'      => false
      		);
		}
	
		return $method_data;
	}
}
?>