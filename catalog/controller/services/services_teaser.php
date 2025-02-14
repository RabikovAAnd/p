<?php  
class ControllerServicesServicesTeaser extends Controller 
{

	protected function index() 
	{

    // Load model
		$this->load->model('services/services');

    // Set headline
		$this->data['text_services_teaser_header'] = $this->language->get( 'text_services_teaser_header' );
    $this->data['href_services_teaser_header'] = $this->url->link( 'services/list', '' );

    // Prepare query data
    $data = array(
      'language_code' => 'XX',
      'limit' => 6,
      'home' => 1,
      'status' => 1
    );

    // Query SQL database
    $results = $this->model_services_services->getServiceCategories( $data );

    // Create array
    $this->data['categories'] = array();

    // Iterate over all news items
    foreach ( $results as $result )
    {

      // Get image
      $image = $this->model_services_services->getServiceImage( $result['id'] );

      // Add service category items to array
      $this->data['categories'][] = array
      (
        'headline' => $result['name'],
        'text' => $result['description'],
        'image_data' => 'data:' . $image['image_type'] . ';base64,' . base64_encode( $image['image_data'] ),
        'href' => $this->url->link( 'services/category', 'id=' . $result['id'] )
      );

    }
		
		// Render page
//		$this->Render( 'services/services_teaser.tpl' );

	}

}
?>