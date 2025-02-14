<?php
class ModelCatalogProduct extends Model
{

	public function updateViewed($product_id)
	{
		$this->db->query("INSERT INTO product_impressions SET product_id='" . (int)$product_id . "', date=NOW(), ip='" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', url_source='', source= '1'");
	}

	public function updateProductViewed($product_id,$url,$ip,$source)
	{
		$this->db->query("INSERT INTO product_impressions SET product_id='" . (int)$product_id . "', date=NOW(), ip='" . $ip . "', url_source ='" . $url . "', source='" . $source . "'");
	}

	public function addSearchQuery($search_query, $product_total)
	{
		// Check for query is not empty
		if ( $search_query != '' )
		{
			// Add search query statistic into database
			$this->db->query("INSERT INTO product_search_queries SET search_query='" . $search_query . "', date=NOW(), found='" . $product_total . "'");
		}
	}

	public function getProductPriceAndAvailability($product_id)
	{

		$this->db->query("UPDATE product SET request_date = NOW() WHERE product_id='" . (int)$product_id . "'");

// ANVILEX : Disabled. Function will be depricated
//		$this->db->query("INSERT INTO product_realtime_request SET product_id='" . (int)$product_id . "', item_id='0', status='1', request_date=NOW() ON DUPLICATE KEY UPDATE request_date=NOW(), status='1'");

//		return "UPDATE product SET request_date = NOW() WHERE product_id='" . (int)$product_id . "'";
		return true;
	}

	public function getProduct($product_id)
	{

		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT ss.name FROM stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '0') AS stock_status, (SELECT wcd.unit FROM weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '0') AS weight_class, (SELECT lcd.unit FROM length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '0') AS length_class, p.sort_order FROM product p LEFT JOIN product_description pd ON (p.product_id = pd.product_id) LEFT JOIN manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '0' AND p.status = '1'");

		if ($query->num_rows) 
		{
			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['mpn'],
				'mpn'              => $query->row['mpn'],
				'item_id'          => $query->row['product_id'],
				'feedstatus'       => 0,
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'normal_price'     => $query->row['price'],
				'price'            => $query->row['price'],
				'special'          => $query->row['price'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'request_date'     => $query->row['request_date']
			);
		} else {
			return false;
		}
	}

	public function getProducts($data = array())
	{

/*
		if (!empty($data['filter_category_id']))
		{
			if (!empty($data['filter_sub_category']))
			{
				$sql .= " FROM category_path cp LEFT JOIN product_to_category p2c ON (cp.category_id = p2c.category_id)";
			}
			else
			{
				$sql .= " FROM product_to_category p2c";
			}

			if (!empty($data['filter_filter']))
			{
				$sql .= " LEFT JOIN product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN product p ON (pf.product_id = p.product_id)";
			}
			else
			{
				$sql .= " LEFT JOIN product p ON (p2c.product_id = p.product_id)";
			}
// ANVILEX Begin : Product on stock checkbox extention
		//Available
		if(!empty($data['available']))
		{
			$sql .= " AND p.quantity > 0";
		}
// ANVILEX End

		}
		else
		{
		}
*/
		$sql = "SELECT p.product_id ";
		$sql .= "FROM product p ";
		$sql .= "LEFT JOIN product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '0' AND p.status = '1'";

		if (!empty($data['filter_category_id'])) {
		if (!empty($data['filter_sub_category'])) {
			$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
			$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
		}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
// ANVILEX : "COLLATE utf8_general_ci" added to allow case insensitive search
					$implode[] = "pd.name COLLATE utf8_general_ci LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
// ANVILEX : "COLLATE utf8_general_ci" added to allow case insensitive search
					$sql .= " OR pd.description COLLATE utf8_general_ci LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) 
			{
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) 
			{
// ANVILEX : "COLLATE utf8_general_ci" added to allow case insensitive search
				$sql .= "pd.tag COLLATE utf8_general_ci LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			if (!empty($data['filter_name']))
			{
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";

		}

		if (!empty($data['filter_manufacturer_id']))
		{
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		//Available
		if(!empty($data['available']))
		{
			$sql .= " AND p.quantity > 0";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'p.sort_order',
			'p.date_added'
		);

/*
		if (isset($data['sort']) && in_array($data['sort'], $sort_data))
		{
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}
*/
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result)
		{
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getProductSpecials($data = array()) 
	{
/*

		$sql = "SELECT DISTINCT ps.product_id, (SELECT FROM product_special ps LEFT JOIN product p ON (ps.product_id = p.product_id) LEFT JOIN product_description pd ON (p.product_id = pd.product_id) WHERE p.status = '1' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
*/
		return 0;
		
	}

	public function getLatestProducts($limit) 
	{

		$product_data = $this->cache->get('product.latest.' . '0' . '.' . (int)$limit);

		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM product p WHERE p.status = '1' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.latest.' . '0' . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getPopularProducts($limit) 
	{
		$product_data = array();

		$query = $this->db->query("SELECT p.product_id FROM product p WHERE p.status = '1' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getRandomProducts($limit) 
	{
		$product_data = array();

		$query = $this->db->query("SELECT p.product_id FROM product p WHERE p.status = '1' ORDER BY RAND() LIMIT " .(int)$limit );

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getBestSellerProducts($limit) 
	{

		$product_data = $this->cache->get('product.bestseller.' . '0' . '.' . (int)$limit);

		if (!$product_data) {
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total FROM order_product op LEFT JOIN `order` o ON (op.order_id = o.order_id) LEFT JOIN `product` p ON (op.product_id = p.product_id) WHERE o.order_status_id > '0' AND p.status = '1' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.bestseller.' . '0' . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getProductRelated($product_id) 
	{
		$product_data = array();

		$query = $this->db->query("SELECT * FROM product_related pr LEFT JOIN product p ON (pr.related_id = p.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1'");

		foreach ($query->rows as $result) {
			$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
		}

		return $product_data;
	}

	public function getProductAccessoires($product_id) 
	{
		$product_data = array();

		$query = $this->db->query("SELECT * FROM product_accessoires pr LEFT JOIN product p ON (pr.accessoires_id = p.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1'");

		foreach ($query->rows as $result) {
			$product_data[$result['accessoires_id']] = $this->getProduct($result['accessoires_id']);
		}

		return $product_data;
	}

	public function getProductDocuments($product_id) 
	{
		$product_doc = array();

		$query = $this->db->query("SELECT * FROM documents WHERE product_id = '" . $product_id . "' AND language_id = '0'");

		foreach ($query->rows as $result) {
			$product_doc[] = $result;
		}

		return $product_doc;
	}

/*
	public function getCategories($product_id) 
	{
		$query = $this->db->query("SELECT * FROM product_to_category WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}
*/

}
?>