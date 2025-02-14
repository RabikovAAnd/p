<?php
// ANVILEX Todo:
// 1. Image link
// 2. Price must be in USD
// 3. Implement optocart feed flag
// 4. Export category
// 5. Export description
 
class ControllerFeedOctopart extends Controller {
	public function index() {
		if ($this->config->get('octopart_status')) { 
			
			// Octopart feed header
			$output .= 'manufacturer' . chr(0x09);
			$output .= 'mpn' . chr(0x09);
			$output .= 'sku' . chr(0x09);
			$output .= 'distribitor-url' . chr(0x09);
			$output .= 'quantity' . chr(0x09);
            $output .= 'price-break-1' . chr(0x09);
			$output .= 'price-usd-1' . chr(0x09);
            $output .= 'price-break-2' . chr(0x09);
			$output .= 'price-usd-2' . chr(0x09);
			$output .= 'description' . chr(0x09);
			$output .= 'datasheet-url' . chr(0x09);
			$output .= 'image-url' . chr(0x09);
			$output .= 'manufacturer-url' . chr(0x09);
			$output .= 'attributes' . chr(0x09);
			$output .= 'category' . chr(0x09);
			$output .= 'moq' . chr(0x09);
			$output .= 'order-multiple' . chr(0x09);
			$output .= 'on-order-quantity' . chr(0x09);
			$output .= 'on-order-eta' . chr(0x09);
			$output .= 'packaging' . chr(0x09);
			$output .= 'factory-lead-days' . chr(0x09);
			$output .= 'factory-pack-quantity' . chr(0x09);
			$output .= 'datacode' . chr(0x09) . chr(0x0D) . chr(0x0A);
			
			$this->load->model('catalog/category');
			
			$this->load->model('catalog/product');
			
			$this->load->model('tool/image');
			
// ANVILEX : Use some filter as google feed
			// Get only products with feedstatus = 1
			$data = array(
				'feedstatus' => '1' 
			);

			$products = $this->model_catalog_product->getProducts();
			
			foreach ($products as $product) {

				// Manufacturer field
				$output .= html_entity_decode($product['manufacturer'], ENT_QUOTES, 'UTF-8') . chr(0x09);
				
				// MPN field
				$output .= $product['model'] . chr(0x09);
				
				// SKU field
				$output .= $product['item_id'] . chr(0x09);
				
				// Distribitor URL field
				$output .= $this->url->link('product/product', 'product_id=' . $product['product_id']) . chr(0x09);
				
				// Quantity field
				$output .= $product['quantity'] . chr(0x09);
           		
           		// MOQ field
           		$output .= '1' . chr(0x09);

				// Price field           		
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
                    $output .= $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency_code, $currency_value, false) . chr(0x09);
                } else {
                    $output .= $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency_code, $currency_value, false) . chr(0x09);
                }

           		$output .= chr(0x09);
				$output .= chr(0x09);
				
				// Description field
// ANVILEX: Temporary disabled 
//				$output .= $product['description'] . chr(0x09);
				$output .= chr(0x09);
				
				$output .= chr(0x09);

				// Image field
				if ($product['image']) {
// ANVILEX: Temporary disabled
//					$output .= $this->model_tool_image->resize($product['image'], 500, 500) . '\t';
					$output .= chr(0x09);
				} else {
					$output .= chr(0x09);
				}

				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09);
				$output .= chr(0x09) . chr(0x0D) . chr(0x0A);
					
/*
// ANVILEX : Category not used yet
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
						 
						$output .= '<g:product_type>' . $string . '</g:product_type>';
					}
				}
*/
			}
			
			$this->response->Add_Header('Content-Type: text/plain');
			
      $this->response->Set_HTTP_Output($output);
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