<?php
final class Tax 
{

	private $db;
	private $session;
  private $config;
  private $customer;
	
	public function __construct($registry) 
	{
		
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->db = $registry->get('db');	
		$this->session = $registry->get('session');

  	}
	
	public function format($number, $format=false)
	{

    	$string = '';

		if ($format) {
			$decimal_point = $this->language->get('decimal_point');
		} else {
			$decimal_point = '.';
		}
		
		if ($format) {
			$thousand_point = $this->language->get('thousand_point');
		} else {
			$thousand_point = '';
		}
		
    	$string .= number_format($number*100, 2, $decimal_point, $thousand_point);

		$string .= '%';

    	return $string;

	}
	
	public function getVAT($country_id, $vat_number){
		
		$vat = array();
		
		if ( $country_id == 81 )
		{
			// DE
			$vat['rate'] = 0.19;
			$vat['rate_string'] = '19.0%';
		}
		else
		{
			if ( $country_id = 14 )
			{
				// EU
				if ( $vat_number == '' )
				{
					$vat['rate'] = 0.19;
					$vat['rate_string'] = '19.0%';				
				}
				else
				{
					$vat['rate'] = 0.00;
					$vat['rate_string'] = '0.0%';					
				}
			}
			else
			{
				// WORLD
				$vat['rate'] = 0.00;
				$vat['rate_string'] = '0.0%';
			}
			
		}
	
		return $vat;

	}
							
  	public function calculate($value, $tax_class_id, $calculate = true) {
		if ($tax_class_id && $calculate) {
			$amount = $this->getTax($value, $tax_class_id);
				
			return $value + $amount;
		} else {
      		return $value;
    	}
  	}
	
  	public function getTax($value, $tax_class_id) {
		$amount = 0;
			
		$tax_rates = $this->getRates($value, $tax_class_id);
		
		foreach ($tax_rates as $tax_rate) {
			$amount += $tax_rate['amount'];
		}
				
		return $amount;
  	}
		
	public function getRateName($tax_rate_id) {
		$tax_query = $this->db->query("SELECT name FROM tax_rate WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
	
		if ($tax_query->num_rows) {
			return $tax_query->row['name'];
		} else {
			return false;
		}
	}
	
    public function getRates($value, $tax_class_id) {

		$tax_rates = array();
/*		
		if ($this->customer->Is_Logged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		if ($this->shipping_address) {
			$tax_query = $this->db->query("SELECT tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM tax_rule tr1 LEFT JOIN tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) WHERE tr1.tax_class_id = '" . (int)$tax_class_id . "' AND tr1.based = 'shipping' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "' AND z2gz.country_id = '" . (int)$this->shipping_address['country_id'] . "' ORDER BY tr1.priority ASC");
			
			foreach ($tax_query->rows as $result) {
				$tax_rates[$result['tax_rate_id']] = array(
					'tax_rate_id' => $result['tax_rate_id'],
					'name'        => $result['name'],
					'rate'        => $result['rate'],
					'type'        => $result['type'],
					'priority'    => $result['priority']
				);
			}
		}

		if ($this->payment_address) {
			$tax_query = $this->db->query("SELECT tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM tax_rule tr1 LEFT JOIN tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.tax_class_id = '" . (int)$tax_class_id . "' AND tr1.based = 'payment' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "' AND z2gz.country_id = '" . (int)$this->payment_address['country_id'] . "' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '" . (int)$this->payment_address['zone_id'] . "') ORDER BY tr1.priority ASC");
			
			foreach ($tax_query->rows as $result) {
				$tax_rates[$result['tax_rate_id']] = array(
					'tax_rate_id' => $result['tax_rate_id'],
					'name'        => $result['name'],
					'rate'        => $result['rate'],
					'type'        => $result['type'],
					'priority'    => $result['priority']
				);
			}
		}
		
*/	
		$tax_rate_data = array();
		
		foreach ($tax_rates as $tax_rate) {
			if (isset($tax_rate_data[$tax_rate['tax_rate_id']])) {
				$amount = $tax_rate_data[$tax_rate['tax_rate_id']]['amount'];
			} else {
				$amount = 0;
			}
			
			if ($tax_rate['type'] == 'F') {
				$amount += $tax_rate['rate'];
			} elseif ($tax_rate['type'] == 'P') {
				$amount += ($value / 100 * $tax_rate['rate']);
			}
		
			$tax_rate_data[$tax_rate['tax_rate_id']] = array(
				'tax_rate_id' => $tax_rate['tax_rate_id'],
				'name'        => $tax_rate['name'],
				'rate'        => $tax_rate['rate'],
				'type'        => $tax_rate['type'],
				'amount'      => $amount
			);
		}
		
		return $tax_rate_data;
		
	}

  	public function has($tax_class_id) 
  	{
		return isset($this->taxes[$tax_class_id]);
  	}
}
?>