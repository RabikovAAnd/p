<?php  
class ControllerModuleCarousel extends Controller 
{

	protected function index( $setting ) 
	{
	  
	  // Global carousel module index
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->response->addScript('catalog/view/javascript/jquery/jquery.jcarousel.min.js');

		$this->response->addStyle('catalog/view/stylesheet/carousel.css');

		$this->data['limit'] = $setting['limit'];
		$this->data['scroll'] = $setting['scroll'];

		$this->data['banners'] = array();

    // Get banners
		$results = $this->model_design_banner->getBanner( $setting['banner_id'] );

		foreach ( $results as $result ) 
		{
		  
			if (file_exists(DIR_IMAGE . $result['image'])) 
			{
			  
				$this->data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
				
			}
			
		}

    // Set carousel module index
		$this->data['module'] = $module++; 

    // Render page
		$this->Render( 'module/carousel.tpl' ); 
		
	}

}
?>