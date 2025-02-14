<?php  
class ControllerModuleSlideshow extends Controller 
{

	protected function index($setting) 
	{
	  
		static $module = 0;
		
		$this->load->model('design/banner');
		$this->load->model('tool/image');
		
		$this->response->addScript('catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js');
		
		$this->response->addStyle('catalog/view/stylesheet/slideshow.css');

		$this->data['width'] = $setting['width'];
		$this->data['height'] = $setting['height'];
		
		$this->data['banners'] = array();
		
		if (isset($setting['banner_id'])) 
		{
			$results = $this->model_design_banner->getBanner($setting['banner_id']);
			  
			foreach ($results as $result) 
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
		}
		
		$this->data['module'] = $module++;
	
	  // Render page	
		$this->Render( 'module/slideshow.tpl' );
	
	}
	
}
?>