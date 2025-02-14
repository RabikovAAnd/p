<?php 
class ControllerAccountWishList extends Controller 
{

	public function index() 
	{

    	if (!$this->customer->Is_Logged()) 
    	{

	  		$this->response->Redirect($this->url->link('account/login', '', 'SSL')); 
    	}
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		if (isset($this->request->get['remove'])) 
		{
		  
//			$key = array_search( $this->request->get['remove'], $this->session->data['wishlist'] );
			
//			if ($key !== false) 
//			{
//				unset($this->session->data['wishlist'][$key]);
//			}

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->Redirect($this->url->link('account/wishlist'));
		}

		$this->response->setTitle($this->language->get('heading_title'));	

		$this->data['heading_title'] = $this->language->get('heading_title');	

		$this->data['text_empty'] = $this->language->get('text_empty');

// ANVILEX Begin : Price on request extention
		$this->data['text_noprice'] = $this->language->get('text_noprice'); 
		$this->data['text_price'] = $this->language->get('text_price'); 
// ANVILEX End

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_stock'] = $this->language->get('column_stock');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->session->data['success'])) 
    {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
							
		$this->data['products'] = array();
/*
		foreach ($this->session->data['wishlist'] as $key => $product_id) 
		{
		  
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) { 
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
				} else {
					$image = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}
							
				if (($this->config->get('config_customer_price') && $this->customer->Is_Logged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
																			
				$this->data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'stock'      => $stock,
					'price'      => $price,		
					'special'    => $special,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
				);
			} 
			else 
			{
// Remove from wishlist
//				unset($this->session->data['wishlist'][$key]);
			}
		}	
*/
		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		
    // Add styles

		$this->children = array(
			'common/footer',
			'common/header'	
		);
	
  }
	
  //----------------------------------------------------------------------------

	public function add() 
	{
		
		$json = array();
				
		if (isset($this->request->post['product_id'])) 
		{
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) 
		{
			 
			// Add to withlist
			if ($this->customer->Is_Logged()) 
			{
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			} 
			else 
			{
				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			}
			
			$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}	
		
		$this->response->Set_Json_Output( $json );
	}	
}
?>