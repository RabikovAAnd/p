<?php
class ModelAccountReturn extends Model 
{
  
	public function addReturn($data) 
	{			      	
		$this->db->query("INSERT INTO `return` SET order_id = '" . (int)$data['order_id'] . "', customer_id = '" . (int)$this->customer->Get_ID() . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', return_reason_id = '" . (int)$data['return_reason_id'] . "', return_status_id = '" . (int)$this->config->get('config_return_status_id') . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_added = NOW(), date_modified = NOW()");
	}
	
	public function getReturn($return_id) 
	{
		$query = $this->db->query("SELECT r.return_id, r.order_id, r.firstname, r.lastname, r.email, r.telephone, r.product, r.model, r.quantity, r.opened, (SELECT rr.name FROM return_reason rr WHERE rr.return_reason_id = r.return_reason_id AND rr.language_id = '0') AS reason, (SELECT ra.name FROM return_action ra WHERE ra.return_action_id = r.return_action_id AND ra.language_id = '0') AS action, (SELECT rs.name FROM return_status rs WHERE rs.return_status_id = r.return_status_id AND rs.language_id = '') AS status, r.comment, r.date_ordered, r.date_added, r.date_modified FROM `return` r WHERE return_id = '" . (int)$return_id . "' AND customer_id = '" . $this->customer->Get_ID() . "'");
		
		return $query->row;
	}
	
	public function getReturns($start = 0, $limit = 20) 
	{
		if ($start < 0) 
		{
			$start = 0;
		}
		
		if ($limit < 1) 
		{
			$limit = 20;
		}	
				
		$query = $this->db->query("SELECT r.return_id, r.order_id, r.firstname, r.lastname, rs.name as status, r.date_added FROM `return` r LEFT JOIN return_status rs ON (r.return_status_id = rs.return_status_id) WHERE r.customer_id = '" . $this->customer->Get_ID() . "' AND rs.language_id = '0' ORDER BY r.return_id DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
			
	public function getTotalReturns() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `return`WHERE customer_id = '" . $this->customer->Get_ID() . "'");
		
		return $query->row['total'];
	}
	
	public function getReturnHistories($return_id) {
		$query = $this->db->query("SELECT rh.date_added, rs.name AS status, rh.comment, rh.notify FROM return_history rh LEFT JOIN return_status rs ON rh.return_status_id = rs.return_status_id WHERE rh.return_id = '" . (int)$return_id . "' AND rs.language_id = '0' ORDER BY rh.date_added ASC");

		return $query->rows;
	}			
}
?>