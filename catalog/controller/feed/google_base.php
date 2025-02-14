<?php 
class ControllerFeedGoogleBase extends Controller {
	public function index() {
		if ($this->config->get('google_base_status')) {
			
// ANVILEX Begin : Get parameters
		if (isset($this->request->get['language'])) {
			$feed_language = $this->request->get['language'];
		} else {
			$feed_language = '1';
		}  
		
		if (isset($this->request->get['start_id'])) {
			$start_id = $this->request->get['start_id'];
		} else {
			$start_id = '1';
		}  

		if (isset($this->request->get['end_id'])) {
			$end_id = $this->request->get['end_id'];
		} else {
			$end_id = '1';
		}
// ANVILEX End

			$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
            $output .= '<channel>';
			$output .= '<title>' . $this->config->get('config_name') . '</title>'; 
			$output .= '<description>' . $this->config->get('config_meta_description') . '</description>';
			$output .= '<link>' . HTTP_SERVER . '</link>';
			
			$this->load->model('catalog/category');
			
			$this->load->model('catalog/product');
			
			$this->load->model('tool/image');
			
// ANVILEX Begin: Google shopping extention by Kretz
			// Get only products with feedstatus = 1
			$data = array(
				'feedstatus' => '1' 
			);

			$products = $this->model_catalog_product->getProducts($data);
// ANVILEX End
			
			foreach ($products as $product) {
				if ($product['description']) {
					
					$output .= '<item>';
					
//					$output .= '<title>' . $product['name'] . '</title>';
					$output .= '<title><![CDATA[' . $product['name'] . ']]></title>';
					
					$output .= '<link>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</link>';
					
//					$output .= '<description>' . $product['description'] . '</description>';
					$output .= '<description><![CDATA[' . $product['description'] . ']]></description>';
// ANVILEX Begin : Empty mahufacturer workaround
					if (isset($product['manufacturer']) && (!empty($product['manufacturer'])))
					{
//					  $output .= '<g:brand>' . html_entity_decode($product['manufacturer'], ENT_QUOTES, 'UTF-8') . '</g:brand>';
					  $output .= '<g:brand><![CDATA[' . html_entity_decode($product['manufacturer'], ENT_QUOTES, 'UTF-8') . ']]></g:brand>';
					}
					
					$output .= '<g:condition>new</g:condition>';
					$output .= '<g:id>' . $product['product_id'] . '</g:id>';
					
					if ($product['image']) {
						$output .= '<g:image_link>' . $this->model_tool_image->resize($product['image'], 500, 500) . '</g:image_link>';
					} else {
						$output .= '<g:image_link>' . $this->model_tool_image->resize('no_image.jpg', 500, 500) . '</g:image_link>';
					}
					
//					$output .= '<g:mpn>' . $product['model'] . '</g:mpn>';
					$output .= '<g:mpn><![CDATA[' . $product['model'] . ']]></g:mpn>';

					$currencies = array(
						'USD', 
						'EUR', 
						'GBP'
					);

                    if (in_array($this->currency->getCode(), $currencies)) {
                        $currency_code = $this->currency->getCode();
						$currency_value = $this->currency->getValue();
                    } else {
                        $currency_code = 'USD';
						$currency_value = $this->currency->getValue('USD');
                    }
									
					if ((float)$product['special']) {
                        $output .= '<g:price>' .  $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency_code, $currency_value, false) . '</g:price>';
                    } else {
                        $output .= '<g:price>' . $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency_code, $currency_value, false) . '</g:price>';
                    }
			   
					$categories = $this->model_catalog_product->getCategories($product['product_id']);
					
					foreach ($categories as $category) {
						$path = $this->getPath($category['category_id']);
						
						if ($path) {
							$string = '';
							
							foreach (explode('_', $path) as $path_id) {
								$category_info = $this->model_catalog_category->getCategory($path_id);
								
								if ($category_info) {
									if (!$string) {
										$string = $category_info['name'];
									} else {
										$string .= ' &gt; ' . $category_info['name'];
									}
								}
							}
						 
//							$output .= '<g:product_type>' . $string . '</g:product_type>';
							$output .= '<g:product_type><![CDATA[' . $string . ']]></g:product_type>';
						}
					}

// ANVILEX Begin : Google product category
					$output .= '<g:google_product_category>Elektronik</g:google_product_category>';
// ANVILEX End		
					$output .= '<g:quantity>' . $product['quantity'] . '</g:quantity>';
					$output .= '<g:upc>' . $product['upc'] . '</g:upc>'; 
					$output .= '<g:weight>' . $this->weight->format($product['weight'], $product['weight_class_id']) . '</g:weight>';
					$output .= '<g:availability>' . ($product['quantity'] ? 'in stock' : 'out of stock') . '</g:availability>';
					$output .= '</item>';
				}
			}
			
			$output .= '</channel>'; 
			$output .= '</rss>';	
			
			$this->response->Add_Header( 'Content-Type: application/rss+xml' );
			$this->response->Set_HTTP_Output( $output );
		}
	}
	
	protected function getPath($parent_id, $current_path = '') {
		$category_info = $this->model_catalog_category->getCategory($parent_id);
	
		if ($category_info) {
			if (!$current_path) {
				$new_path = $category_info['category_id'];
			} else {
				$new_path = $category_info['category_id'] . '_' . $current_path;
			}	
		
			$path = $this->getPath($category_info['parent_id'], $new_path);
					
			if ($path) {
				return $path;
			} else {
				return $new_path;
			}
		}
	}		
}
?>