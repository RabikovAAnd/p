<?php 
// ANVILEX: eBay product tracking
class ControllerProductEbay extends Controller 
{

  public function index()
  {

  ignore_user_abort( true );

  // turn off gzip compression
  if ( function_exists( 'apache_setenv' ) )
  {
    apache_setenv( 'no-gzip', 1 );
  }

  ini_set('zlib.output_compression', 0);

  // turn on output buffering if necessary
  if (ob_get_level() == 0)
  {
    ob_start();
  }

  // removing any content encoding like gzip etc.
  header('Content-encoding: none', true);
  
  //check to ses if request is a POST
  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    // the GIF should not be POSTed to, so do nothing...
    echo ' ';
  } 
  else 
  {
    // return 1x1 pixel transparent gif
    header("Content-type: image/gif");
    // needed to avoid cache time on browser side
    header("Content-Length: 42");
    header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
    header("Expires: Wed, 11 Jan 2000 12:59:00 GMT");
    header("Last-Modified: Wed, 11 Jan 2006 12:59:00 GMT");
    header("Pragma: no-cache");

    echo sprintf('%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%',71,73,70,56,57,97,1,0,1,0,128,255,0,192,192,192,0,0,0,33,249,4,1,0,0,0,0,44,0,0,0,0,1,0,1,0,0,2,2,68,1,0,59);    
  }

  // flush all output buffers. No reason to make the user wait for OWA.
  ob_flush();
  flush();
  ob_end_flush();

  // DO ANALYTICS TRACKING HERE
  $this->load->model('catalog/product');
  $this->model_catalog_product->updateProductViewed(0,$_SERVER['QUERY_STRING'],$_SERVER['REMOTE_ADDR'],2);

  }
}
?>