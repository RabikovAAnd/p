<?php
final class Loader
{

  // Registery object
  protected $registry;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Assign registry
    $this->registry = $registry;

  }

  //----------------------------------------------------------------------------
  // Get key method
  //----------------------------------------------------------------------------

  public function __get( $key )
  {

    // Return value from registry
    return( $this->registry->get( $key ) );

  }

  //----------------------------------------------------------------------------
  // Set key method
  //----------------------------------------------------------------------------

  public function __set( $key, $value )
  {

    // Store value in registry
    $this->registry->set( $key, $value );

  }

  //----------------------------------------------------------------------------
  // Load library method
  //----------------------------------------------------------------------------

  public function library( $library )
  {

    // Compose library file name
    $file = DIR_SYSTEM . 'library/' . $library . '.php';

    // Test for file exist
    if ( file_exists( $file ) )
    {

      //------------------------------------------------------------------------
      // Library file exists
      //------------------------------------------------------------------------

      // Include library
      include_once( $file );

    }
    else
    {

      //------------------------------------------------------------------------
      // ERROR: Library not found
      //------------------------------------------------------------------------

      // Trigger error
      trigger_error( 'Error: Could not load library: ' . $library );

      // ANVILEX KM: May be better not terminate script

      // Terminate execution
      exit();

    }

  }

  //----------------------------------------------------------------------------
  // Load helper method
  //----------------------------------------------------------------------------

  public function helper( $helper )
  {

    // Compose helper file name
    $file = DIR_SYSTEM . 'helper/' . $helper . '.php';

    // Test for helper file exists
    if ( file_exists( $file ) )
    {

      //------------------------------------------------------------------------
      // Helper file exists, include it
      //------------------------------------------------------------------------

      // Include helper file
      include_once( $file );

    }
    else
    {

      //------------------------------------------------------------------------
      // Helper file not found
      //------------------------------------------------------------------------

      // Trigger error
      trigger_error( 'Error: Could not load helper: ' . $helper );

      // Terminate execution
      exit();

    }

  }

  //----------------------------------------------------------------------------
  // Load library model method
  //----------------------------------------------------------------------------

  public function library_model( $model )
  {

    // Compose file name
    $file = DIR_SYSTEM . 'library/' . $model . '.php';

    // Compose model class name
    $class = 'Model' . preg_replace( '/[^a-zA-Z0-9]/', '', $model );

    // Test for library model file exists
    if ( file_exists( $file ) )
    {

      //------------------------------------------------------------------------
      // Model file exists
      //------------------------------------------------------------------------

      // Include model file
      include_once( $file );

      // Register model class in registry
      $this->registry->set( 'model_' . str_replace( '/', '_', $model ), new $class( $this->registry ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Model file not found
      //------------------------------------------------------------------------

      // Trigger error
      trigger_error( 'ERROR: Could not load model : ' . $model );

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

        // Trigger error
        trigger_error( $message );

      }

      // Terminate execution
      exit();

    }

  }

  //----------------------------------------------------------------------------
  // Load model method
  //----------------------------------------------------------------------------

  public function model( $model )
  {

    // Compose class file name
    $file = DIR_APPLICATION . 'model/' . $model . '.php';

    // Compose class name
    $class = 'Model' . preg_replace( '/[^a-zA-Z0-9]/', '', $model );

    // Test for file exists
    if ( file_exists( $file ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Model file not found
      //------------------------------------------------------------------------

      // Trigger error
      trigger_error( 'ERROR: Could not load model : ' . $model );

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

        // Trigger error
        trigger_error( $message );

      }

      // Terminate execution
      exit();

    }
    else
    {

      //------------------------------------------------------------------------
      // Model file exists, use it
      //------------------------------------------------------------------------

      // Include model file
      include_once( $file );

      // Create model class and to registry
      $this->registry->set( 'model_' . str_replace( '/', '_', $model ), new $class( $this->registry ) );

    }

  }

  //----------------------------------------------------------------------------
  // Load data model
  //----------------------------------------------------------------------------

  public function data_model( $model, $database )
  {

    // Compose class file name
    $file = DIR_APPLICATION . 'model/' . $model . '.php';

    // Compose class name
    $class = 'Model' . preg_replace( '/[^a-zA-Z0-9]/', '', $model );

    // Test for file exists
    if ( file_exists( $file ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Model file not found
      //------------------------------------------------------------------------

      // Trigger error
      trigger_error( 'ERROR: Could not load model : ' . $model );

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

        // Trigger error
        trigger_error( $message );

      }

      // Terminate execution
      exit();

    }
    else
    {

      //------------------------------------------------------------------------
      // Model file exists, use it
      //------------------------------------------------------------------------

      // Include model file
      include_once( $file );

      // Create model class and to registry
      $this->registry->set( 'model_' . str_replace( '/', '_', $model ), new $class( $this->registry, $database ) );

    }

  }

  //----------------------------------------------------------------------------
  // Load database
  //----------------------------------------------------------------------------

  public function database( $driver, $hostname, $username, $password, $database )
  {

    // Compose database file name
    $file  = DIR_SYSTEM . 'database/' . $driver . '.php';

    // Compose database class name
    $class = 'Database' . preg_replace( '/[^a-zA-Z0-9]/', '', $driver );

    // Test for database file exists
    if ( file_exists( $file ) )
    {

      //------------------------------------------------------------------------
      // Database filr exists, use it
      //------------------------------------------------------------------------

      // Include database file
      include_once( $file );

      // Retister database in registery
      $this->registry->set( str_replace( '/', '_', $driver ), new $class( $hostname, $username, $password, $database ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Database file not found
      //------------------------------------------------------------------------

      // Trigger error
      trigger_error('Error: Could not load database driver: ' . $driver );

      // Terminate execution
      exit();

    }

  }

  //----------------------------------------------------------------------------
  // Load configuration
  //----------------------------------------------------------------------------

  public function config( $config )
  {

    // Load configuration
    $this->config->load( $config );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>