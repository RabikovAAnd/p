<?php
abstract class Controller
{

  // Link to registry object
  protected $registry = null;

  // Children actions
  protected $children = array();
  
  // Controller internal data. Requered for template rendering
  protected $data = array();
  
  // Controller output buffer
  protected $output = '';

  //----------------------------------------------------------------------------
  // Constructor method
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store link to registery object
    $this->registry = $registry;

  }

  //----------------------------------------------------------------------------
  // Get value by given key method
  //----------------------------------------------------------------------------

  public function __get( $key )
  {

    // Get value by key and return it
    return( $this->registry->get( $key ) );

  }

  //----------------------------------------------------------------------------
  // Set value by given key
  //----------------------------------------------------------------------------

  public function __set( $key, $value )
  {

    // Add key and value into registery
    $this->registry->set( $key, $value );

  }

  //----------------------------------------------------------------------------
  // Forward method
  //----------------------------------------------------------------------------

  protected function Forward( $route, $args = array() )
  {

    // Create new action and return it
    return( new Action( $route, $args ) );

  }

  //----------------------------------------------------------------------------
  // Get child method
  //----------------------------------------------------------------------------

  protected function getChild( $child, $args = array() )
  {

    // Create new action
    $action = new Action( $child, $args );

    // Test for child controller exists
    if ( file_exists( $action->Get_Controller_File() ) )
    {

      //------------------------------------------------------------------------
      // Child controller file found
      //------------------------------------------------------------------------

      // Load child controller class
      require_once( $action->Get_Controller_File() );

      // Get controller class name
      $class = $action->getClass();

      // Create controller class instanse
      $controller = new $class( $this->registry );

      //! @todo ANVILEX KM: Check for action method exists

      $response = $this->registry->get( 'response' );

      // Add stylesheet file
      $response->addStyle( $action->Get_Client_Stylesheet_File() );

      // Execute controllers action method
      $controller->{ $action->getMethod() }( $action->getArgs() );

//      if ( $action->getMethod() == 'index' )
//      {

//        $output = call_user_func_array( array( $controller, 'Render1' ), array( $action->Get_Template_File() ) );
        $output = $controller->{ 'Render1' }( $action->Get_Template_File() );

//        $response->Set_HTTP_Output( $output );

//      }
//      else
//      {
//        $output = '';
//      }


      // Return controller output
//      return( $controller->output );
      return( $output );

    }
    else
    {

      //------------------------------------------------------------------------
      // ERROR: Child controller file not found
      //------------------------------------------------------------------------

      // Log error
      trigger_error( 'Error: Could not load controller ' . $child );

      // Log backtrace
      foreach( debug_backtrace() as $trace )
      {

        $message = ' ';

        if( isset( $trace[ 'file' ] ) )
        {

          $message = $trace[ 'file' ] . ':' . $trace[ 'line' ] . ' ';

        }

        if( isset( $trace[ 'class' ] ) )
        {

          $message .= $trace[ 'class' ] . $trace[ 'type' ];

        }

        $message .= $trace[ 'function' ];
/*
        if( isset( $trace[ 'args' ] ) && sizeof( $trace[ 'args' ] ) > 0 )
        {

          $message .= $trace[ 'args' ];

        }
*/

        // Trigger error message
        trigger_error( $message );

      }

      // Exit
      exit();

    }

  }

  //----------------------------------------------------------------------------
  // Return child action status
  //----------------------------------------------------------------------------

  protected function hasAction( $child, $args = array() )
  {

    $action = new Action( $child, $args );

    if ( file_exists( $action->Get_Controller_File() ) )
    {

      //------------------------------------------------------------------------
      // Child controller file found
      //------------------------------------------------------------------------

      require_once( $action->Get_Controller_File() );

      $class = $action->getClass();

      $controller = new $class( $this->registry );

      if( method_exists( $controller, $action->getMethod() ) )
      {

        return( true );

      }
      else
      {

        return( false );

      }

    }
    else
    {

      //------------------------------------------------------------------------
      // ERROR: Child controller file not found
      //------------------------------------------------------------------------

      return( false );

    }

  }

  //----------------------------------------------------------------------------
  // Render page method
  //----------------------------------------------------------------------------

  public function Render1( $template = '' )
  {

    // Log
    $this->log->Log_Debug( 'Render1: ' . $template );

    //--------------------------------------------------------------------------
    // Insert child data
    //--------------------------------------------------------------------------

    // ANVILEX KM: Add messages template

    // Iterate over all children
    foreach ( $this->children as $child )
    {

      // Insert rendered child data
//      $this->data[ basename( $child ) ] = $this->getChild( $child );
      $this->data[ dirname( $child ) . '_'. basename( $child ) ] = $this->getChild( $child );

      // Log
//      $this->log->Log_Debug( 'Child: ' . $child );

    }

    //--------------------------------------------------------------------------
    // Render page using template
    //--------------------------------------------------------------------------

    // Test for template parameter setted
    if ( $template == '' )
    {

      //------------------------------------------------------------------------
      // Template parameter not set
      //------------------------------------------------------------------------

      // ANVILEX KM: Log error.
      $this->log->Log_Error( 'Page template not defined.' );

      // Log error
      trigger_error( 'Error: Template parameter not set.' );

      // ANVILEX KM: May be better to return empty or default content and not 500 error

      // Exit
      exit();

    }
    else
    {

      //------------------------------------------------------------------------
      // Template parameter setted, use it for rendering
      //------------------------------------------------------------------------

      // Log debug information
//      $this->log->Log_Debug( 'Page template file defined: ' . $template );

//*****
/*
      // Decompose template file path
      $file_path_parts = pathinfo( $template );

      //----------------------------------------------------------------------
      // Add style files to the responce object 
      //----------------------------------------------------------------------

      // Compose stylesheet file path
      $stylesheet_path_file_name = DIR_STYLESHEET_OLD . $file_path_parts[ 'dirname' ] . '/' . $file_path_parts[ 'filename' ] . '.css';

      // Log debug information
//      $this->log->Log_Debug( 'Stylesheet file: ' . $stylesheet_path_file_name );

      // Test for stylesheet file exists
      if ( file_exists( DIR_BASE . HTTP_PATH . $stylesheet_path_file_name ) === false )
      {

        //----------------------------------------------------------------------
        // Style file not found, nothing to add
        //----------------------------------------------------------------------

        // Log debug information
//        $this->log->Log_Debug( 'Stylesheet file not found.' );

      }
      else
      {

        //----------------------------------------------------------------------
        // Style file found, add styles
        //----------------------------------------------------------------------

        // Log debug information
//        $this->log->Log_Debug( 'Stylesheet file found.' );

        // Add stylesheet file to the page sylesheets files
        $this->response->addStyle( $stylesheet_path_file_name );

      }
*/
//*****

      //----------------------------------------------------------------------
      // Render page using template
      //----------------------------------------------------------------------

      // Test for template file exists
      if ( file_exists( $template ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Template file not found
        //----------------------------------------------------------------------

        // Log error message
        $this->log->Log_Error( 'Page template not found.' );

        // Log error
        trigger_error( 'Error: Could not load template: ' . $template );

        // ANVILEX KM: May be better to return empty or default content and not 500 error

        // Exit
        exit();

      }
      else
      {

        //----------------------------------------------------------------------
        // Template file found
        //----------------------------------------------------------------------

        // Extract template data into context
        extract( $this->data );

        // Start output buffering
        ob_start();

        // Insert template file
        require( $template );

        // Get output buffer contents into local variable to use later
        $this->output = ob_get_contents();

        // Clear output buffer
        ob_end_clean();

        // Return rendered content
        return( $this->output );

      }

    }

  }

  //----------------------------------------------------------------------------
  
  protected function Render( $template = '' )
  {

    //--------------------------------------------------------------------------
    // Insert child data
    //--------------------------------------------------------------------------

    // ANVILEX KM: Add messages template

    // Iterate over all children
    foreach ( $this->children as $child )
    {

      // Insert child data
//      $this->data[ basename( $child ) ] = $this->getChild( $child );
      $this->data[ dirname( $child ) . '_'. basename( $child ) ] = $this->getChild( $child );

    }

    //--------------------------------------------------------------------------
    // Render page using template
    //--------------------------------------------------------------------------

    // Test for template parameter setted
    if ( $template == '' )
    {

      //------------------------------------------------------------------------
      // Template parameter not set
      //------------------------------------------------------------------------

      // ANVILEX KM: Log error.
      $this->log->Log_Error( 'Page template not defined.' );

      // Log error
      trigger_error( 'Error: Template parameter not set.' );

      // ANVILEX KM: May be better to return empty or default content and not 500 error

      // Exit
      exit();

    }
    else
    {

      //------------------------------------------------------------------------
      // Template parameter setted, use it for rendering
      //------------------------------------------------------------------------

      // Log debug information
//      $this->log->Log_Debug( 'Page template file defined: ' . $template );

      // Decompose template file path
      $file_path_parts = pathinfo( $template );

      //----------------------------------------------------------------------
      // Add style files to the responce object 
      //----------------------------------------------------------------------

      // Compose stylesheet file path
      $stylesheet_path_file_name = DIR_STYLESHEET_OLD . $file_path_parts[ 'dirname' ] . '/' . $file_path_parts[ 'filename' ] . '.css';

      // Log debug information
//      $this->log->Log_Debug( 'Stylesheet file: ' . $stylesheet_path_file_name );

      // Test for stylesheet file exists
      if ( file_exists( DIR_BASE . HTTP_PATH . $stylesheet_path_file_name ) === false )
      {

        //----------------------------------------------------------------------
        // Style file not found, nothing to add
        //----------------------------------------------------------------------

        // Log debug information
//        $this->log->Log_Debug( 'Stylesheet file not found.' );

      }
      else
      {

        //----------------------------------------------------------------------
        // Style file found, add styles
        //----------------------------------------------------------------------

        // Log debug information
//        $this->log->Log_Debug( 'Stylesheet file found.' );

        // Add stylesheet file to the page sylesheets files
        $this->response->addStyle( $stylesheet_path_file_name );

      }

      //----------------------------------------------------------------------
      // Render page using template
      //----------------------------------------------------------------------

      // Test for template file exists
      if ( file_exists( DIR_TEMPLATE . $template ) === false )
//      if ( file_exists( $template ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Template file not found
        //----------------------------------------------------------------------

        // Log error message
        $this->log->Log_Error( 'Page template not found.' );

        // Log error
        trigger_error( 'Error: Could not load template: ' . DIR_TEMPLATE . $template );
//        trigger_error( 'Error: Could not load template: ' . $template );

        // ANVILEX KM: May be better to return empty or default content and not 500 error

        // Exit
        exit();

      }
      else
      {

        //----------------------------------------------------------------------
        // Template file found
        //----------------------------------------------------------------------

        // Log debug message
//        $this->log->Log_Debug( 'Page template file found.' );

        // Extract template data into context
        extract( $this->data );

        // Log debug message
//        $this->log->Log_Debug( 'Page template data loaded.' );

        // Start output buffering
        ob_start();

        // Log debug message
//        $this->log->Log_Debug( 'Start output buffering.' );

        // Insert template file
        require( DIR_TEMPLATE . $template );
//        require( $template );

        // Log debug message
//        $this->log->Log_Debug( 'Page template loaded.' );

        // Get output buffer contents into local variable to use later
        $this->output = ob_get_contents();

        // Log debug message
//        $this->log->Log_Debug( 'Output buffer stored.' );

        // Clear output buffer
        ob_end_clean();

        // Log debug message
//        $this->log->Log_Debug( 'Stop output buffering.' );

//        $this->log->Log_Debug( 'Data : ' . $this->output );

        // Return rendered content
        return( $this->output );

      }

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>