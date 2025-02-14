<?php
class ControllerErrorNotFound extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for route parameter setted
    if ( isset( $this->request->get[ 'route' ] ) )
    {

      // Get request data
      $data = $this->request->get;

      // Unset route parameter
      unset( $data[ '_route_' ] );

      // Get route data from request
      $route = $data[ 'route' ];

      // Unset route data
      unset( $data[ 'route' ] );
/*
ANVILEX KM: Not requered

      $url = '';

      if ( $data )
      {

        $url = '&' . urldecode( http_build_query( $data, '', '&' ) );

      }

      if ( isset( $this->request->server[ 'https' ] ) && ( ( $this->request->server[ 'https' ] == 'on' ) || ( $this->request->server[ 'https' ] == '1' ) ) )
      {

        $connection = 'ssl';

      }
      else
      {

        $connection = 'nonssl';

      }
*/
    }

    // Set page headline
    $this->data[ 'heading_title' ] = $this->language->get( 'common_error404_page_heading' );

    // Set error message
    $this->data[ 'message_text' ] = $this->language->get( 'common_error404_page_message' );

    //--------------------------------------------------------------------------

    // Set document title
    $this->response->setTitle( $this->language->get( 'common_error404_document_title' ) );
    $this->response->setDescription( '' );
    $this->response->setKeywords( '' );
    
    // Add style

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

    // Set header 404 respone code
    $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 404 not found' );

  }
 
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>