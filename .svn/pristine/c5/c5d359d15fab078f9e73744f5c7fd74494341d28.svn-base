<?php
class ControllerCommonLog extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    // Set page headline
    $this->data[ 'log_lines' ] = $this->log->global_error_buffer;

    //--------------------------------------------------------------------------
/*
    // Set document title
    $this->response->setTitle( '' );
    $this->response->setDescription( '' );
    $this->response->setKeywords( '' );
    
    // Add style

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );
*/
    // Set header 404 respone code
//    $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 404 not found' );

    // Render page
//    $this->response->Set_HTTP_Output( $this->Render( 'common/log.tpl' ) );
    $this->Render( 'common/log.tpl' );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>