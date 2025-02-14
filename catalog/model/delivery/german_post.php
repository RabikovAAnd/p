<?php 
class ModelShippingGermanPost extends Model {    

  	public function getQuote($address) {
  				
		$quote_data = array();
			
		$sql_query = "SELECT * FROM shipping_method_to_country ";
		$sql_query .= "LEFT JOIN shipping_method ON shipping_method.id=shipping_method_to_country.shipping_method_id ";
		$sql_query .= "WHERE shipping_method.company_id='german_post' AND shipping_method_to_country.country_id='" . (int)$address['country_id'] . "' AND (shipping_method_to_country.country_zone_id='" . (int)$address['country_zone_id'] . "' OR shipping_method_to_country.country_zone_id='0')";

		$query = $this->db->query($sql_query);
			
		if ($query->num_rows == 0) {
			
			// No found
		
		} else {
			
			// Get shopping cart properties
			$weight = $this->cart->getWeight();
			$sub_total = $this->cart->getSubTotal();

			// Iterate all shipping methods
			foreach ($query->rows as $result) {

				$quote_data['german_post_' . $result['id']] = array(
					'id'                    => $result['id'],
					'code'          		=> 'german_post.german_post_' . $result['id'],
//					'title'         		=> $result['name'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
					'title'         		=> $result['name'],
					'shipping_time_minimum'	=> $result['shipping_time_minimum'],
					'shipping_time_maximum'	=> $result['shipping_time_maximum'],
					'tracking'				=> $result['tracking'],
					'cost'          		=> $result['shipping_fee'],
//					'tax_class_id'  		=> $this->config->get('weight_tax_class_id'),
//					'tax_class_id'  		=> 0,				
//					'text'          		=> $this->currency->format($this->tax->calculate($cost, $this->config->get('weight_tax_class_id'), $this->config->get('config_tax')))
//					'text'          		=> $this->currency->format($result['shipping_fee'])
				);	
				
			}

		}
	
		$method_data = array();
	
		if ($quote_data) {
      		$method_data = array(
        		'code'       => 'german_post',
        		'title'      => 'Deutsche Post',
        		'icon'		 => 'german_post.jpg',
        		'quote'      => $quote_data,
				'sort_order' => 0,
        		'error'      => false
      		);
		}
	
		return $method_data;
  	}
  	
  	public function getFee($shiping_method_id)
  	{
  		
  		$fee = 1.35;
  		
  		return $fee;
	}

}
?>