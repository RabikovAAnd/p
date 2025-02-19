<?php
class Response
{

  // List of headers
  private $headers = array();

  // Compression level
  private $level = 0;

  // Output buffer
  private $output = '';

  // Global objects
  private $registry;
  private $log;
  private $language;

  public $server_base = '';

  // HTTP document properties
  private $icon = 'image/common/cart.png';
  private $title = '';
  private $publisher = '';
  private $page_topic = '';
  private $page_type = '';
  private $audience = '';
  private $robots = '';
  private $description = '';
  private $keywords = '';
  private $links = array();
  private $styles = array();
  private $scripts = array();

  // Eneble logging
  private $enable_logging = false;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store registry object
    $this->registry = $registry;

  }

  //----------------------------------------------------------------------------
  // Initialise
  //----------------------------------------------------------------------------

  public function Initialise()
  {

    // Store global objects
    $this->language = $this->registry->get( 'language' );
    $this->log = $this->registry->get( 'log' );

  }

  //----------------------------------------------------------------------------
  // Get page icon
  //----------------------------------------------------------------------------

  public function getIcon()
  {

    // Get page icon
    return( $this->icon );

  }

  //----------------------------------------------------------------------------
  // Set page title
  //----------------------------------------------------------------------------

  public function setTitle( $title = '' )
  {

    // Set page title
    $this->title = $title;

  }

  //----------------------------------------------------------------------------
  // Get page title
  //----------------------------------------------------------------------------

  public function getTitle()
  {

    // Get page title
    return( $this->title );

  }

  //----------------------------------------------------------------------------
  // Set publischer
  //----------------------------------------------------------------------------

  public function setPublisher( $publisher = '' )
  {

    // Set publischer
    $this->title = $publisher;

  }

  //----------------------------------------------------------------------------
  // Get publischer
  //----------------------------------------------------------------------------

  public function getPublisher()
  {

    // Get publischer
    return( $this->publisher );

  }

  //----------------------------------------------------------------------------
  // Set page topic
  //----------------------------------------------------------------------------

  public function setPageTopic( $page_topic = '' )
  {

    // Set page topic
    $this->page_topic = $page_topic;

  }

  //----------------------------------------------------------------------------
  // Get page topic
  //----------------------------------------------------------------------------

  public function getPageTopic()
  {

    // Get page topic
    return( $this->page_topic );

  }

  //----------------------------------------------------------------------------
  // Set page type
  //----------------------------------------------------------------------------

  public function setPageType( $page_type = '' )
  {

    // Set page type
    $this->page_type = $page_type;

  }

  //----------------------------------------------------------------------------
  // Get page type
  //----------------------------------------------------------------------------

  public function getPageType()
  {

    // Get page type
    return( $this->page_type );

  }

  //----------------------------------------------------------------------------
  // Set audience
  //----------------------------------------------------------------------------

  public function setAudience( $audience = '' )
  {

    // Set audience
    $this->audience = $audience;

  }

  //----------------------------------------------------------------------------
  // Get audience
  //----------------------------------------------------------------------------

  public function getAudience()
  {

    // Get audience
    return( $this->audience );

  }

  //----------------------------------------------------------------------------
  // Set robots
  //----------------------------------------------------------------------------

  public function setRobots( $robots = '' )
  {

    // Set robots
    $this->robots = $robots;

  }

  //----------------------------------------------------------------------------
  // Get robots
  //----------------------------------------------------------------------------

  public function getRobots()
  {

    // Get robots
    return( $this->robots );

  }

  //----------------------------------------------------------------------------
  // Set description
  //----------------------------------------------------------------------------

  public function setDescription( $description = '' )
  {

    // Set description
    $this->description = $description;

  }

  //----------------------------------------------------------------------------
  // Get description
  //----------------------------------------------------------------------------

  public function getDescription()
  {

    // Get page description
    return( $this->description );

  }

  //----------------------------------------------------------------------------
  // Set keywords
  //----------------------------------------------------------------------------

  public function setKeywords( $keywords = '' )
  {

    // Set keywords
    $this->keywords = $keywords;

  }

  //----------------------------------------------------------------------------
  // Get keywords
  //----------------------------------------------------------------------------

  public function getKeywords()
  {

    // Return keywords
    return( $this->keywords );

  }

  //----------------------------------------------------------------------------
  // Add link
  //----------------------------------------------------------------------------

  public function addLink( $href = '', $rel = '', $hreflang = '' )
  {

    // Add link
    $this->links[ md5( $href ) ] = array(
      'href' => $href,
      'rel'  => $rel,
      'hreflang' => $hreflang
    );

  }

  //----------------------------------------------------------------------------
  // Get links as an array
  //----------------------------------------------------------------------------

  public function getLinks()
  {

    // Return links as array
    return( $this->links );

  }

  //----------------------------------------------------------------------------
  // Add style
  //----------------------------------------------------------------------------

  public function addStyle( $href = '', $rel = 'stylesheet', $media = 'screen' )
  {

    $this->styles[ md5( $href ) ] = array(
      'href'  => $href,
      'rel'   => $rel,
      'media' => $media
    );

  }

  //----------------------------------------------------------------------------
  // Get styles as an array
  //----------------------------------------------------------------------------

  public function getStyles()
  {

    // Return styles
    return( $this->styles );

  }

  //----------------------------------------------------------------------------
  // Add script
  //----------------------------------------------------------------------------

  public function addScript( $script = '' )
  {

    // Add script
    $this->scripts[ md5( $script ) ] = $script;

  }

  //----------------------------------------------------------------------------
  // Get scripts as an array
  //----------------------------------------------------------------------------

  public function getScripts()
  {

    // Return scripta
    return( $this->scripts );

  }

  //----------------------------------------------------------------------------
  // Add header
  //----------------------------------------------------------------------------

  public function Add_Header( $header = '' )
  {

    // Test for header string validity
    if ( $header === '' )
    {

      //------------------------------------------------------------------------
      // ERROR: Empty header
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Header string valid
      //------------------------------------------------------------------------

      // Add header
      $this->headers[] = $header;

    }

  }

  //----------------------------------------------------------------------------
  // Regirect
  //----------------------------------------------------------------------------

  public function Redirect( $url = '', $status = 302 )
  {

    // Test for URL valid
    if ( $url === '' )
    {

      //------------------------------------------------------------------------
      // ERROR: URL is empty
      //------------------------------------------------------------------------

      //! @todo ANVILEX KM: Log error.

      // Log error
      trigger_error( 'ERROR: Redirect to empty URL.' );

    }
    else
    {

      //------------------------------------------------------------------------
      // URL is not empty
      //------------------------------------------------------------------------

      // Add document header as 304 return code
      //! @todo ANVILEX KM: Chech header code setting
//      $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 304 Redirect' );

      // Set status
      header( 'Status: ' . $status );

      // Set new location
//      header( 'Location: ' . str_replace( array( '&amp;', "\n", "\r" ), array( '&', '', '' ), $url ) );
      header( 'Location: ' . $url );

    }

    // Stop script execution
    exit;

  }

  //----------------------------------------------------------------------------
  // Set compression level
  //----------------------------------------------------------------------------

  public function Set_Compression_Level( $level )
  {

    // Set compression level
    $this->level = $level;

  }

  public function Set_RAW_Output( $RAW_Output = '' )
  {

    // Set file output
    $this->output = $RAW_Output;

  }

  //----------------------------------------------------------------------------
  // Set HTML output
  //----------------------------------------------------------------------------

  public function Set_HTTP_Output( $HTTP_Output = '' )
  {

    //--------------------------------------------------------------------------
    // Compose HTML page header
    //--------------------------------------------------------------------------

    $header =
      '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
      '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . PHP_EOL .
      '<html xmlns="http://www.w3.org/1999/xhtml" dir="' . $this->language->Get_Language_Direction() . '" lang="' . $this->language->Get_Language_Code() . '">' . PHP_EOL .
      '<head>' . PHP_EOL .
      '<title>' . $this->getTitle() . '</title>' . PHP_EOL .
      '<base href="' . $this->server_base . '"/>' . PHP_EOL .
      '<meta charset="utf-8"/>' . PHP_EOL .
      '<meta http-equiv="content-type" content="text/html"/>' . PHP_EOL .
      '<meta http-equiv="language" content="' . $this->language->Get_Language_Code() . '"/>' . PHP_EOL .
      '<meta name="viewport" content="width=device-width, initial-scale=1">' . PHP_EOL .

      '<meta name="publisher" content="' . $this->getPublisher() . '"/>' . PHP_EOL .
      ( $this->getPageTopic() == '' ? '' : '<meta name="page-topic" content="' . $this->getPageTopic() . '"/>' ) . PHP_EOL .
      ( $this->getPageType() == '' ? '' : '<meta name="page-type" content="' . $this->getPageType() . '"/>' ) . PHP_EOL .
      ( $this->getAudience() == '' ? '' : '<meta name="audience" content="' . $this->getAudience() . '"/>' ) . PHP_EOL .
      ( $this->getRobots() == '' ? '' : '<meta name="robots" content="' . $this->getRobots() . '"/>' ) . PHP_EOL .
      ( $this->getDescription() == '' ? '' : '<meta name="description" content="' . $this->getDescription() . '"/>' ) . PHP_EOL .
      ( $this->getKeywords() == '' ? '' : '<meta name="keywords" content="' . $this->getKeywords() . '"/>' ) . PHP_EOL .

      ( $this->getIcon() == '' ? '' : '<link rel="icon" href="' . $this->server_base . $this->getIcon() . '"/>' ) . PHP_EOL .
      '';

    //--------------------------------------------------------------------------
    // Insert links
    //--------------------------------------------------------------------------

    $links = $this->getLinks();
    foreach ( $links as $link )
    {
      if ( $link[ 'hreflang' ] == '' )
      {
        $header = $header . '<link rel="' . $link[ 'rel' ] . '" href="' . $link[ 'href' ] . '"/>' . PHP_EOL;
      }
      else
      {
        $header = $header . '<link rel="' . $link[ 'rel' ] . '" href="' . $link[ 'href' ] . '" hreflang="' . $link[ 'hreflang' ] . '"/>' . PHP_EOL;
      }
    }

    //--------------------------------------------------------------------------
    // Insert styles
    //--------------------------------------------------------------------------

    $header = $header . '<link rel="stylesheet" type="text/css" href="catalog/view/stylesheet/common/stylesheet.css"/>' . PHP_EOL;

    $styles = $this->getStyles();
    foreach ( $styles as $style )
    {
      $header = $header . '<link rel="' . $style[ 'rel' ] . '" type="text/css" href="' . $style[ 'href' ] . '" media="' . $style[ 'media' ] . '"/>' . PHP_EOL;
    }

    $header = $header . '<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery-ui-1.12.1/jquery-ui.css"/>' . PHP_EOL;

    //--------------------------------------------------------------------------
    // Insert scripts
    //--------------------------------------------------------------------------

    $scripts = $this->getScripts();
    foreach ( $scripts as $script )
    {
      $header = $header . '<script type="text/javascript" src="' . $script . '"></script>' . PHP_EOL;
    }

    $header = $header . '<script type="text/javascript" src="catalog/view/javascript/jquery-ui-1.12.1/external/jquery/jquery.js"></script>' . PHP_EOL;
    $header = $header . '<script type="text/javascript" src="catalog/view/javascript/jquery-ui-1.12.1/jquery-ui.js"></script>' . PHP_EOL;
    $header = $header . '<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>' . PHP_EOL;
    $header = $header . '<script type="text/javascript" src="catalog/view/javascript/common.js"></script>' . PHP_EOL;

    //--------------------------------------------------------------------------
/*
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="catalog/view/stylesheet/ie7.css"/>
    <![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="catalog/view/stylesheet/ie6.css"/>
    <script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript">
      DD_belatedPNG.fix('#logo img');
    </script>
    <![endif]-->
*/
    //--------------------------------------------------------------------------
    // ??? May be not needed
    //--------------------------------------------------------------------------

    $header = $header . '<script type="text/javascript">' . PHP_EOL;
    $header = $header . '  $(function () {' . PHP_EOL;
    $header = $header . '    $(document).tooltip({' . PHP_EOL;
    $header = $header . '      track: true' . PHP_EOL;
    $header = $header . '    });' . PHP_EOL;
    $header = $header . '  });' . PHP_EOL;
    $header = $header . '</script>' . PHP_EOL;

    //--------------------------------------------------------------------------

    $header = $header . '</head>' . PHP_EOL;
    $header = $header . '<body>' . PHP_EOL;
    $header = $header . '<div id="container">' . PHP_EOL;

    //--------------------------------------------------------------------------
    // Process HTML page footer
    //--------------------------------------------------------------------------

    // Compose page footer
    $footer =
      '</div>' . PHP_EOL .
      '</body>' . PHP_EOL .
      '</html>' . PHP_EOL;

    //--------------------------------------------------------------------------
    // Process messages section
    //--------------------------------------------------------------------------

    if ( DEVELOPMENT_SHOW_MESSAGES_SECTION === false )
    {

      $messages_section = '';

    }
    else
    {

      $messages = $this->registry->get( 'messages' );

      $messages_section =
        '<div>' . PHP_EOL .
        '<div><br></div>' . PHP_EOL .
        '<div>Messages:' . '</div>' .
        '<div><br></div>' . PHP_EOL;

      foreach( $messages->Get_Messages() as $message )
      {

        //  $message[ 'module' ];
        //  $message[ 'controller' ];
        //  $message[ 'method' ];
        //  $message[ 'element' ];
        //  $message[ 'name' ];
        //  $message[ 'text' ];

//      $messages_section = $messages_section . '<div>' . $message[ 'key' ] . ' - ' . $message[ 'text' ] . '</div>' . PHP_EOL;

        $messages_section = $messages_section .
          '<div><label>' . $message[ 'key' ] . PHP_EOL .
          '<input value="' . $message[ 'text' ] . '">' . PHP_EOL .
          '</lable></div>' . PHP_EOL;

      }

      $messages_section = $messages_section . '</div>' . PHP_EOL;

    }

    //--------------------------------------------------------------------------
    // Log section
    //--------------------------------------------------------------------------

    // Get log object
    $log = $this->registry->get( 'log' );

    // Compose log area opening tag
    $log_area =
      '<div class="info-content-block list">' . PHP_EOL .
      '<h2>Page log</h2>' . PHP_EOL .
      '<div class="table-menu-style">' . PHP_EOL;

    // Iterate over all log lines
    foreach( $log->global_error_buffer as $log_line )
    {

      // Add log line
      $log_area = $log_area . '<div><span>' . $log_line . '</span></div>' . PHP_EOL;

    }

    // Compose log area closing tag
    $log_area = $log_area . PHP_EOL .
      '</div>' . PHP_EOL .
      '</div>' . PHP_EOL;
/*
      <div class="info-content-block list">
        <h2>????? ???????</h2>
          <div class="table-menu-style">
            
            <div class="endpoints-table table-menu-header">
              <span><b>????????</b></span>
              <span><b>??????</b></span>
            </div>
  
            <div class="endpoints-table table-menu-element">
              <span>account.account.index</span>
              <span></span>
              
              <div class="table-button-menu" style="display: none;">
                <a href=""title=""><button type="button">?????????</button></a>
                <button class="red-button" type="button" title="" onMouseDown="File_Form('',[['subitem_index_guid','']])">?????????</button>
              </div>
            </div>
*/
    //--------------------------------------------------------------------------
    // Compose HTML page final content
    //--------------------------------------------------------------------------

    // Set output
    $this->output =
      $header .
      $HTTP_Output .
      $messages_section .
      $log_area .
      $footer;

  }

  //----------------------------------------------------------------------------
  // Set JSON outpus
  //----------------------------------------------------------------------------

  public function Set_Json_Output( $JSON_Output = '' )
  {

    // Set encoded json output
    $this->output = json_encode( $JSON_Output );

  }

  //----------------------------------------------------------------------------
  // Set file outputs
  //----------------------------------------------------------------------------

  public function Set_File_Output( $FILE_Output = '' )
  {

    // Set headers

    // Set file output
    $this->output = $FILE_Output;

  }

  //----------------------------------------------------------------------------
  // Compress data
  //----------------------------------------------------------------------------

  private function Compress( $data, $level = 0 )
  {

    if (
      isset( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ] ) &&
     ( strpos($_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'gzip' ) !== false )
    )
    {
      $encoding = 'gzip';
    }

    if (
      isset( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ] ) &&
      ( strpos( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'x-gzip' ) !== false )
    )
    {
      $encoding = 'x-gzip';
    }

    if ( !isset( $encoding ) )
    {

      return $data;

    }

    if (
      !extension_loaded( 'zlib' ) ||
      ini_get( 'zlib.output_compression' )
    )
    {

      return $data;

    }

    if ( headers_sent() )
    {
      return $data;
    }

    if ( connection_status() )
    {
      return $data;
    }

    $this->Add_Header( 'Content-Encoding: ' . $encoding );

    return gzencode( $data, (int)$level );

  }

  //----------------------------------------------------------------------------
  // Output buffer
  //----------------------------------------------------------------------------

  public function Output()
  {

    // Test for output data present
    if ( $this->output == '' )
    {

      //------------------------------------------------------------------------
      // ERROR: No output data present.
      //------------------------------------------------------------------------

      // Log error
      $this->log->Log_Error( 'RESPONSE: Output data not present.' );

    }
    else
    {

      //------------------------------------------------------------------------
      // Output data present.
      //------------------------------------------------------------------------

//      $this->log->Log_Debug( 'RESPONSE: Output data present.' );

      //------------------------------------------------------------------------
      // Send content
      // Note: Content must be sent first
      //------------------------------------------------------------------------

      // Test for compression level set
      if ( $this->level )
      {

        //----------------------------------------------------------------------
        // Compression level defined, set compressed output
        //----------------------------------------------------------------------

//        $this->log->Log_Debug( 'RESPONSE: Compression level: ' . $this->level );

        // Send compressed data
        $output = $this->compress( $this->output, $this->level );

      }
      else
      {

        //----------------------------------------------------------------------
        // Conpression level not defined, set uncompressed output
        //----------------------------------------------------------------------

//        $this->log->Log_Debug( 'RESPONSE: Compression not set.' );

        // Send uncompressed data
        $output = $this->output;

      }

      //------------------------------------------------------------------------
      // Send headers
      //------------------------------------------------------------------------

      // Test for headers already sent
      if ( headers_sent() === true )
      {

        //----------------------------------------------------------------------
        // Headers already sent
        // NOTE: According general line not allowed to send headers before calling this method.
        //----------------------------------------------------------------------

        // Log debug message
        $this->log->Log_Debug( 'RESPONSE: Headers already sent.' );

      }
      else
      {

        //----------------------------------------------------------------------
        // Headers not sent, send all headers
        //----------------------------------------------------------------------

//        $this->log->Log_Debug( 'RESPONSE: Headers not sent.' );

        // Send all headers
        foreach ( $this->headers as $header )
        {

//          $this->log->Log_Debug( 'RESPONSE: Header: ' . $header );

          // Send header
          header( $header, true );

        }

      }

      // Send data to client
      echo( $output );

    }

  }

}
//----------------------------------------------------------------------------
// End of file
//----------------------------------------------------------------------------
?>