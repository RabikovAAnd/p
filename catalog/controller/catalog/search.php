<?php 
class ControllerCatalogSearch extends Controller 
{ 

  //----------------------------------------------------------------------------

	public function index() 
	{ 
	  		
		// Load data models
		$this->load->model( 'categories/categories' );
		$this->load->model( 'products/products' );
		$this->load->model( 'tool/image' ); 
/*
		if (isset($this->request->get['tag'])) 
		{
			$tag = $this->request->get['tag'];
		} elseif (isset($this->request->get['search'])) 
		{
			$tag = $this->request->get['search'];
		} 
		else 
		{
			$tag = '';
		}

		if (isset($this->request->get['description'])) 
		{
			$description = $this->request->get[ 'description' ];
		}
		else
		{
			$description = '';
		} 

		if (isset($this->request->get['sort'])) 
		{
			$sort = $this->request->get['sort'];
		} 
		else 
		{
			$sort = 'p.sort_order';
		}

//		$this->response->addScript( 'catalog/view/javascript/jquery/jquery.total-storage.min.js' );
		
		$url = '';
		
		if ( isset( $this->request->get['search'] ) ) 
		{
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['tag'])) 
		{
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
		}
				
		if (isset($this->request->get['description'])) 
		{
			$url .= '&description=' . $this->request->get['description'];
		}
		
		if (isset($this->request->get['sort'])) 
		{
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) 
		{
			$url .= '&order=' . $this->request->get['order'];
		}

*/
			
		// 3 Level Category Search
//		$this->data['categories'] = array();
/*					
		$categories_1 = $this->model_catalog_category->getCategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['category_id'],
						'name'        => $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'category_id' => $category_2['category_id'],	
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);					
			}
			
			$this->data['categories'][] = array(
				'category_id' => $category_1['category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}
*/

    //--------------------------------------------------------------------------
    // Process input parameters
    //--------------------------------------------------------------------------

    //--------------------------------------------------------------------------

		$this->data[ 'products' ] = array();

		if ( isset( $this->request->get[ 'query' ] ) == false ) 
		{

      //------------------------------------------------------------------------
      // ERROR: Query parameter not set
      //------------------------------------------------------------------------

      // Clear query valid flag
      $query_valid = false;

      // Set default values
      $query_string = '';
      $query = '';
      $product_total = 0;

		}
		else
		{

      // Set query valid flag
      $query_valid = false;

      $query_string = $this->request->get[ 'query' ];
      $query = '%' . $query_string . '%';
      $limit = 50;
      $page = 1;
      $start = ( $page - 1 ) * $limit;

      // Compose query
			$data = array(
        'query' => $query,
//				'sort'                => $sort,
//				'order'               => $order,
				'start' => $start,
				'limit' => $limit
//				'available' => $available 
			);

			// Get total product count referenced by search query
			$products_total = $this->model_items_items->Get_Product_Count_By_Search_Query( $data );

      // Log search results
		  $this->model_items_items->Log_Search_Results( $query, $products_total, 'EN', $this->customer->Get_ID(), $this->customer->Get_Hash() );

      // Clear products found flag
      $products_found = false;
      
      // Get products from catalog referenced by search query
      $products = $this->model_items_items->Get_Products_By_Search_Query( $data );

			foreach ( $products as $product ) 
			{
        
        // Get product information
        $product_info = $this->model_items_items->getProductInformation( $product[ 'id' ] );
          
        // Test product validity
        if ( $product_info[ 'valid' ] == true )
        {

          // Set products found flag
          $products_found = true;


          // Get price information
          $product_price_information = $this->warehouse->getProductPrice( $product[ 'id' ] );

          // Get product image
          $product_image = $this->model_items_items->getProductImage( $product[ 'id' ] );
            
          // Test image validity
          if ( $product_image[ 'valid' ] == false )
          {
         
            $product_data[ 'image_show' ] = false; 
            $product_data[ 'product_image_link' ] = "";
            $product_data[ 'product_image_name' ] = $product_info[ 'product_mpn' ];

          } 
          else
          {

            // Set image data
            $product_data[ 'image_show' ] = true; 
            $product_data[ 'product_image_link' ] = 'data:'. $product_image['type'] . ';base64, ' . base64_encode( $product_image['data'] );
            $product_data[ 'product_image_name' ] = $product_info[ 'product_mpn' ];

          }

          // Get stock information
          $product_stock_information = $this->warehouse->Get_Item_Stocked_Quantity( $product[ 'id' ] );

          // Set product data
          $product_data[ 'product_id' ] = $product_info[ 'product_id' ];
          $product_data[ 'product_href' ] = $this->url->link( 'items/info', 'product_id=' . (int)$product[ 'id' ] );
          $product_data[ 'product_mpn' ] = $product_info[ 'product_mpn' ];
          $product_data[ 'product_lifecycle' ] = $product_info[ 'product_lifecycle_id' ];
          $product_data[ 'product_stock_quantity' ] = $product_stock_information[ 'quantity' ] . ' ' . $product_info[ 'quantisation_unit_name' ];
          $product_data[ 'product_price' ] = number_format( $product_price_information[ 'price' ], 4 ) . ' EUR';
          $product_data[ 'product_link' ] = 'Info';
          $product_data[ 'manufacturer_href' ] = $this->url->link( 'manufacturers/info', 'manufacturer_id=' . (int)$product_info[ 'manufacturer_id' ] );
          $product_data[ 'manufacturer_name' ] = $product_info[ 'manufacturer_name' ];

          // Add procuct data
          $this->data[ 'products' ][] = $product_data;

        }

/*
				$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
*/
			}
/*
			$url = '';

			if (isset($this->request->get['description'])) 
			{
				$url .= '&description=' . $this->request->get['description'];
			}

			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/search', 'sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/search', 'sort=pd.name&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/search', 'sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/search', 'sort=p.price&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/search', 'sort=p.price&order=DESC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/search', 'sort=p.model&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/search', 'sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['description'])) 
			{
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['sort'])) 
			{
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) 
			{
				$url .= '&order=' . $this->request->get['order'];
			}

*/
		}	

    if ( $query_valid == false )
    {

		  $this->response->setTitle( $this->language->get( 'search_page_headline' ) );

    }
    else
    {

		  $this->response->setTitle( $this->language->get( 'search_page_headline' ) . ' - ' . $query_string );

    }

	  $this->data[ 'search_page_headline' ] = $this->language->get( 'search_page_headline' );

    $this->data[ 'catalog_search_page_query_input_value' ] = $query_string;
    $this->data[ 'catalog_search_page_query_input_placeholder' ] = $this->language->get( 'catalog_search_page_query_input_placeholder' );
    $this->data[ 'catalog_search_page_search_button_caption' ] = $this->language->get( 'catalog_search_page_search_button_caption' );

    $this->data[ 'catalog_search_page_not_found_text' ] = $this->language->get( 'catalog_search_page_not_found_text' );
    $this->data[ 'catalog_search_page_found_text' ] = $this->language->get( 'catalog_search_page_found_text' );
    $this->data[ 'catalog_search_page_show_products' ] = $products_found;
    $this->data[ 'catalog_search_page_total_products_count' ] = $products_total;

		// Set page configuration
		$this->children = array(
			'common/footer',
			'common/header'
		);
		
  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>