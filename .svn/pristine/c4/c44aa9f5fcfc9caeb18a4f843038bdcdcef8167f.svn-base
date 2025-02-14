<?php
class ControllerFeedGoogleSitemap extends Controller 
{
  
  public function index() 
  {

		$output  = '<?xml version="1.0" encoding="UTF-8"?>';
		$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
    $this->load->model('catalog/product');
		 
		$products = $this->model_catalog_product->getProducts();
		 
		foreach ($products as $product) 
    {

			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</loc>';
// ANVILEX: Implement last modified flag
//			$output .= '<lastmod>JJJJ-MM-TTTss:mmZZZ</lastmod>';			
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>1.0</priority>';
			$output .= '</url>';   
		
    }
		
    //--------------------------------------------------------------------------
    
		$this->load->model('catalog/category');
		 
		$output .= $this->getCategories(0);

    //--------------------------------------------------------------------------
    
		$this->load->model('catalog/manufacturer');
		 
		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
		 
		foreach ($manufacturers as $manufacturer) 
    {

			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';   
			
// ANVILEX: Product export disabled. All products is already exportet by direct product link.
/*			
			$products = $this->model_catalog_product->getProducts(array('filter_manufacturer_id' => $manufacturer['manufacturer_id']));
			
			foreach ($products as $product) {
			   $output .= '<url>';
			   $output .= '<loc>' . $this->url->link('product/product', 'manufacturer_id=' . $manufacturer['manufacturer_id'] . '&product_id=' . $product['product_id']) . '</loc>';
			   $output .= '<changefreq>weekly</changefreq>';
			   $output .= '<priority>1.0</priority>';
			   $output .= '</url>';   
			}         
*/         
		}

		$output .= '</urlset>';

		$this->response->Add_Header( 'Content-Type: application/xml' );
		$this->response->Set_HTTP_Output( $output );
  
  }
   
  //----------------------------------------------------------------------------

  protected function getCategories($parent_id, $current_path = '') 
  {
	  $output = '';
	  
	  $results = $this->model_catalog_category->getCategories($parent_id);
	  
	  foreach ($results as $result) {
		 if (!$current_path) {
			$new_path = $result['category_id'];
		 } else {
			$new_path = $current_path . '_' . $result['category_id'];
		 }

		 $output .= '<url>';
		 $output .= '<loc>' . $this->url->link('product/category', 'path=' . $new_path) . '</loc>';
		 $output .= '<changefreq>weekly</changefreq>';
		 $output .= '<priority>0.7</priority>';
		 $output .= '</url>';         

// ANVILEX: Product export disabled. All products is already exportet by direct product link.
/*
		 $products = $this->model_catalog_product->getProducts(array('filter_category_id' => $result['category_id']));
		 
		 foreach ($products as $product) {
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/product', 'path=' . $new_path . '&product_id=' . $product['product_id']) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>1.0</priority>';
			$output .= '</url>';   
		 }   
*/		 
		   $output .= $this->getCategories($result['category_id'], $new_path);
	  }

	  return $output;

  }      

}
?>