<?php
final class Action
{

  // Endpoint base file
  protected $endpoint_base_file = '';

  // Controller class name
  protected $class = '';

  // Method name
  protected $method = '';

  // List of request arguments
  protected $args = array();
  
  // Language prefix
  protected $language = '';

  // Location prefix
  protected $location = '';

  // Endpoint
  private $endpoint = '';
  
  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $route = '', $args = array() )
  {

    // Local variables
    $path = '';
    $route_parsed_status = false;

    // Clear endpoint name
    $this->endpoint = '';

    // Explode request path to the parts
    // Request template: /module/controller.php?method
    // Request new template: location/language/module/controller.php?method
    $parts = explode( '/', str_replace( '../', '', (string)$route ) );

    // Iterate over all path chunks
    foreach ( $parts as $part )
    {

      // Add chunk to the endpoint
      $this->endpoint = $this->endpoint . $part . '.';

      // Add chunk to the path
      $path .= $part;

      // Test for the composed path directory
      if ( is_dir( DIR_APPLICATION . 'controller/' . $path ) === true )
      {

        //----------------------------------------------------------------------
        // Path is a directory
        //----------------------------------------------------------------------

        // Add separator
        $path .= '/';

        // Remove processed path chunk
        array_shift( $parts );

        // Continue processing
        continue;

      }
      else
      {

        //----------------------------------------------------------------------
        // Path is not directory
        //----------------------------------------------------------------------

        // Compose endpoint base file
        $this->endpoint_base_file = str_replace( array( '../', '..\\', '..' ), '', $path );
        
        // Test for path a file
        if ( is_file( $this->Get_Controller_File() ) === true )
        {

          //--------------------------------------------------------------------
          // Path is a file
          //--------------------------------------------------------------------

          // Compose controller class name
          $this->class = 'Controller' . preg_replace( '/[^a-zA-Z0-9]/', '', $path );

          // Remove processed path chunk (file name)
          array_shift( $parts );

          //--------------------------------------------------------------------
          // Process method name
          //--------------------------------------------------------------------

          // Extract method name
          $method = array_shift( $parts );

          // Test for method exists in the request
          if ( $method )
          {

            //------------------------------------------------------------------
            // Method exists, store it
            //------------------------------------------------------------------

            // Store method name
            $this->method = $method;

          }
          else
          {

            //------------------------------------------------------------------
            // Method name not given, use default method
            //------------------------------------------------------------------

            // Set default method name
            $this->method = 'index';

          }

          // Add method to the endpoint
          $this->endpoint = $this->endpoint . $this->method;

          // Set route parsed status
          $route_parsed_status = true;

          // Termenate processing
          break;

        }
        else
        {

          //--------------------------------------------------------------------
          // ERROR: Path is not directory or file
          //--------------------------------------------------------------------

          // ANVILEX KM: Log error
          trigger_error( 'Path is not directory or file: ' . $route, E_USER_NOTICE );

          // Set route not parsed status
          $route_parsed_status = false;

        }

      }

    }

    //--------------------------------------------------------------------------
    // Process route parsing result
    //--------------------------------------------------------------------------

    // Test for route not parsed
    if ( $route_parsed_status == false )
    {

      //------------------------------------------------------------------------
      // Route not parsed, clear controller and method names
      //------------------------------------------------------------------------

      // ANVILEX KM: Log error

      // ANVILEX KM: May be better to route to error or exception page
      // Clear file, controller and method names
      $this->class = '';
      $this->method = '';
      $this->endpoint = '';

    }

    //--------------------------------------------------------------------------
    // Process arguments
    //--------------------------------------------------------------------------

    // Test for arguments present
    if ( $args )
    {

      //------------------------------------------------------------------------
      // Arguments present
      //------------------------------------------------------------------------

      // Store arguments
      $this->args = $args;

    }

  }

  //----------------------------------------------------------------------------
  // Get endpoint string
  //----------------------------------------------------------------------------

  public function Get_Endpoint_Name()
  {

    // Return endpoint name
    return( $this->endpoint );

  }

  //----------------------------------------------------------------------------
  // Get controller file name method
  //----------------------------------------------------------------------------

  public function Get_Controller_File()
  {

    // Return controller file name
    return( DIR_APPLICATION . 'controller/' . $this->endpoint_base_file . '.php' );

  }

  //----------------------------------------------------------------------------
  // Get client side stylesheet file name method
  //----------------------------------------------------------------------------

  public function Get_Client_Stylesheet_File()
  {

    // Return stylesheet file name
    return( DIR_CLIENT_STYLESHEET . $this->endpoint_base_file . '.css' );

  }

  //----------------------------------------------------------------------------
  // Get local stylesheet file name method
  //----------------------------------------------------------------------------

  public function Get_Stylesheet_File()
  {

    // Return stylesheet file name
    return( DIR_STYLESHEET . $this->endpoint_base_file . '.css' );

  }

  //----------------------------------------------------------------------------
  // Get template file name method
  //----------------------------------------------------------------------------

  public function Get_Template_File()
  {

    // Return controller file name
    return( DIR_TEMPLATE . $this->endpoint_base_file . '.tpl' );

  }

  //----------------------------------------------------------------------------
  // Get class name method
  //----------------------------------------------------------------------------

  public function getClass()
  {

    // Return class name
    return( $this->class );

  }

  //----------------------------------------------------------------------------
  // Get method name method
  //----------------------------------------------------------------------------

  public function getMethod()
  {

    // Return method name
    return( $this->method );

  }

  //----------------------------------------------------------------------------
  // Get arguments method
  //----------------------------------------------------------------------------

  public function getArgs()
  {

    // Return arguments
    return( $this->args );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>