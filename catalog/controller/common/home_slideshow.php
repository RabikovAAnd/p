<?php
class ControllerCommonHomeSlideshow extends Controller
{

  protected function index()
  {

    $this->load->model('design/banner');
    $this->load->model('tool/image');

    $this->response->addScript('catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js');

    $this->response->addStyle('catalog/view/stylesheet/slideshow.css');

    $this->data['banners'] = array();

    $results = $this->model_design_banner->getBanner( 7 );

    foreach ($results as $result)
    {
      if (file_exists(DIR_IMAGE . $result['image']))
      {
        $this->data['banners'][] = array(
          'title' => $result['title'],
          'link'  => $result['link'],
          'image' => $this->model_tool_image->resize($result['image'], $this->data['width'], $this->data['height'])
        );
      }
    }

    // Set slideshow modeule ID
    $this->data['module'] = '';

    // Render page
    $this->Render( 'module/slideshow.tpl' );

  }

}
?>
